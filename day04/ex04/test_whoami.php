<?php

use \PHPUnit\Framework\TestCase;

class WhoAmITests extends TestCase {

    const SUCCESS = "OK\n";
    const ERROR = "ERROR\n";
    const PROGRAM = "curl -s -b cook.txt ";
    const CREATE_PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex02/create.php";
    const GENERIC_PATH= "http://localhost:80/PhpstormProjects/piscine_php/day04/ex04/";

    private function generateCreateCmdLine($login, $password){
        return self::PROGRAM . "-d login=" . $login . " -d passwd=" . $password . " -d submit=OK "
            . self::CREATE_PATH;
    }

    private function generateCmdLine($file_name){
        return self::PROGRAM . "'" . self::GENERIC_PATH . $file_name . ".php'";
    }

    private function resetPrivateDirectory($login, $password){
        shell_exec("rm -rf ../private/");
        $cmd_line = $this->generateCreateCmdLine($login, $password);
        shell_exec($cmd_line);
    }
    public function testNull(){
        $this->assertSame(NULL, NULL);
    }

    public function testEmptySessionShouldReturnError(){
        $cmd_line = $this->resetPrivateDirectory("Joey Starr", "BLAAAH");
        shell_exec($cmd_line);
        $cmd_line = $this->generateCmdLine('whoami');
        $output = shell_exec($cmd_line);
        $this->assertSame(self::ERROR, $output);
    }

    public function testExistingSessionShouldReturnLogin(){
        
    }
}
