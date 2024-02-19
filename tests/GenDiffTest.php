<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\Differ\genDiff;

class GenDiffTest extends TestCase
{
    public function testGenDiff()
    {
        $pathToFile1 = __DIR__ . '/fixtures/file1.json';
        $pathToFile2 = __DIR__ . '/fixtures/file2.json';

        $expectedResult = <<<JSON
{
  - follow: false
    host: "hexlet.io"
  - proxy: "123.234.53.22"
  - timeout: 50
  + timeout: 20
  + verbose: true
}
JSON;

        $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2));
    }
}
