<?php

use PHPUnit\Framework\TestCase;

class MembersOnlyTests extends TestCase {

    private $_cmd_line = 'curl --user zaz:jaimelespetitsponeys http://localhost:80/piscine_php/day03/ex06/members_only.php';

    public function testBonjour(){
        $output = shell_exec($this->_cmd_line);
        $expected_result = "Bonjour\n";
        $this->assertSame($expected_result, $output);
    }
}

?>