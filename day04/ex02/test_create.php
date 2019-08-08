<?php

use \PHPUnit\Framework\TestCase;

class CreateAccountTests extends TestCase {

    const PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex02/create.php";
    const PROGRAM = "curl ";

    private function generateCmdLine($login, $password){
        $login = "-d login=" . $login . " ";
        $password = "-d passwd=" . $password . " ";
        $submit = "-d submit=OK ";
        return self::PROGRAM . $login . $password . $submit . self::PATH;
    }

    private function assertCmdLine($expected_output, $login, $password){
        $cmd_line = $this->generateCmdLine($login, $password);
        $output = shell_exec($cmd_line);
        $this->assertSame($expected_output, $output);
    }

    public function testEmptyLoginShouldReturnError(){
       $this->assertCmdLine("ERROR\n", NULL, "weshalors");
    }

    public function testEmptyPasswordShouldReturnError(){
        $this->assertCmdLine("ERROR\n", "JUL", NULL);
    }

    public function testLoginAndPasswordShouldReturnOK(){
        $this->assertCmdLine("OK\n", "JUL", "weshalors");
    }

    public function testCreatePrivateDirIfNonExistent(){
        shell_exec("rm -rf ../private/");
        shell_exec($this->generateCmdLine("JUL", "weshalors"));
        $output = shell_exec("ls ../private");
        $expected_output = "passwd\n";
        $this->assertSame($expected_output, $output);
    }

    public function testValidCredentialsShouldCreateSerializeArray(){
        $output = shell_exec("cat ../private/passwd");
        $expected_output = "a:1:{i:0;a:2:{s:5:\"login\";s:3:\"JUL\";s:6:\"passwd\";s:9:\"weshalors\";}}";
        $this->assertSame($expected_output, $output);
    }
}