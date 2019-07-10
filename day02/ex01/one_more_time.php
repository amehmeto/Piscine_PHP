#!/usr/bin/php
<?php

function generatePattern(){
	$day_name_pattern = '/^([Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi|[Vv]endredi|[Ss]amedi|[Dd]imanche)\ ';
	$day_number_pattern = '(0[1-9]|[1-2]?\d|3[0-1])\ ';
	$month_pattern = '([Jj]anvier|[Ff]evrier|[Mm]ars|[Aa]vril|[Mm]ai|[Jj]uin|[Jj]uillet|[Aa]out|[Ss]eptembre|[Oo]ctobre|[Nn]ovembre|[Dd]ecembre)\ ';
	$year_pattern = '(19[7-9|0]\d|20[0-2]\d|203[0-8])\ ';
	$hours_minutes_secondes_pattern= '(([0-1]\d|2[1-4]):([0-5]\d):([0-5]\d))$/';

	$full_pattern = $day_name_pattern . $day_number_pattern .
		$month_pattern . $year_pattern .
		$hours_minutes_secondes_pattern;

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

function isUnderTimestampMinLimit($matches){
	return ($matches[4] < 1970);
}

function isAboveTimestampMaxLimit($matches){
	$max_year = 2038;
	$max_month = 1;
	$max_day = 19;
	$max_hour = 4;
	$max_min = 14;
	$max_second = 7;

	if ($matches[4] > $max_year)
		return TRUE;
	$month = convertMonthNameIntoNumber($matches[3]);
	if ($matches[4] == $max_year AND $month > 1)
		return TRUE;	
	if ($matches[4] == $max_year AND $month == $max_month AND $matches[2] > $max_day)
		return TRUE;
	if ($matches[4] == $max_year AND $month == $max_month AND $matches[2] == $max_day AND $matches[6] > $max_hour)
		return TRUE;
	if ($matches[4] == $max_year AND $month == $max_month AND $matches[2] == $max_day AND $matches[6] == $max_hour AND $matches[7] > $max_min)
		return TRUE;
	if ($matches[4] == $max_year AND $month == $max_month AND $matches[2] == $max_day AND $matches[6] == $max_hour AND $matches[7] == $max_min AND $matches[8] > $max_second)
		return TRUE;
	return FALSE;
}
function matchesIsTimestampConsistent($matches)
{
	if (isUnderTimestampMinLimit($matches))
		return FALSE;
	if (isAboveTimestampMaxLimit($matches))
		return FALSE;
	if (isDayNameConsistentWithTimestamp($matches))
		return FALSE;
	return TRUE;
	
}

function isDateFormatCorrect($given_date){
	$pattern = generatePattern();
	return (preg_match($pattern, $given_date, $matches) AND matchesIsTimestampConsistent($matches)) ? 
		generateTimestamp($matches): "Wrong Format";
}

function displayTimeStamp($given_date)
{
	echo isDateFormatCorrect($given_date) . "\n";	
}

if ($argc > 1)
	displayTimeStamp($argv[1]);
?>
