<?php

namespace Hexlet\Code;

use function Hexlet\Code\Parsers\parse;

function genDiff($pathToFile1, $pathToFile2)
{
    // Получаем данные из файлов
    $data1 = getDataFromFile($pathToFile1);
    $data2 = getDataFromFile($pathToFile2);

    // Сравниваем данные и строим результат сравнения
    $diff = buildDiff($data1, $data2);

    // Форматируем результат сравнения
    return formatDiff($diff);
}

function getDataFromFile($pathToFile)
{
    // Получаем формат файла
    $format = pathinfo($pathToFile, PATHINFO_EXTENSION);

    // Получаем содержимое файла и парсим его
    $content = file_get_contents($pathToFile);
    return parse($content, $format);
}

function buildDiff($data1, $data2)
{
    $keys = getUniqueKeys($data1, $data2);

    $diff = [];
    foreach ($keys as $key) {
        $diff[] = buildDiffItem($key, $data1, $data2);
    }

    return $diff;
}

function getUniqueKeys($data1, $data2)
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);
    return $keys;
}

function buildDiffItem($key, $data1, $data2)
{
    if (!array_key_exists($key, $data2)) {
        return "  - {$key}: " . json_encode($data1[$key]);
    }
    if (!array_key_exists($key, $data1)) {
        return "  + {$key}: " . json_encode($data2[$key]);
    }
    if ($data1[$key] === $data2[$key]) {
        return "    {$key}: " . json_encode($data1[$key]);
    }
    return [
        "  - {$key}: " . json_encode($data1[$key]),
        "  + {$key}: " . json_encode($data2[$key]),
    ];
}

function formatDiff($diff)
{
    return "{\n" . implode("\n", $diff) . "\n}";
}
