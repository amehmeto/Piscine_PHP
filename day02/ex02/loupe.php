#!/usr/bin/php
<?php
function matchTitleAttribute($line)
{
	$pattern = '/(<a [^>]*title="?)([^">]*)("?[^>]*>)([^<]*)/';
	$replacement = NULL;

	preg_match($pattern, $line, $matches);
	if ($matches AND $matches[1])
	{
		$replacement[1] = strtoupper($matches[1]);
	//	echo '$replacement = ' . $replacement ."\n";
	}
	$result = preg_replace_callback(
			$pattern, 
			function ($matches){
				return $matches[1] .
					strtoupper($matches[2]) .
					$matches[3] .
					strtoupper($matches[4]);
			},
			$line);
	//$result = preg_replace($pattern, strtoupper('$2'), $line);
	//echo "\n" . '$result = '. $result . "\n";

	return $result;
}

function displayFile($HTML_file){
	foreach ($HTML_file as $line)
		echo matchTitleAttribute($line);
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
