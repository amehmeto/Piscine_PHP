<?php

use PHPUnit\Framework\TestCase;

class LoupeTests extends TestCase {

	const CAT = 'cat ';
	const PROG_NAME = './loupe.php ';
	const HTML_SUFFIX = '.html';

	private function assertShellExec($cmd_line, $expected_output){
		if ($cmd_line)
			$cmd_line .= self::HTML_SUFFIX;
	$out = shell_exec(self::PROG_NAME . $cmd_line);
		$this->assertSame($expected_output, $out);
	}

	public function testNoParamShouldReturnNothing(){
		$this->assertShellExec(NULL, NULL);
	}

	public function testSimpleHTMLFile(){
		$this->assertShellExec(
			'hello_world',
			"<p>Hello World</p>\n<p>That's cool in here</p>\n"
		);
	}

	public function testWrongFileName(){
		$this->assertShellExec('random_wrong_name', NULL);
	}

	public function testHTMLWithTitleAttribute(){
		$this->assertShellExec(
			'title',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n"
		);
	}

}
?>
