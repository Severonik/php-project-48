<?php

namespace Hexlet\Code\Formatters;

class StylishFormatter
{
    /**
     * Форматирует разницу в стиль "стильный" (stylish) формат.
     *
     * @param array $diff   Дифференциальная разница между двумя данными
     * @param int   $depth  Глубина вложенности
     *
     * @return string Строковое представление отформатированной разницы
     */
    public function format(array $diff, int $depth = 1): string
    {
        $indentSize = 4;
        $indent = str_repeat(' ', $indentSize * $depth);
        $indent = (string) $indent;
        $result = [];

        foreach ($diff as $item) {
            $key = $item['key'];
            $type = $item['type'];

            switch ($type) {
                case 'nested':
                    // Проверяем, что значение 'children' является массивом
                    if (!is_array($item['children'])) {
                        throw new \InvalidArgumentException("Children should be an array");
                    }
                    $result[] = "{$indent}{$key}: " . $this->format($item['children'], $depth + 1);
                    break;
                case 'added':
                case 'removed':
                case 'unchanged':
                    $value = $this->formatValue($item['value'], $depth);
                    $result[] = "{$indent}{$this->getSignByType($type)} {$key}: {$value}";
                    break;
                case 'changed':
                    $oldValue = $this->formatValue($item['oldValue'], $depth);
                    $newValue = $this->formatValue($item['newValue'], $depth);
                    $result[] = "{$indent}- {$key}: {$oldValue}";
                    $result[] = "{$indent}+ {$key}: {$newValue}";
                    break;
                default:
                    throw new \InvalidArgumentException("Unknown operation type: {$type}");
            }
        }

        return implode("\n", $result);
    }

    /**
     * Форматирует значение для вставки в разницу.
     *
     * @param mixed $value  Значение для форматирования
     * @param int   $depth  Глубина вложенности
     *
     * @return string Строковое представление отформатированного значения
     */
    private function formatValue($value, int $depth): string
    {
        if (is_array($value)) {
            return $this->format($value, $depth + 1);
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_null($value)) {
            return 'null';
        } else {
            return (string) $value; // Преобразуем значение в строку
        }
    }

    /**
     * Возвращает символ, обозначающий тип операции.
     *
     * @param string $type  Тип операции ('added', 'removed', 'unchanged')
     *
     * @return string Символ операции
     */
    private function getSignByType(string $type): string
    {
        switch ($type) {
            case 'added':
                return '+';
            case 'removed':
                return '-';
            case 'unchanged':
                return ' ';
            default:
                throw new \InvalidArgumentException("Unknown operation type: {$type}");
        }
    }
}
