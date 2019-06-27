#!/usr/bin/php -n
<?php

function add($matches)
{
	return $matches[1] + $matches[3];
}

function substract($matches)
{
	return $matches[1] - $matches[3];
}

function multiply($matches)
{
	return $matches[1] * $matches[3];
}

function divide($matches)
{
	return $matches[1] / $matches[3];
}

function modulo($matches)
{
	return $matches[1] % $matches[3];
}

if ($argc == 2)
{
	if (!preg_match(
		"/^\s*(\d+)\s*([\+\-\*\/\%])\s*(\d+)\s*$/i",
		$argv[1],
		$matches
	))
	{
		exit("Syntax Error\n");
	}
	if ($matches[2] === '+')
		echo add($matches) . "\n";
	if ($matches[2] === '-')
		echo substract($matches) . "\n";
	if ($matches[2] === '*')
		echo multiply($matches) . "\n";
	if ($matches[2] === '/')
		echo divide($matches) . "\n";
	if ($matches[2] === '%')
		echo modulo($matches) . "\n";
}
else
	echo "Incorrect Parameters\n";
?>
