<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\genDiff;

class GenDiffTest extends TestCase
{
    /**
     * Тестирование сравнения двух JSON файлов в формате stylish.
     */
    public function testGenDiffForJsonFilesInStylishFormat()
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

    /**
     * Тестирование сравнения двух YAML файлов в формате stylish.
     */
    public function testGenDiffForYamlFilesInStylishFormat()
    {
        $pathToFile1 = __DIR__ . '/fixtures/filepath1.yaml';
        $pathToFile2 = __DIR__ . '/fixtures/filepath2.yaml';
        $expectedResult = '{"common":{"setting1":"Value 1","setting2":200,"setting3":true,"setting6":{"key":"value","doge":{"wow":""}}},"group1":{"baz":"bas","foo":"bar","nest":{"key":"value"}},"group2":{"abc":12345,"deep":{"id":45}},"group3":{"deep":{"id":{"number":45}},"fee":100500}}';
        
        $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2));
    }
  }