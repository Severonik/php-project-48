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
        $pathToFile1 = __DIR__ . '/fixtures/filepath1.yaml';
        $pathToFile2 = __DIR__ . '/fixtures/filepath2.yaml';
    
        $expectedResult = <<<YAML
    {
      - common: 
          setting1: Value 1
          setting2: 200
          setting3: true
          setting6:
            key: value
            doge:
              wow: ""
      + common:
          follow: false
          setting1: Value 1
          setting3: null
          setting4: blah blah
          setting5:
            key5: value5
          setting6:
            key: value
            ops: vops
            doge:
              wow: so much
      - group1: 
          baz: bas
          foo: bar
          nest:
            key: value
      + group1:
          foo: bar
          baz: bars
          nest: str
      - group2: 
          abc: 12345
          deep:
            id: 45
      + group3:
          deep:
            id:
              number: 45
          fee: 100500
    }
    YAML;
    
        $expectedResult = str_replace("\n", PHP_EOL, $expectedResult); // Заменяем новую строку на маркер новой строки операционной системы
        $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2, 'stylish'));
    }    
  }
