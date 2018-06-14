#!/usr/bin/php -n
<?php
function epur_str($str)
{
	$tmp = preg_split("/[\s,]+/", trim($str));
	for ($i = 1 ; $tmp[$i] ; $i++)
		echo "$tmp[$i] ";
	if ($tmp[0])
		echo $tmp[0];
	echo "\n";
}
if ($argc > 1)
	epur_str($argv[1]);
?>
