#!/usr/bin/php
<?php

function capitalizePattern($matches){

	return $matches[1] . strtoupper($matches[2]) . $matches[3] . $matches[4];
}

function match($pattern, $line){
	$transformed_pattern = preg_replace_callback(
				$pattern,
        "capitalizePattern",
				$line
			);

	return $transformed_pattern;
}

function transformLine($line)
{
	$pattern_tags = '/(<a [^>]*>)([^<]*)(.*)(<\/a>)/';
	$pattern_title = '/( title=")([^">]*)(")/';

	$line = match($pattern_tags, $line);
	$line = match($pattern_title, $line);

	return $line;
}

function displayFile($file_path){
    $HTML_file = file($file_path);

	foreach ($HTML_file as $line)
		echo transformLine($line);
}

if ($argc > 1)
	if (file_exists($argv[1]))
		displayFile($argv[1]);
?>
