<?php
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
	public function testNoParam(){
		$out = shell_exec('./do_op_2.php');
		$this->assertSame("Incorrect Parameters\n", $out);
	}

	public function testTwoParamsShouldReturnError(){
		$out = shell_exec('./do_op_2.php 2 +');
		$this->assertSame("Incorrect Parameters\n", $out);
	}

	public function testTotoInputReturnSyntaxError(){
		$out = shell_exec('./do_op_2.php toto');
		$this->assertSame("Syntax Error\n", $out);
	}
	
	public function testShouldAcceptOnlyOneOperand(){
		$out = shell_exec('./do_op_2.php "2*2*2"');
		$this->assertSame("Syntax Error\n", $out);
	}

	public function testShouldAcceptUnlimitedWhiteSpace(){
		$out = shell_exec("./do_op_2.php '  2   *  2  '");
		$this->assertSame("4\n", $out);
	}
	
	public function testTwoTimesThreeReturnSix(){
		$out = shell_exec("./do_op_2.php '  2   *  3  '");
		$this->assertSame("6\n", $out);
	}
	
	public function testTwoPlusThreeReturnFive(){
		$out = shell_exec("./do_op_2.php '2+  3  '");
		$this->assertSame("5\n", $out);
	}

	public function testFourthDivideByTwoReturnTwo(){
		$out = shell_exec("./do_op_2.php '4/2  '");
		$this->assertSame("2\n", $out);
	}
}
?>
