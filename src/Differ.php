<?php

namespace Hexlet\Code;

use Hexlet\Code\Formatters\StylishFormatter;
use Hexlet\Code\Formatters\PlainFormatter;
use function Hexlet\Code\Parsers\parse;

function genDiff(string $pathToFile1, string $pathToFile2, string $format): string
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

    // Выбираем форматтер в зависимости от переданного аргумента
    switch ($format) {
        case 'stylish':
            $formatter = new StylishFormatter();
            break;
        case 'plain':
            $formatter = new PlainFormatter();
            break;
        default:
            throw new \InvalidArgumentException("Unsupported format: {$format}");
    }

    // Форматируем результат сравнения в соответствии с выбранным форматом
    if ($format === 'plain') {
        return $formatter->format($diff);
    } else {
        return $formatter->formatDiff($diff);
    }
}

function buildDiff(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);

    $diff = [];
    foreach ($keys as $key) {
        if (!array_key_exists($key, $data2)) {
            $diff[] = ["type" => "removed", "key" => $key, "value" => $data1[$key]];
        } elseif (!array_key_exists($key, $data1)) {
            $diff[] = ["type" => "added", "key" => $key, "value" => $data2[$key]];
        } elseif ($data1[$key] === $data2[$key]) {
            $diff[] = ["type" => "unchanged", "key" => $key, "value" => $data1[$key]];
        } else {
            $diff[] = ["type" => "changed", "key" => $key, "oldValue" => $data1[$key], "newValue" => $data2[$key]];
        }
    }

    return $diff;
}
