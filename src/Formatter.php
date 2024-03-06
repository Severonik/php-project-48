<?php

namespace Hexlet\Code;

use Hexlet\Code\Formatters\StylishFormatter;

class Formatter
{
    public static function getFormatter($formatName)
    {
        switch ($formatName) {
            case 'stylish':
                return new StylishFormatter();
            default:
                throw new \InvalidArgumentException("Неизвестный формат: {$formatName}");
        }
    }
}
