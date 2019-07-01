#!/usr/bin/php
<?php

function updateTempCalculation($grad){
	static $total_effectif = 0;
	static $grad_sum = 0;
	$average;

	$grad_sum += $grad;
	$total_effectif++;
	$average = $grad_sum / $total_effectif;

	return $average;
}

function dataIsAGradNotCorrectedByMoulinette($data)
{
	if (is_numeric($data[1]) AND $data[2] !== 'moulinette')
		return TRUE;
	return FALSE;	
}

function dataIsAGradFromSpecificUser($data){
	if (is_numeric($data[1]) AND $data[0])
		return TRUE;
	return FALSE;
}

function dataIsRelevant($data)
{
	$averages['all'] = NULL;

	if (dataIsAGradNotCorrectedByMoulinette($data))
	{
		$averages['all'] = updateTempCalculation($data[1]);
		return $averages;
	}
	/*
	   if (dataIsAGradFromSpecificUser($data))
	   {
	   $averages[$data[0]] = updateTempCalculation($data[1]);
	   echo $data[0] . ':' . $averages[$data[0]] . "\n";
	   return $averages;
	   }
	 */
	return NULL; 
}

function calculateAverages($grades){
	$averages = NULL;

	foreach($grades as $grade)
	{
		$data = explode(';', $grade);
		if (dataIsRelevant($data))
			$averages = dataIsRelevant($data);
	}
	return $averages;
}

function displayAverage($grades){
	$averages = calculateAverages($grades);
	echo $averages['all'] . "\n";
}

if ($argc == 2) {
	$grades = file('php://stdin');
	unset($grades[0]);
	asort($grades);
	if ($argv[1] === 'moyenne')
		displayAverage($grades);
	if ($argv[1] === 'moyenne_user')
		displayUserAverage();
}

?>
