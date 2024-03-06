<?php

namespace Hexlet\Code;

use Hexlet\Code\Formatters\StylishFormatter;
use Hexlet\Code\Formatters\PlainFormatter;
use Hexlet\Code\Formatters\JsonFormatter;

class Formatter
{
    public static function getFormatter($formatName)
    {
        switch ($formatName) {
            case 'stylish':
                return new StylishFormatter();
            case 'plain':
                return new PlainFormatter();
            case 'json':
                return new JsonFormatter();
            default:
                throw new \InvalidArgumentException("Неизвестный формат: {$formatName}");
        }
    }
}
