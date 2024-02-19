<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\Differ\genDiff;

class GenDiffTest extends TestCase
{
    public function testGenDiff()
    {
        $pathToFile1 = __DIR__ . '/fixtures/file1.json';
        $pathToFile2 = __DIR__ . '/fixtures/file2.json';
        $expectedResult = file_get_contents(__DIR__ . '/fixtures/expected_result.txt');

        $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2));
    }
}
