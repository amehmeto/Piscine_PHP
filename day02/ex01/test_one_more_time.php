<?php

use PHPUnit\Framework\TestCase;

class OneMoreTimeTests extends TestCase {
	private $_program_exec = './one_more_time.php ';
	const QUOTE = "\"";
	const WRONG_FORMAT = "Wrong Format\n";

	private function getShellOutput($tested_param, $no_quotes_needed=FALSE){
		if ($no_quotes_needed)
			return shell_exec($this->_program_exec . $tested_param);
		return shell_exec($this->_program_exec . self::QUOTE . $tested_param . self::QUOTE); 
	}

	private function assertShellExec($expected_result, $tested_param, $no_quotes_needed=FALSE){
		$out = $this->getShellOutput(
			$tested_param,
			$no_quotes_needed
		);	
		$this->assertSame($expected_result, $out);
	}

	public function testNoParamShouldReturnNothing(){
		$this->assertShellExec(NULL, NULL, TRUE);
	}

	public function test12NovShouldReturnTimeStamp(){
		$this->assertShellExec(
			"1384254141\n",
			"Mardi 12 Novembre 2013 12:02:21"
		);
	}

	public function testFirstWordShouldBeDayName(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"Mercrediay 1 Juillet 1999"
		);
	}

	public function testSecondWordShouldBeNum1To31(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"Mercredi 1st Juillet 1999"
		);
	}

	public function testSecondWordInvalidShouldRetunWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"Mercredi 32 Juillet 1999"
		);
	}

	public function testValidSecondWordShouldReturnTimeStamp(){
		$this->assertShellExec(
			"1384254141\n",
			"Mercredi 1 Juillet 1999"
		);
	}
		
	public function testValidSecondWord2ShouldReturnTimeStamp(){
		$this->assertShellExec(
			"1384254141\n",
			"Mercredi 01 Juillet 1999"
		);
	}
	/*
	public function test9JulShouldReturnTimeStamp(){
		$this->assertShellExec(
			"1562624856\n",
			"\"mardi 9 Juillet 2019 22:27:32\""
		);
	}
	 */
}

?>
