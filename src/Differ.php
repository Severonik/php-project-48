<?php

namespace Hexlet\Code;

use function Hexlet\Code\Parsers\parse;

function genDiff($pathToFile1, $pathToFile2)
{
    $format1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $format2 = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    $content1 = file_get_contents($pathToFile1);
    $content2 = file_get_contents($pathToFile2);

    $data1 = parse($content1, $format1);
    $data2 = parse($content2, $format2);

    $diff = generateDiff($data1, $data2);

    return formatDiff($diff);
}

function generateDiff(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);

    $diff = [];

    foreach ($keys as $key) {
        if (!array_key_exists($key, $data2)) {
            $diff[] = ['type' => 'removed', 'key' => $key, 'value' => $data1[$key]];
        } elseif (!array_key_exists($key, $data1)) {
            $diff[] = ['type' => 'added', 'key' => $key, 'value' => $data2[$key]];
        } elseif ($data1[$key] === $data2[$key]) {
            $diff[] = ['type' => 'unchanged', 'key' => $key, 'value' => $data1[$key]];
        } else {
            $diff[] = ['type' => 'changed', 'key' => $key, 'oldValue' => $data1[$key], 'newValue' => $data2[$key]];
        }
    }

    return $diff;
}

function formatDiff(array $diff): string
{
    $lines = array_map(function ($item) {
        switch ($item['type']) {
            case 'removed':
                return "- {$item['key']}: " . stringify($item['value'], 2);
            case 'added':
                return "+ {$item['key']}: " . stringify($item['value'], 2);
            case 'unchanged':
                return "  {$item['key']}: " . stringify($item['value'], 2);
            case 'changed':
                return "- {$item['key']}: " . stringify($item['oldValue'], 2) . "\n+ {$item['key']}: " . stringify($item['newValue'], 2);
        }
    }, $diff);

    return "{\n" . implode("\n", $lines) . "\n}";
}

function stringify($value, $depth): string
{
    if (!is_array($value)) {
        return json_encode($value);
    }

    $indent = str_repeat(' ', $depth * 4);
    $lines = array_map(function ($key, $val) use ($indent, $depth) {
        $formattedValue = is_array($val) ? stringify($val, $depth + 1) : json_encode($val);
        return "{$indent}{$key}: {$formattedValue}";
    }, array_keys($value), $value);

    return "{\n" . implode("\n", $lines) . "\n" . str_repeat(' ', ($depth - 1) * 4) . "}";
}
