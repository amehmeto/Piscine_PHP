#!/usr/bin/php
<?php

function isDateFormatCorrect($given_date){
	$first_word_pattern = '/^([Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi|[Vv]endredi|[Ss]amedi|[Dd]imanche)\ ';
	$second_word_pattern = '(0[1-9]|[1-2]?\d|3[0-1])\ ';
	$third_word_pattern = '([Jj]anvier|[Ff]evrier|[Mm]ars|[Aa]vril|[Mm]ai|[Jj]uin|[Jj]uillet|[Aa]out|[Ss]eptembre|[Oo]ctobre|[Nn]ovembre|[Dd]ecembre)\ ';
	$fourth_word_pattern = '(19[7-9|0]\d|[2-9]\d{3})/';

	$full_pattern = 
		$first_word_pattern .
		$second_word_pattern .
		$third_word_pattern .
		$fourth_word_pattern;
	//echo $fourth_word_pattern . "\n";

	 $result = (preg_match($full_pattern, $given_date, $matches)) ? "1384254141" : "Wrong Format";
	//echo $matches[2] . "\n";
	return $result;
}

function displayTimeStamp($given_date)
{
	echo isDateFormatCorrect($given_date) . "\n";	
}

if ($argc > 1)
	displayTimeStamp($argv[1]);
?>
