<?php

use \PHPUnit\Framework\TestCase;

class AuthTests extends TestCase {

    const PROGRAM = "curl -s ";
    const CREATE_PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex02/create.php";

    private function generateCreateCmdLine($login, $password){
        return self::PROGRAM . "-d login=" . $login . " -d passwd=" . $password . " -d submit=OK "
            . self::CREATE_PATH;
    }

    private function resetPrivateDirectory($login, $password){
        shell_exec("rm -rf ../private/");
        $cmd_line = $this->generateCreateCmdLine($login, $password);
        shell_exec($cmd_line);
    }

    public function testNull(){
        $this->assertSame(NULL, NULL);
    }

    public function testBasicAuthShouldReturnTrue(){
        $this->resetPrivateDirectory("toto", "titi");
        $this->assertSame(TRUE, auth("toto", "titi"));
    }

    public function testBasicAuth2ShouldReturnTrue(){
        $this->resetPrivateDirectory("tata", "tutu");
        $this->assertSame(TRUE, auth("tata", "tutu"));
    }

    public function testNullLoginShouldReturnFalse(){
        $this->assertSame(FALSE, auth(NULL, "42"));
    }

    public function testNullPasswordShouldReturnFalse(){
        $this->assertSame(FALSE, auth("toto", NULL));
    }

    public function testEmptyPasswordShouldReturnFalse(){
        $this->resetPrivateDirectory("toto", "passwdsecret");
        $this->assertSame(FALSE, auth("toto", ""));
    }

    public function testEmptyLoginShouldReturnFalse(){
        $this->resetPrivateDirectory("toto", "passwdsecret");
        $this->assertSame(FALSE, auth("", "passwdsecret"));
    }

    public function testWrongLoginShouldReturnFalse(){
        $this->resetPrivateDirectory("Booba", "jaimekaaris");
        $this->assertSame(FALSE, auth("Julie", "jaimekaaris"));
    }

    public function testWrongPasswordShouldReturnFalse(){
        $this->resetPrivateDirectory("Arsene", "Arsenal");
        $this->assertSame(FALSE, auth("Arsene", "Chelsea"));
    }
}