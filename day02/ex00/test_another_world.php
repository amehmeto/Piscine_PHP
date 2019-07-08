<?php

use PHPUnit\Framework\TestCase;

class AnotherWorldTests extends TestCase {
	
	public function testNoParamShouldReturnNothing(){
		$out = shell_exec('./another_world.php');
		$this->assertSame(NULL, $out);
	}	

	public function testWeshShouldReturnWesh(){
		$out = shell_exec('./another_world.php wesh');
		$this->assertSame("wesh\n", $out);
	}

	public function testAlorsShouldReturnAlors(){
		$out = shell_exec('./another_world.php alors');
		$this->assertSame("alors\n", $out);
	}

	public function testWeshAlorsShouldReturnWeshAlors(){
		$out = shell_exec('./another_world.php "wesh alors"');
		$this->assertSame("wesh alors\n", $out);
	}

	public function testWeshTabAlorsShouldReturnWeshAlors(){
		$out = shell_exec("./another_world.php \"wesh\talors\"");
		$this->assertSame("wesh alors\n", $out);
	}

	public function testBasicTabTrim(){
		$out = shell_exec(
			"./another_world.php \"Cette\tphrase\tcontient des espaces et\t\tdes\ttabulations\""
		);
		$this->assertSame("Cette phrase contient des espaces et des tabulations\n", $out);
	}
	
	public function test2ParamsShouldOnlyTrimTheFirst(){
		$out = shell_exec(
			"./another_world.php \"Ce param\test\t\ttraite\" \"mais pas celui\tla\""
		);
		$this->assertSame("Ce param est traite\n", $out);
	}

	public function testShouldNotStartWithWhiteSpace(){
		$out = shell_exec("./another_world.php \"\t  Pas d'espace\tdevant\"");
		$this->assertSame("Pas d'espace devant\n", $out);
	}

	public function testShouldNotEndWithWhiteSpace(){
		$out = shell_exec("./another_world.php \"  Pas d'espace\tderriere  \t\"");
		$this->assertSame("Pas d'espace derriere\n", $out);
	}
}
?>
