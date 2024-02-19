<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\genDiff;

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

    public function testGenDiffWithYamlFiles()
{
    $pathToFile1 = __DIR__ . '/fixtures/file1.yaml';
    $pathToFile2 = __DIR__ . '/fixtures/file2.yaml';

    $expectedResult = <<<YAML
{
  - follow: false
    host: "hexlet.io"
  - proxy: "123.234.53.22"
  - timeout: 50
  + timeout: 20
  + verbose: true
}
YAML;

    $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2, 'yaml'));
}
}
