<?php

use \PHPUnit\Framework\TestCase;

class SpeakTests extends TestCase{

    const SUCCESS = "OK\n";
    const PROGRAM = 'curl -s ';
    const PATH = "http://localhost:80/PhpstormProjects/piscine_php/day04/ex05/";

    private function generateCmd($middle, $function, $arguments=NULL){
        $cmd_line = self::PROGRAM . $middle . " '" . self::PATH . $function . '.php';
        if ($arguments)
            $cmd_line .= '?' . $arguments;
        $cmd_line .= "'";
        return $cmd_line;
    }

    private function resetPrivateDir(){
        shell_exec('rm -rf ../private');
        $cmd_line = $this->generateCmd('-d login=user1 -d passwd=pass1 -d submit=OK', 'create');
        shell_exec($cmd_line);
        $cmd_line = $this->generateCmd('-d login=user2 -d passwd=pass2 -d submit=OK', 'create');
        shell_exec($cmd_line);
    }

    public function testNull(){
        $this->assertSame(NULL, NULL);
    }

    public function testCreateShouldPopulatePrivatePasswordFile(){
        $this->resetPrivateDir();
        $output = shell_exec('cat ../private/passwd');
        $expected_output = "a:2:{i:0;a:2:{s:5:\"login\";s:5:\"user1\";s:6:\"passwd\";s:128:\"2d9113bf14229d603edc20a885ee3a6d09c6f29032e9e7b2c803148ba4c984d5b9e6a04492d294ee9193e1d6a90d25b23388fabe45a3d91178d793523e54a9f8\";}i:1;a:2:{s:5:\"login\";s:5:\"user2\";s:6:\"passwd\";s:128:\"b3a197d5c962085568e2fa34ecc71539e32c1ec47fa0816a67a338ce3d1ff96383ef43aa200df9805f2fee13da4adb631a3b706b0d7131307062d28ffcddf145\";}}";
        $this->assertSame($expected_output, $output);
    }

    public function testSpeakShouldPopulatePrivateChatFile(){
        $this->resetPrivateDir();
        $cmd_line = $this->generateCmd('-c user1.txt', 'login', 'login=user1&passwd=pass1');
        shell_exec($cmd_line);
        $cmd_line = $this->generateCmd('-b user1.txt -d submit=OK -d msg=Bonjour', 'speak');
        shell_exec($cmd_line);
        $expected_output = "a:1:{i:0;a:3:{s:5:\"login\";s:5:\"user1\";s:4:\"time\";i:" . time() . ";s:3:\"msg\";s:7:\"Bonjour\";}}";
        $output = shell_exec('cat ../private/chat');
        $this->assertSame($expected_output, $output);
    }

    public function testLogoutShouldReturnError(){
        $cmd_line = $this->generateCmd('-b user1.txt -c user.txt', 'logout');
        shell_exec($cmd_line);
        $cmd_line = $this->generateCmd('-b user1.txt -d submit=OK -d msg=Wesh', 'speak');
        $output = shell_exec($cmd_line);
        $expected_output = "ERROR\n";
        $this->assertSame($expected_output, $output);
    }

    public function testLoginAndSpeakUser2ShouldReturnChat(){
        $cmd_line = $this->generateCmd('-c user2.txt', 'login', 'login=user2&passwd=pass2');
        shell_exec($cmd_line);
        $cmd_line = $this->generateCmd('-b user2.txt -d submit=OK -d msg=Hello', 'speak');
        shell_exec($cmd_line);
        $output = shell_exec('cat ../private/chat');
        $expected_output = "a:2:{i:0;a:3:{s:5:\"login\";s:5:\"user1\";s:4:\"time\";i:" . time() . ";s:3:\"msg\";s:7:\"Bonjour\";}i:1;a:3:{s:5:\"login\";s:5:\"user2\";s:4:\"time\";i:" . time() . ";s:3:\"msg\";s:5:\"Hello\";}}";
        $this->assertSame($expected_output, $output);
    }

    public function testChatShouldBeDisplayedAsExpected(){
        $cmd_line = $this->generateCmd('-b user2.txt', 'chat');
        $output = shell_exec($cmd_line);
        $expected_output = "[" . date('H:i', time()) . "] <b>user1</b>: Bonjour<br />[" . date('H:i', time()) . "] <b>user2</b>: Hello<br />";
        $this->assertSame($expected_output, $output);

    }
}