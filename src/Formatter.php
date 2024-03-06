<?php

namespace Hexlet\Code;

use Hexlet\Code\Formatters\StylishFormatter;
use Hexlet\Code\Formatters\PlainFormatter;

class Formatter
{
    public static function getFormatter($formatName)
    {
        switch ($formatName) {
            case 'stylish':
                return new StylishFormatter();
            case 'plain':
                return new PlainFormatter();
            default:
                throw new \InvalidArgumentException("Неизвестный формат: {$formatName}");
        }
    }
}
