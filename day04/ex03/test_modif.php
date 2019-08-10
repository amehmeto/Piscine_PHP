<?php

use \PHPUnit\Framework\TestCase;

class ModifAccountTests extends TestCase {

    const PROGRAM = "curl -s ";
    const MODIF_PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex03/modif.php";
    const CREATE_PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex02/create.php";

    private function generateCreateCmdLine($login, $password){
        return self::PROGRAM . "-d login=" . $login . " -d passwd=" . $password . " -d submit=OK "
            . self::CREATE_PATH;
    }

    private function generateModifCmdLine($login, $old_password, $new_password){
        return self::PROGRAM . "-d login=" . $login . " -d oldpw=" . $old_password
            . " -d newpw=" . $new_password . " -d submit=OK " . self::MODIF_PATH;
    }

    private function resetPrivateDirectory(){
        shell_exec("rm -rf ../private");
        $cmd_line = $this->generateCreateCmdLine("x", "42");
        shell_exec($cmd_line);
        $cmd_line = $this->generateCreateCmdLine("y", "84");
        shell_exec($cmd_line);
    }

    private function assertSameModif($expected_output, $login, $old_pw, $new_pw){
        $this->resetPrivateDirectory();
        $cmd_line = $this->generateModifCmdLine($login, $old_pw, $new_pw);
        $output = shell_exec($cmd_line);
        $this->assertSame($expected_output, $output);
    }

    public function testEmptyNewPasswordShouldReturnError(){
        $this->assertSameModif("ERROR\n", "x", "42", "");
    }

    public function testValidCredentialsShouldReturnOK(){
        $this->assertSameModif("OK\n", "x", "42","21");
    }

    public function testValidCredentials2ShouldReturnOK(){
        $this->assertSameModif("OK\n", "y", "84","21");
    }

    public function testInvalidCredentialsShouldReturnError(){
        $this->assertSameModif("ERROR\n", "x", "007", "21");
    }

    public function testInvalidCredentials2ShouldReturnError(){
        $this->assertSameModif("ERROR\n", "y", "884", "21");
    }

    public function testWrongLoginShouldReturnError(){
        $this->assertSameModif("ERROR\n", "Booba", "42", "21");
    }
    public function testBasicPasswordChange(){
        $this->resetPrivateDirectory();
        $cmd_line = $this->generateModifCmdLine("x", "42", "21");
        shell_exec($cmd_line);
        $output = shell_exec("cat ../private/passwd");
        $expected_output = "a:2:{i:0;a:2:{s:5:\"login\";s:1:\"x\";s:6:\"passwd\";s:128:\"75b5bd3160157e9ea5576f9bf9e60f3d680cc77b0f9f4fae492c0c0917a6995c860c985c99b87eae874e35f2b38a06efaa3bda5f28cfab942dbc34886db64f4d\";}:1;a:2:{s:5:\"login\";s:1:\"y\";s:6:\"passwd\";s:128:\"76936d1331bb87561dead9036bce3a29e7667d5a228a85ea825210d3944c2fad2f15c36aa6affa729d703d84857cf826aba199f0a9f45780c64261f1b22c0b7f\";}}";
        $this->assertSame($expected_output, $output);
    }
}