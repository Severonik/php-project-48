<?php

namespace Hexlet\Code\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($content, $format)
{
    error_log("Parsing content with format: $format");
    error_log("Content: $content");

    return match ($format) {
        'json' => json_decode($content, true),
        'yaml', 'yml' => Yaml::parse($content),
        default => throw new \Exception("Unsupported file format: {$format}"),
    };
}
