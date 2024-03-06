<?php

namespace Hexlet\Code;

use Hexlet\Code\Formatters\JsonFormatter;
use Hexlet\Code\Formatters\StylishFormatter;
use Hexlet\Code\Formatters\PlainFormatter;
use function Hexlet\Code\Parsers\parse;

class Differ
{
    /**
     * Сравнивает два файла и возвращает отформатированную разницу.
     *
     * @param string $pathToFile1 Путь к первому файлу
     * @param string $pathToFile2 Путь ко второму файлу
     * @param string $format      Формат вывода разницы (json, stylish, plain)
     *
     * @return string Отформатированная разница между файлами
     */
    public function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
    {
        $data1 = parse(file_get_contents($pathToFile1), pathinfo($pathToFile1, PATHINFO_EXTENSION));
        $data2 = parse(file_get_contents($pathToFile2), pathinfo($pathToFile2, PATHINFO_EXTENSION));

        $diff = $this->buildDiff($data1, $data2);

        switch ($format) {
            case 'stylish':
                $formatter = new StylishFormatter();
                break;
            case 'plain':
                $formatter = new PlainFormatter();
                break;
            case 'json':
                $formatter = new JsonFormatter();
                break;
            default:
                throw new \InvalidArgumentException("Unknown format: {$format}");
        }

        return $formatter->format($diff);
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

}
