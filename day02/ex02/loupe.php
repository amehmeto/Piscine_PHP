#!/usr/bin/php
<?php

function capitalizeSecondGroup($matches){
    $matches[2] = strtoupper($matches[2]);

    $transformed_pattern = "";
    for($i = 1 ; isset($matches[$i]) ; $i++)
        $transformed_pattern  .= $matches[$i];
    return $transformed_pattern;
}

function capitalizeInsideLink($matches){
    $transformed_pattern = capitalizeSecondGroup($matches);
    $pattern_title = '/( title=")([^">]*)(")/';
    $transformed_pattern  = preg_replace_callback(
            $pattern_title,
        "capitalizeSecondGroup",
            $transformed_pattern
    );
	return $transformed_pattern ;
}

function matchInsideLink($pattern, $line){
	return preg_replace_callback(
				$pattern,
        "capitalizeInsideLink",
				$line
			);
}

function transformLine($line)
{
	$pattern_tags = '/(<a [^>]*>)([^<]*)(.*)(<\/a>)/';

	return matchInsideLink($pattern_tags, $line);
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
