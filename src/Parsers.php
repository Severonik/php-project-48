<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function parse($content, $format)
{
    return match ($format) {
        'json' => json_decode($content, true),
        'yaml', 'yml' => Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \Exception("Unsupported file format: {$format}"),
    };
}
