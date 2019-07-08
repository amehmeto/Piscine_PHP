#!/usr/bin/php
<?php

function trimInnerWhiteSpaces($string){
	$pattern = '/\s+/';
	$replacement = ' ';

	return preg_replace($pattern, $replacement, $string);
}

function trimFirstWhiteSpaces($string){
	$pattern = '/^\s+/';
	$replacement = '';

	return preg_replace($pattern, $replacement, $string);
}

function trimLastWhiteSpaces($string){
	$pattern = '/\s+$/';
	$replacement = '';

	return preg_replace($pattern, $replacement, $string);
}
function trimTabulations($argv)
{
	$string = $argv[1];

	$trimmed_sentence = trimInnerWhiteSpaces($string); 
	$trimmed_sentence = trimFirstWhiteSpaces($trimmed_sentence);
	$trimmed_sentence = trimLastWhiteSpaces($trimmed_sentence);
	echo $trimmed_sentence . "\n";
}


if ($argc > 1)
	trimTabulations($argv);

?>
