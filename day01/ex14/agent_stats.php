#!/usr/bin/php
<?php

function updateTempCalculation($grade){
	static $total_effectif = 0;
	static $grad_sum = 0;

	$grad_sum += $grade;
	$total_effectif++;
	return $grad_sum / $total_effectif;
}

function dataIsAGradeNotCorrectedByMoulinette($grade_line){
	if (is_numeric($grade_line[1]) AND $grade_line[2] !== 'moulinette')
		return TRUE;
	return FALSE;	
}

function calculateAverage($grades){
	foreach($grades as $grade_line)
		if (dataIsAGradeNotCorrectedByMoulinette($grade_line))
			$average = updateTempCalculation($grade_line[1]);
	return $average;
}

function displayAverage($grades){
	echo calculateAverage($grades) . "\n";
}

function displayUserAverage($grades, $user){
	echo $user . ':';
	displayAverage($grades);
}

function displayUsersAverages($grades){
	$user = $grades[0][0];
	$i = 0;
	while (isset($grades[$i]) AND $grades[$i][0] === $user)
		$user_grades[] = $grades[$i++];
	displayUserAverage($user_grades, $user);
	if (isset($grades[$i]))
	{
		$user = $grades[$i][0];
		while (isset($grades[$i]) AND $grades[$i][0] === $user)
			$user_grades2[] = $grades[$i++];
		displayUserAverage($user_grades2, $user);
	}
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
}

?>
