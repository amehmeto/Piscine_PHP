#!/usr/bin/php
<?php

function startWithDayName($given_date){
	$pattern = '/^([Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi|[V|v]endredi|[Ss]amedi|[Dd]imanche)\ (\d{1,2})\ /';

	 return (preg_match($pattern, $given_date)) ? "1384254141" : "Wrong Format";
}

function displayTimeStamp($given_date)
{
	echo startWithDayName($given_date) . "\n";	
}

if ($argc > 1)
	displayTimeStamp($argv[1]);
?>
