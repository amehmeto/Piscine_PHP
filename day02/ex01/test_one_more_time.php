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
			"Mercrediay 1 Juillet 1999 12:02:21"
		);
	}

	public function testSecondWordShouldBeNum1To31(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"Mercredi 1st Juillet 1999 12:02:21"
		);
	}

	public function testSecondWordInvalidShouldRetunWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"Mercredi 32 Juillet 1999 12:02:21"
		);
	}

	public function testSecondWordInvalid2ShouldRetunWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"Mercredi 00 Juillet 1999 12:02:21"
		);
	}
	public function testSecondWordValid2ShouldRetunTimestamp(){ $this->assertShellExec(
		"933415341\n",
		"Samedi 31 Juillet 1999 12:02:21"
	);
	}

	public function testValidSecondWordShouldReturnTimeStamp(){
		$this->assertShellExec(
			"930823341\n",
			"jeudi 1 Juillet 1999 12:02:21"
		);
	}

	public function testValidSecondWord2ShouldReturnTimeStamp(){
		$this->assertShellExec(
			"930823341\n",
			"Jeudi 01 Juillet 1999 12:02:21"
		);
	}

	public function testInvalidThirdWordShouldReturnTimeStamp(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"jeudi 1 JUL 1999 12:02:21"
		);
	}	

	public function testInvalidThirdWordShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 12 07 1999 12:02:21"
		);
	}

	public function testInvalidFourthWordShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 12 juillet 99 12:02:21"
		);
	}

	public function testInvalidFourthWord2ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 31 Decembre 1969 12:02:21"
		);
	}

	public function testValidFifthWordShouldReturnTimeStamp(){
		$this->assertShellExec(
			"631105341\n",
			"dimanche 31 Decembre 1989 12:02:21"
		);
	}

	public function testInvalidFifthWordShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 31 Decembre 1989 32:02:21"
		);
	}

	public function testInvalidFifthWord2ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 31 Decembre 1989 12:72:21"
		);
	}

	public function testInvalidFifthWord3ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 31 Decembre 1989 12:42:91"
		);
	}

	public function testSeparetorShouldBeOneSpaceOnly(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi\t31\tDecembre 1990 12:42:00"
		);
	}

	public function testNoWhiteSpaceAtTheEnd(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 31 Decembre 1990 12:42:00 "
		);
	}

	public function testNoWhiteSpaceAtTheBeginning(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			" mercredi 31 Decembre 1990 12:42:00"
		);
	}

	public function test9JulShouldReturnTimeStamp(){
		$this->assertShellExec(
			"1562704052\n",
			"mardi 9 Juillet 2019 22:27:32"
		);
	}

	public function testMaxTimestampShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mardi 19 janvier 2039 03:14:07"
		);
	}

	public function testMaxTimestamp2ShouldReturnTimestamp(){
		$this->assertShellExec(
			"2147483647\n",
			"mardi 19 janvier 2038 04:14:07"
		);
	}

	public function testMaxTimestamp2ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mardi 19 fevrier 2038 04:14:07"
		);
	}

	public function testMaxTimestamp3ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mercredi 20 janvier 2038 04:14:07"
		);
	}

	public function testMaxTimestamp4ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mardi 19 janvier 2038 05:14:07"
		);
	}

	public function testMaxTimestamp5ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mardi 19 janvier 2038 04:15:07"
		);
	}

	public function testMaxTimestamp6ShouldReturnWrongFormat(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"mardi 19 janvier 2038 04:14:08"
		);
	}

	public function testDayNameIsConsistentWithTimestamp(){
		$this->assertShellExec(
			"1562724848\n",
			"mercredi 10 juillet 2019 04:14:08"
		);	
	}

	public function testDayNameIsNotConsistentWithTimestamp(){
		$this->assertShellExec(
			self::WRONG_FORMAT,
			"Lundi 10 juillet 2019 04:14:08"
		);	
	}
}
?>
