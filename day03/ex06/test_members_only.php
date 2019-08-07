<?php

use PHPUnit\Framework\TestCase;

class MembersOnlyTests extends TestCase {

    const PATH = 'http://localhost:80/PhpstormProjects/piscine_php/day03/ex06/members_only.php';

    private function generateCmd($program, $login, $password){
        return $program . ' ' . $login . ':' . $password . ' ' . self::PATH;
    }

    public function testBonjour(){
        $cmd_line = $this->generateCmd('curl --user', 'zaz', 'zaz');
        $output = shell_exec($cmd_line);
        $file_content = file_get_contents("../img/42.png");
        $expected_result = "<html><body>\nBonjour Zaz<br />\n<img src='data:image/png;base64," .
                            base64_encode($file_content) . "'>\n</body></html>\n";
        $this->assertSame($expected_result, $output);
    }

    public function testWrongPassword(){
        $cmd_line = $this->generateCmd('curl -v --user', 'zaz', 'wesh alors');
        $output = shell_exec($cmd_line);
        $expected_result = "<html><body>Cette zone est accessible uniquement aux membres du site</body></html>\n";
        $this->assertSame($expected_result, $output);
    }

    public function testWrongUsername(){
        $cmd_line = $this->generateCmd('curl -v --user', 'zsadfaz', 'zaz');
        $output = shell_exec($cmd_line);
        $expected_result = "<html><body>Cette zone est accessible uniquement aux membres du site</body></html>\n";
        $this->assertSame($expected_result, $output);
    }
}