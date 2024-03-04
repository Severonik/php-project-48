<?php

namespace Hexlet\Code\Formatters;

function format($diff, $formatName)
{
    switch ($formatName) {
        case 'stylish':
            return stylish($diff);
        default:
            throw new \Exception("Unknown format: {$formatName}");
    }
}
