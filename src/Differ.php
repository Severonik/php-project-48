<?php

namespace Hexlet\Code;

use function Hexlet\Code\parse;

function genDiff($pathToFile1, $pathToFile2)
{
    $format1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $format2 = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    $content1 = file_get_contents($pathToFile1);
    $content2 = file_get_contents($pathToFile2);

    $data1 = parse($content1, $format1);
    $data2 = parse($content2, $format2);

    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);

    $diff = array_map(function ($key) use ($data1, $data2) {
        if (!array_key_exists($key, $data2)) {
            return "  - {$key}: " . json_encode($data1[$key]);
        } elseif (!array_key_exists($key, $data1)) {
            return "  + {$key}: " . json_encode($data2[$key]);
        } elseif ($data1[$key] === $data2[$key]) {
            return "    {$key}: " . json_encode($data1[$key]);
        } else {
            return "  - {$key}: " . json_encode($data1[$key]) . "\n  + {$key}: " . json_encode($data2[$key]);
        }
    }, $keys);

    return "{\n" . implode("\n", $diff) . "\n}";
}
