#!/usr/bin/php
<?php

function upperTitleAttributeAndTagContentOnly($matches){
	return $matches[1] . strtoupper($matches[2]) . $matches[3];
}

function matchTitleAttribute($pattern, $line){
	return preg_replace_callback(
				$pattern, 
				"upperTitleAttributeAndTagContentOnly",
				$line
			);
}

function transformLine($line)
{
	$pattern[0] = '/(<a [^>]*>)([^<]*)(<)/';
	$pattern[1] = '/( title="?)([^">]*)("?)/'; 

	$line = matchTitleAttribute($pattern[0], $line);
	$line = matchTitleAttribute($pattern[1], $line);

	return $line;
}

function displayFile($HTML_file){
	foreach ($HTML_file as $line)
		echo transformLine($line);
}

if ($argc > 1)
{
	if (file_exists($argv[1]))
	{
		$HTML_file = file($argv[1]);
		displayFile($HTML_file);
	}
}
?>
