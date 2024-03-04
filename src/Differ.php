<?php

namespace Hexlet\Code;

use function Hexlet\Code\Parsers\parse;

function genDiff($pathToFile1, $pathToFile2)
{
    // Получаем форматы файлов
    $format1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $format2 = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    // Получаем содержимое файлов
    $content1 = file_get_contents($pathToFile1);
    $content2 = file_get_contents($pathToFile2);

    // Парсим содержимое файлов
    $data1 = parse($content1, $format1);
    $data2 = parse($content2, $format2);

    // Сравниваем данные и строим результат сравнения
    $diff = buildDiff($data1, $data2);

    // Форматируем результат сравнения
    return formatDiff($diff);
}

function buildDiff($data1, $data2)
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);

    $diff = [];
    foreach ($keys as $key) {
        if (!array_key_exists($key, $data2)) {
            $diff[] = "  - {$key}: " . json_encode($data1[$key]);
        } elseif (!array_key_exists($key, $data1)) {
            $diff[] = "  + {$key}: " . json_encode($data2[$key]);
        } elseif ($data1[$key] === $data2[$key]) {
            $diff[] = "    {$key}: " . json_encode($data1[$key]);
        } else {
            $diff[] = "  - {$key}: " . json_encode($data1[$key]);
            $diff[] = "  + {$key}: " . json_encode($data2[$key]);
        }
    }

    return $diff;
}

function formatDiff($diff)
{
    return "{\n" . implode("\n", $diff) . "\n}";
}
