<?php

use \PHPUnit\Framework\TestCase;

class CreateAccountTests extends TestCase {

    const PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex02/create.php";
    const PROGRAM = "curl -s ";

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
        $cmd_line = $this->generateCmdLine("toto1", "titi1");
        shell_exec($cmd_line);
        $output = shell_exec("ls ../private");
        $expected_output = "passwd\n";
        $this->assertSame($expected_output, $output);
    }

    public function testValidCredentialsShouldCreateSerializeArray(){
        $output = shell_exec("cat ../private/passwd");
        $expected_output = "a:1:{i:0;a:2:{s:5:\"login\";s:5:\"toto1\";s:6:\"passwd\";s:128:\"2bdd45b3c828273786937ac1b4ca7908a431019e8b93c9fd337317f92fac80dace29802bedc33d9259c8b55d1572cb8a6c1df8579cdaa02256099ed52a905d38\";}}";
        $this->assertSame($expected_output, $output);
    }

    public function testSeveralValidCredentialsCredentials(){
        $cmd_line = $this->generateCmdLine("JUL", "weshalors");
        shell_exec($cmd_line);
        $output = shell_exec("cat ../private/passwd");
        $expected_output = "a:2:{i:0;a:2:{s:5:\"login\";s:5:\"toto1\";s:6:\"passwd\";s:128:\"2bdd45b3c828273786937ac1b4ca7908a431019e8b93c9fd337317f92fac80dace29802bedc33d9259c8b55d1572cb8a6c1df8579cdaa02256099ed52a905d38\";}i:1;a:2:{s:5:\"login\";s:3:\"JUL\";s:6:\"passwd\";s:128:\"f4e5c9514ed0ca9d37b79ffc67e71853f83210c431ce13dd24ee1effd206d338bed72fc9424deaff5d6bbb31db668449eaeb95400a1a1438ea9a2942873c0f6b\";}}";
        $this->assertSame($expected_output, $output);
    }
}