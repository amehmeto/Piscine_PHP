#!/usr/bin/php
<?php

function updateTempCalculation($grade, $tempCalculations){
	$tempCalculations['grades_sum'] += $grade;
	$tempCalculations['total_effectif']++;
	$tempCalculations['temp_average'] = $tempCalculations['grades_sum'] / $tempCalculations['total_effectif'];
	return $tempCalculations;
}

function gradeNotCorrectedByMoulinette($grade_line){
	if (is_numeric($grade_line[1]) AND $grade_line[2] !== 'moulinette')
		return TRUE;
	return FALSE;	
}

function gradeCorrectedByMoulinette($grade_line){
	if (is_numeric($grade_line[1]) AND $grade_line[2] === 'moulinette')
		return TRUE;
	return FALSE;	
}

function calculateAverage($grades, $moulinette=FALSE){
	$tempCalculations = array(
		'total_effectif' => 0,
		'grades_sum' => 0,
		'temp_average' => 0
	);
	$tempCalculationsM = array(
		'total_effectif' => 0,
		'grades_sum' => 0,
		'temp_average' => 0
	);
	foreach($grades as $grade_line)
	{
		if ($moulinette AND gradeCorrectedByMoulinette($grade_line))
			$tempCalculationsM = updateTempCalculation($grade_line[1], $tempCalculationsM);
		if (gradeNotCorrectedByMoulinette($grade_line))
			$tempCalculations = updateTempCalculation($grade_line[1], $tempCalculations);
	}
	if ($moulinette)
		return $tempCalculations['temp_average'] - $tempCalculationsM['temp_average'] ;
	return $tempCalculations['temp_average'];
}

function displayAverage($grades, $moulinette=FALSE){
	echo calculateAverage($grades, $moulinette) . "\n";
}

function displayUserAverage($grades, $user, $moulinette=FALSE){
	echo $user . ':';
	displayAverage($grades, $moulinette);
}

function displayUsersAverages($grades, $moulinette=FALSE){
	$i = 0;
	while (isset($grades[$i]))
	{
		$user = $grades[$i][0];
		$user_grades = array();
		while (isset($grades[$i]) AND $grades[$i][0] === $user)
			$user_grades[] = $grades[$i++];
		displayUserAverage($user_grades, $user, $moulinette);
	}
}

function displayStandardDeviationWithMoulinette($grades){
	displayUsersAverages($grades, 'adam_e', TRUE);
}

function parseCSVgrades($original_CSV_grades){
	unset($original_CSV_grades[0]);
	asort($original_CSV_grades);
	foreach($original_CSV_grades as $grade_line)
	{
		$grade_line_exploded = explode(';', $grade_line);
		$grades[] = $grade_line_exploded;
	}
	return $grades;
}

if ($argc == 2) {
	$grades = parseCSVgrades(file('php://stdin'));
	if ($argv[1] === 'moyenne')
		displayAverage($grades);
	if ($argv[1] === 'moyenne_user')
		displayUsersAverages($grades);
	if ($argv[1] === 'ecart_moulinette')
		displayStandardDeviationWithMoulinette($grades);
}

?>
