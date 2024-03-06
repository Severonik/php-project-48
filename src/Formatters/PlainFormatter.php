<?php

namespace Hexlet\Code\Formatters;

class PlainFormatter
{
    public function format(array $diff): string
    {
        $lines = [];
        foreach ($diff as $item) {
            switch ($item['type']) {
                case 'added':
                    $lines[] = "Property '{$item['key']}' was added with value: {$this->formatValue($item['value'])}";
                    break;
                case 'removed':
                    $lines[] = "Property '{$item['key']}' was removed";
                    break;
                case 'updated':
                    $lines[] = "Property '{$item['key']}' was updated. From {$this->formatValue($item['oldValue'])} to {$this->formatValue($item['newValue'])}";
                    break;
            }
        }
        return implode("\n", $lines) . "\n";
    }

    private function formatValue($value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            return '[complex value]';
        } elseif (is_null($value)) {
            return 'null';
        } else {
            return "'" . $value . "'";
        }
    }
}