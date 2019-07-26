<?php

use PHPUnit\Framework\TestCase;

class MembersOnlyTests extends TestCase {

    const PROGRAM = 'curl --user';
    const LOGIN_PASSWORD = 'zaz:jaimelespetitsponeys';
    const PATH = 'http://localhost:80/PhpstormProjects/piscine_php/day03/ex06/members_only.php';
    private $_cmd_line = self::PROGRAM . ' ' . self::LOGIN_PASSWORD . ' ' . self::PATH;

    public function testBonjour(){
        $output = shell_exec($this->_cmd_line);
        $expected_result = "Bonjour zaz\n";
        $this->assertSame($expected_result, $output);
    }
}

?>