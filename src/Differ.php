<?php

namespace Hexlet\Code;

function genDiff($pathToFile1, $pathToFile2)
{
    $data1 = json_decode(file_get_contents($pathToFile1), true);
    $data2 = json_decode(file_get_contents($pathToFile2), true);

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
