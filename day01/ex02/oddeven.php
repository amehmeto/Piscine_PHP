#!/usr/bin/php -n 
<?php
while (TRUE)
{
	echo "Entrez un nombre : ";
	$line = trim(fgets(STDIN));
	if (feof(STDIN))
	{
		echo "^D\n";
		exit(1);
	}
	$tmp = substr($line, -1);
	if (is_numeric($line))
		if ($tmp % 2 == 0)
			echo "Le chiffre $line est Pair \n";
		else
			echo "Le chiffre $line est Impair \n";
	else
		echo "'$line' n'est pas un chiffre \n";
}
?>
