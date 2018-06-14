#!/usr/bin/php

<?php
function ft_split($str)
{
	$tmp = preg_split("/[\s,]+/", trim($str));
	sort($tmp);
	return ($tmp);
}
?>
