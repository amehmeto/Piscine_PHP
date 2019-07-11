<?php

use PHPUnit\Framework\TestCase;

class LoupeTests extends TestCase {

	const CAT = 'cat ';
	const PROG_NAME = './loupe.php';

	private function assertShellExec($cmd_line, $expected_output){
		$out = shell_exec($cmd_line);
		$this->assertSame($expected_output, $out);
	}

	public function testNoParamShouldReturnNothing(){
		$this->assertShellExec(self::PROG_NAME, NULL);
	}

	public function testSimpleHTMLShouldDisplayHTML(){
		$this->assertShellExec(
			'./loupe.php hello_world.html',
			"<p>Hello World</p>\n"
		);
	}
}
?>
