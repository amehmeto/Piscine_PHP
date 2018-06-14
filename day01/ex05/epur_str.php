#!/usr/bin/php -n
<?php
if ($argc == 2)
	epur_str($argv[1]);
else
	echo "usage incorrect";

function epur_str($str)
{
	$tmp = preg_split("/[\s,]+/", trim($str));
	if ($tmp[0])
		echo $tmp[0];
	for ($i = 1 ; $tmp[$i] ; $i++)
		echo " $tmp[$i]";
	echo "\n";
}
?>
