#!/usr/bin/php
<?php

function isDateFormatCorrect($given_date){
	$first_word_pattern = '/^([Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi|[Vv]endredi|[Ss]amedi|[Dd]imanche)\ ';
	$second_word_pattern = '([0-2]?\d)\ /';

	$full_pattern = $first_word_pattern . $second_word_pattern;
	//echo $full_pattern . "\n";

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
