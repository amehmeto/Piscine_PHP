<?php

use PHPUnit\Framework\TestCase;

class SingItTests extends TestCase {

	public function testNoParamShouldReturnNothing(){
		$out = shell_exec('./sing_it.php');
		$this->assertSame(NULL, $out);
	}

	public function testMaisPourquoiCetteDemo(){
		$out = shell_exec('./sing_it.php "mais pourquoi cette demo ?"');
		$this->assertSame("Tout simplement pour qu'en feuilletant le sujet\non ne s'apercoive pas de la nature de l'exo\n", $out);
	}
}
?>
