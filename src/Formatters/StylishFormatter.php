<?php

namespace Hexlet\Code\Formatters;

class StylishFormatter
{
    public static function format(array $diff): string
    {
        return self::buildStylish($diff);
    }

    private static function buildStylish(array $diff, int $depth = 1): string
    {
        $indentSize = 4;
        $indent = str_repeat(' ', $indentSize * $depth);

        $lines = array_map(function ($key, $value) use ($indent, $depth) {
            $formattedValue = is_array($value) ? self::buildStylish($value, $depth + 1) : self::formatValue($value, $depth);
            return "{$indent}  {$key}: {$formattedValue}";
        }, array_keys($diff), $diff);

        return "{\n" . implode("\n", $lines) . "\n{$indent}}";
    }

    private static function formatValue($value, int $depth): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_null($value)) {
            return 'null';
        }
        if (is_array($value)) {
            return self::buildStylish($value, $depth + 1);
        }
        return $value;
    }
}
