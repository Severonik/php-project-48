<?php

namespace Hexlet\Code\Formatters;

class StylishFormatter
{
    public function buildStylish(array $diff, int $depth = 1): string
    {
        $indentSize = 4;
        $indent = str_repeat(' ', $indentSize * $depth);
        $result = [];
    
        foreach ($diff as $item) {
            switch ($item['type']) {
                case 'nested':
                    $nestedIndent = str_repeat(' ', $indentSize * ($depth + 1));
                    $result[] = "{$indent}{$item['key']}: {$this->buildStylish($item['children'], $depth + 1)}";
                    break;
                case 'added':
                    $value = $this->formatValue($item['value'], $depth);
                    $result[] = "{$indent}+ {$item['key']}: {$value}";
                    break;
                case 'removed':
                    $value = $this->formatValue($item['value'], $depth);
                    $result[] = "{$indent}- {$item['key']}: {$value}";
                    break;
                case 'unchanged':
                    $value = $this->formatValue($item['value'], $depth);
                    $result[] = "{$indent}  {$item['key']}: {$value}";
                    break;
                case 'changed':
                    $oldValue = $this->formatValue($item['oldValue'], $depth);
                    $newValue = $this->formatValue($item['newValue'], $depth);
                    $result[] = "{$indent}- {$item['key']}: {$oldValue}";
                    $result[] = "{$indent}+ {$item['key']}: {$newValue}";
                    break;
            }
        }
    
        return "{\n" . implode("\n", $result) . "\n}";
    }
    
    private function formatValue($value, int $depth): string
    {
        if (is_array($value)) {
            return $this->buildStylish($value, $depth + 1);
        }
        return json_encode($value);
    }
    
}
