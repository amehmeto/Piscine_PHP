#!/usr/bin/php
<?php

function upperTitleAttributeAndTagContentOnly($matches){
	return $matches[1] . strtoupper($matches[2]) . $matches[3];
}

function match($pattern, $line){
	return preg_replace_callback(
				$pattern, 
				"upperTitleAttributeAndTagContentOnly",
				$line
			);
}

function transformLine($line)
{
	$pattern_ahref = '/(<a [^>]*>)([^<]*)(<)/';
	$pattern_title = '/( title=")([^">]*)(")/'; 

	$line = match($pattern_ahref, $line);
	$line = match($pattern_title, $line);

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
