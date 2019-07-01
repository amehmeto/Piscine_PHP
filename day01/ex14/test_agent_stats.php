<?php

use PHPUnit\Framework\TestCase;

class AgentStatsTests extends TestCase {

	public function testNoParamShouldReturnNothing(){
		$out = shell_exec('cat peer_notes_1.csv | ./agent_stats.php');
		$this->assertSame(NULL, $out);
	}

	public function testArgMoyenneCSV1ShouldReturn9Point86(){
		$out = shell_exec('cat peer_notes_1.csv | ./agent_stats.php moyenne');
		$this->assertSame("9.8621262458472\n", $out);
	}

	/*
	public function testAdamCSVMoyenneUserShouldReturn9Point05(){
		$out = shell_exec('cat adam_e_notes.csv | ./agent_stats.php moyenne_user');
		$this->assertSame("9.0555555555556\n", $out);
	}
	*/
}
?>
