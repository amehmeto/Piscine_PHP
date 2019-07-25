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

	public function testHTMLWithTitleAttributeAndLinkSpreadOut(){
		$this->assertShellExec(
			'title_spread_out',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI\nEST\nUN\nLIEN</a>\n"
		);
	}

	public function testHTMLWithTitleAttributeAndLinkSpreadOut2(){
		$this->assertShellExec(
			'title_spread_out2',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a\nhref=\"http://cyan.com\"\ntitle=\"UN LIEN\">CECI\nEST\nUN\nLIEN</a>\n"
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

	public function testShouldOnlyMatchTitleAttributesInsideAHrefTags3()
    {
        $this->assertShellExec(
            'wrong_motherfucker2',
            "<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n<br /><a href=http://www.riven.com><img src=wrong.image title=\"ET ENCORE CA\" alt=\"un lien\"> ET CA AUSSI </a>\n<div title=\"ceci est une erreur\"> et ca aussi <img src=wrong.image title=\"et encore ca\" alt=\"un lien\"><div>\n</body></html>\n"
        );
    }

	public function testTextImageTagTextSandwich()
    {
        $this->assertShellExec(
            'text_image_tag_text_sandwich',
            "<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n<br /><a href=http://www.riven.com> ET CA AUSSI <img src=wrong.image title=\"ET ENCORE CA\" alt=\"un lien\"> ET CA AUSSI </a>\n<div title=\"ceci est une erreur\"> et ca aussi <img src=wrong.image title=\"et encore ca\" alt=\"un lien\"><div>\n</body></html>\n"
        );
    }

	public function testImageTagTextImageTagSandwich()
	{
		$this->assertShellExec(
			'image_tag_text_image_tag_sandwich',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n<br /><a href=http://www.riven.com><img src=wrong.image title=\"ET ENCORE CA\" alt=\"un lien\"> ET CA AUSSI <img src=wrong.image title=\"ET ENCORE CA\" alt=\"un lien\"></a>\n<div title=\"ceci est une erreur\"> et ca aussi <img src=wrong.image title=\"et encore ca\" alt=\"un lien\"></div>\n</body></html>\n"
		);
	}

	public function testImageTagTextImageTagSandwichSeveralLineSpreadOut()
	{
		$this->assertShellExec(
			'image_tag_text_image_tag_sandwich_spread_out',
			"<html><head><title>Nice page</title></head>\n<body>Hello World <a href=\"http://cyan.com\" title=\"UN LIEN\">CECI EST UN LIEN</a>\n<br /><a href=http://www.riven.com><img src=wrong.image title=\"ET ENCORE CA\" alt=\"un lien\">\n ET CA AUSSI \n<img src=wrong.image \ntitle=\"ET ENCORE CA\" alt=\"un lien\"></a>\n<div title=\"ceci est une erreur\"> et ca\n aussi <img src=wrong.image title=\"et encore ca\" alt=\"un lien\"></div>\n</body></html>\n"
		);
	}
}
?>
