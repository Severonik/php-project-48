<?php

namespace Hexlet\Code\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($content, $format)
{
    return match ($format) {
        'json' => json_decode($content, true),
        'yaml', 'yml' => Yaml::parse($content),
        default => throw new \Exception("Unsupported file format: {$format}"),
    };
}
