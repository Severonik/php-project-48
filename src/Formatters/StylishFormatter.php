<?php

namespace Hexlet\Code\Formatters;

function stylish($diff)
{
    return buildStylish($diff);
}

function buildStylish($diff, $depth = 1)
{
    $indentSize = 4;
    $indent = str_repeat(' ', $indentSize * $depth);

    $formattedLines = array_map(function ($key) use ($diff, $depth, $indentSize) {
        $node = $diff[$key];
        switch ($node['type']) {
            case 'nested':
                $value = buildStylish($node['children'], $depth + 1);
                $formattedValue = implode("\n", $value);
                return "{$indent}{$key}: {\n{$formattedValue}\n{$indent}}";
            case 'added':
                $formattedValue = stringifyValue($node['value'], $depth);
                return "{$indent}+ {$key}: {$formattedValue}";
            case 'removed':
                $formattedValue = stringifyValue($node['value'], $depth);
                return "{$indent}- {$key}: {$formattedValue}";
            case 'unchanged':
                $formattedValue = stringifyValue($node['value'], $depth);
                return "{$indent}  {$key}: {$formattedValue}";
            case 'changed':
                $formattedOldValue = stringifyValue($node['oldValue'], $depth);
                $formattedNewValue = stringifyValue($node['newValue'], $depth);
                return "{$indent}- {$key}: {$formattedOldValue}\n{$indent}+ {$key}: {$formattedNewValue}";
            default:
                throw new \Exception("Unknown node type: {$node['type']}");
        }
    }, array_keys($diff));

    return $formattedLines;
}

function stringifyValue($value, $depth)
{
    if (is_array($value)) {
        $formattedValue = implode("\n", buildStylish($value, $depth + 1));
        return "{\n{$formattedValue}\n" . str_repeat(' ', 4 * $depth) . "}";
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    } else {
        return $value;
    }
}
