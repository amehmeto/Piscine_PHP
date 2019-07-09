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

function isDateFormatCorrect($given_date){
	$pattern = generatePattern();
	return (preg_match($pattern, $given_date, $matches)) ? "1384254141" : "Wrong Format";
}

function displayTimeStamp($given_date)
{
	echo isDateFormatCorrect($given_date) . "\n";	
}

if ($argc > 1)
	displayTimeStamp($argv[1]);
?>
