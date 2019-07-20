#!/usr/bin/php
<?php

function capitalizeTitleAttributes($matches){
    return $matches[1] . strtoupper($matches[2]) . $matches[3];
}

function capitalizeInsideLink($matches){

    $matches[2] = strtoupper($matches[2]);
    $transformed_pattern = "";
    for($i = 1 ; isset($matches[$i]) ; $i++)
        $transformed_pattern  .= $matches[$i];
    //echo "\n\n### Transformed line ###\n" . $transformed_pattern  . "\n\n";
    //echo $transformed_pattern ;
    $pattern_title = '/( title=")([^">]*)(")/';
    $transformed_pattern  = preg_replace_callback(
            $pattern_title,
            "capitalizeTitleAttributes",
            $transformed_pattern
    );
    //echo "\n\n### TRANSFORMED LINE ###\n" . $transformed_pattern  . "\n\n";
	return $transformed_pattern ;
}

function match($pattern, $line){
	$transformed_pattern = preg_replace_callback(
				$pattern,
        "capitalizeInsideLink",
				$line
			);

	return $transformed_pattern;
}

function transformLine($line)
{
	$pattern_tags = '/(<a [^>]*>)([^<]*)(.*)(<\/a>)/';

	$line = match($pattern_tags, $line);

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
