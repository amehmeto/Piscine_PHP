<?php

use PHPUnit\Framework\TestCase;

class SearchItTests extends TestCase {

	public function testNoParamShouldReturnNothing(){
		$out = shell_exec('./search_it.php');
		$this->assertSame(NULL, $out);
	}

	public function testTotoShouldReturnNothing(){
		$out = shell_exec('./search_it.php');
		$this->assertSame(NULL, $out);
	}
	
	public function testShellExecShouldReturn42(){
		$out = shell_exec('./search_it.php toto "key1:val1" "key2:val2" "toto:42"');
		$this->assertSame("42\n", $out);
	}
	 
	public function testShellExecShouldReturnVal2(){
		$out = shell_exec('./search_it.php toto "key1:val1" "toto:val2" "key3:42"');
		$this->assertSame("val2\n", $out);
	}

	public function testShellExec22ShouldReturn42(){
		$out = shell_exec('./search_it.php toto "toto:val1" "key2:val2" "toto:42"');
		$this->assertSame("42\n", $out);
	}

	public function testShellExecShouldReturnNothing(){
		$out = shell_exec('./search_it.php toto "key1:val1" "key2:val2" "0:hop"');
		$this->assertSame(NULL, $out);
	}

	public function testShellExecShouldReturnHop(){
		$out = shell_exec('./search_it.php  "0" "key1:val1" "key2:val2" "0:hop"');
		$this->assertSame("hop\n", $out);
	}
}

?>
