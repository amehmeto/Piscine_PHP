#!/usr/bin/php -n
<?php
function epur_str($str)
{
	$rslt = [];
	$tmp = preg_split("/[\s,]+/", trim($str));
	if ($tmp[0])
		array_push($rslt, $tmp[0]); 
	for ($i = 1 ; $tmp[$i] ; $i++)
		array_push($rslt, $tmp[$i]); 
	return $rslt;
}

$tab = [];
for ($i = 1 ; $argv[$i] ; $i++)
	$tab = array_merge($tab, epur_str($argv[$i]));

sort($tab);
foreach($tab as $elem)
	echo $elem."\n";
?>
