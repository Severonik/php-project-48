<?php

namespace Hexlet\Code\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($content, $format)
{
    switch ($format) {
        case 'json':
            return json_decode($content, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($content);
        default:
            throw new \Exception("Unsupported file format: {$format}");
    }
}

// Дополнительная функция, которая преобразует данные, чтобы они всегда были в нужном формате
function ensureArrayFormat(array $data): array
{
    $result = [];
    foreach ($data as $key => $value) {
        $result[] = [$key, $value];
    }
    return $result;
}