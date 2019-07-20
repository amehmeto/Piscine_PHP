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

	public function testHTMLWithTitleAttributeAndLink(){
		$this->assertShellExec(
			'title',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n"
		);
	}

	public function testSeveralLinesHTMLWithTitleAttributeLinkAndImage(){
		$this->assertShellExec(
			'title_and_image',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n<br /><a href=http://www.riven.com> ET CA AUSSI <img src=wrong.image title=\"ET ENCORE CA\"></a>\n</body></html>\n"
		);
	}

	public function testShouldOnlyMatchTitleAttributesInsideAHrefTags(){
		$this->assertShellExec(
			'wrong',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n<br /><a href=http://www.riven.com> ET CA AUSSI <img src=wrong.image title=\"ET ENCORE CA\"></a>\n</body></html>\n<script>/<![CDATA[/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement(\"iframe\");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src=\"javascript:false\",r.title=\"wrong motherfucker\"</script>\n"
		);
	}

	public function testShouldOnlyMatchTitleAttributesInsideAHrefTags2(){
		$this->assertShellExec(
			'wrong_motherfucker', 
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n<br /><a href=http://www.riven.com> ET CA AUSSI <img src=wrong.image title=\"ET ENCORE CA\" alt=\"un lien\"></a>\n<div title=\"ceci est une erreur\"> et ca aussi <img src=wrong.image title=\"et encore ca\" alt=\"un lien\"><div>\n</body></html>\n"

		);
	}

	/*
	public function testOneLineSeveralTitleAttributesAndAHREF(){
		$this->assertShellExec(
			'title_and_image_double',
			"<html><head><title>Nice page</title></head> <body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a> <br /><a href=http://www.riven.com> ET CA AUSSI <img src=wrong.image title=\"ET ENCORE CA\"></a> </body></html> <html><head><title>Nice page</title></head> <body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a> <br /><a href=http://www.riven.com> ET CA AUSSI <img src=wrong.image title=\"ET ENCORE CA\"></a> </body></html>"
		);
	}*/
}
?>
