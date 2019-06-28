#!/usr/bin/php
<?php

if ($argc > 2)
{
	$selected_key = $argv[1];
	$i = 2;
	while (isset($argv[$i]))
	{
		if (preg_match("/(.*):(.*)/", $argv[$i], $key_val_couples))
			$result_array[$key_val_couples[1]] = $key_val_couples[2];
		$i++;
	}
	if (isset($result_array[$selected_key]))
		echo $result_array[$selected_key] . "\n";
}
?>
