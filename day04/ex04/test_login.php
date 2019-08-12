<?php

use \PHPUnit\Framework\TestCase;

if (!isset($_SESSION))
    $_SESSION = array();

class AuthTests extends TestCase {
    protected $backupGlobalsBlacklist = array('_SESSION');

    const SUCCESS = "OK\n";
    const ERROR = "ERROR\n";
    const PROGRAM = "curl -s ";
    const CREATE_PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex02/create.php";
    const LOGIN_PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex04/login.php";

    private function generateCreateCmdLine($login, $password){
        return self::PROGRAM . "-d login=" . $login . " -d passwd=" . $password . " -d submit=OK "
            . self::CREATE_PATH;
    }

    private function generateLoginCmdLine($login, $password){
        return self::PROGRAM . "'" . self::LOGIN_PATH . "?login=" . $login . "&passwd=" . $password . "'";
    }

    private function assertLoginProcess($expected_output, $login, $password){
        $cmd_line = $this->generateLoginCmdLine($login, $password);
        $output = shell_exec($cmd_line);
        $this->assertSame($expected_output, $output);
    }

    private function resetPrivateDirectory($login, $password){
        shell_exec("rm -rf ../private/");
        $cmd_line = $this->generateCreateCmdLine($login, $password);
        shell_exec($cmd_line);
    }

    public function testNull(){
        $this->assertSame(NULL, NULL);
    }

    public function testBasicLoginShouldReturnOK(){
        $this->resetPrivateDirectory("Favard", "allezlom");
        $this->assertLoginProcess(self::SUCCESS,"Favard","allezlom");
    }

    public function testWrongLoginShouldReturnError(){
        $this->resetPrivateDirectory("Favard", "mercato");
        $this->assertLoginProcess(self::ERROR,"Gilles","mercato");
    }

    /*
    public function testSessionLoggedOnUserShouldReturnLoginWhenSuccess(){
        $this->resetPrivateDirectory("Favard", "mercato");
        $cmd_line = $this->generateLoginCmdLine("Favard", "mercato");
        $output = shell_exec($cmd_line);
        $this->assertSame($output . "Favard", $_SESSION['logged_on_user']);
    }
    */
}