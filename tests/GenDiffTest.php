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
      $expectedResult = <<<YAML
      {
        - common: {"setting1":"Value 1","setting2":200,"setting3":true,"setting6":{"key":"value","doge":{"wow":""}}}
        + common: {"follow":false,"setting1":"Value 1","setting3":null,"setting4":"blah blah","setting5":{"key5":"value5"},"setting6":{"key":"value","ops":"vops","doge":{"wow":"so much"}}}
        - group1: {"baz":"bas","foo":"bar","nest":{"key":"value"}}
        + group1: {"foo":"bar","baz":"bars","nest":"str"}
        - group2: {"abc":12345,"deep":{"id":45}}
        + group3: {"deep":{"id":{"number":45}},"fee":100500}
      }
      YAML;
        
        $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2));
    }

        /**
     * Тестирование сравнения двух JSON файлов в формате plain.
     */
    public function testGenDiffForJsonFilesInPlainFormat()
    {
        $pathToFile1 = __DIR__ . '/fixtures/file1.json';
        $pathToFile2 = __DIR__ . '/fixtures/file2.json';
        $expectedResult = <<<PLAIN
        Property 'follow' was added with value: false
        Property 'host' was removed
        Property 'proxy' was removed
        Property 'timeout' was updated. From 50 to 20
        Property 'verbose' was added with value: true
        PLAIN;
        
        $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2, 'plain'));
    }

    /**
     * Тестирование сравнения двух YAML файлов в формате plain.
     */
    public function testGenDiffForYamlFilesInPlainFormat()
    {
        $pathToFile1 = __DIR__ . '/fixtures/filepath1.yaml';
        $pathToFile2 = __DIR__ . '/fixtures/filepath2.yaml';
        $expectedResult = <<<PLAIN
        Property 'common.follow' was added with value: false
        Property 'common.setting2' was removed
        Property 'common.setting3' was updated. From true to null
        Property 'common.setting4' was added with value: 'blah blah'
        Property 'common.setting5' was added with value: [complex value]
        Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
        Property 'common.setting6.ops' was added with value: 'vops'
        Property 'group1.baz' was updated. From 'bas' to 'bars'
        Property 'group1.nest' was updated. From [complex value] to 'str'
        Property 'group2' was removed
        Property 'group3' was added with value: [complex value]
        PLAIN;
        
        $this->assertEquals($expectedResult, genDiff($pathToFile1, $pathToFile2, 'plain'));
    }
  }