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

	public function testBertrandCSVMoyenneShouldReturn7Point94(){
		$out = shell_exec('cat bertrand_y_notes.csv | ./agent_stats.php moyenne');
		$this->assertSame("7.9473684210526\n", $out);
	}
	public function testAdamCSVMoyenneUserShouldReturn9Point05(){
		$out = shell_exec('cat adam_e_notes.csv | ./agent_stats.php moyenne_user');
		$this->assertSame("adam_e:9.0555555555556\n", $out);
	}

	public function testBertrandCSVMoyenneUserShouldReturn7Point94(){
		$out = shell_exec('cat bertrand_y_notes.csv | ./agent_stats.php moyenne_user');
		$this->assertSame("bertrand_y:7.9473684210526\n", $out);
	}

	public function testBertrandAndAdamCSVMoyenneUserShouldReturn2lines(){
		$out = shell_exec('cat adam_e_and_bertrand_y_notes.csv | ./agent_stats.php moyenne_user');
		$this->assertSame("adam_e:9.0555555555556\nbertrand_y:7.9473684210526\n", $out) ;
	}
}
?>
