#!/usr/bin/php
<?php

function generatePattern(){
	$first_word_pattern = '/^([Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi|[Vv]endredi|[Ss]amedi|[Dd]imanche)\ ';
	$second_word_pattern = '(0[1-9]|[1-2]?\d|3[0-1])\ ';
	$third_word_pattern = '([Jj]anvier|[Ff]evrier|[Mm]ars|[Aa]vril|[Mm]ai|[Jj]uin|[Jj]uillet|[Aa]out|[Ss]eptembre|[Oo]ctobre|[Nn]ovembre|[Dd]ecembre)\ ';
	$fourth_word_pattern = '(19[7-9|0]\d|[2-9]\d{3})\ ';
	$fifth_word_pattern = '(([0-1]\d|2[1-4]):([0-5]\d):([0-5]\d))$/';

	$full_pattern = $first_word_pattern . $second_word_pattern .
		$third_word_pattern . $fourth_word_pattern .
		$fifth_word_pattern;

	return $full_pattern;
}

function convertMonthNameIntoNumber($month_name)
{
	$month_name = strtolower($month_name);

	$month_to_num_equivalent = array(
		'janvier' => 1,
		'fevrier' => 2,
		'mars' => 3,
		'avril' => 4,
		'mai' => 5,
		'juin' => 6,
		'juillet' => 7,
		'aout' => 8,
		'septembre' => 9,
		'octobre' => 10,
		'novembre' => 11,
		'decembre' => 12
	);

	return $month_to_num_equivalent[$month_name];
}

function generateTimestamp($matches){
	$hour = $matches[6];
	$minute = $matches[7];
	$second = $matches[8];
	$month = convertMonthNameIntoNumber($matches[3]);
	$day = $matches[2];
	$year = $matches[4];

	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	return $timestamp;
}

function isDateFormatCorrect($given_date){
	$pattern = generatePattern();
	return (preg_match($pattern, $given_date, $matches)) ? 
		generateTimestamp($matches): "Wrong Format";
}

function displayTimeStamp($given_date)
{
	echo isDateFormatCorrect($given_date) . "\n";	
}

if ($argc > 1)
	displayTimeStamp($argv[1]);
?>
