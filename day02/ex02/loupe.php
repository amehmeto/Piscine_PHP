#!/usr/bin/php
<?php
if ($argc > 1)
{
	$HTML_file = file($argv[1]);
	if ($HTML_file)
		foreach ($HTML_file as $line)
			echo $line;
}
?>
