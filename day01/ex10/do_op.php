#!/usr/bin/php -n
<?php
if ($argc == 4 && is_numeric($argv[1]) && is_numeric($argv[3]))
{
	$argv[1] = trim($argv[1]);
	$argv[2] = trim($argv[2]);
	$argv[3] = trim($argv[3]);
	if ($argv[2] == "+")
	{
		$result = $argv[1] + $argv[3];
		echo "$result\n";
	}
	if ($argv[2] == "-")
	{
		$result = $argv[1] - $argv[3];
		echo "$result\n";
	}
	if ($argv[2] == "/")
	{
		$result = $argv[1] / $argv[3];
		echo "$result\n";
	}
	if ($argv[2] == "%")
	{
		$result = $argv[1] % $argv[3];
		echo "$result\n";
	}
	if ($argv[2] == "*")
	{
		$result = $argv[1] * $argv[3];
		echo "$result\n";
	}
}
else
	echo "Incorrect Parameters\n";
?>