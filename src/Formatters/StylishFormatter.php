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
        $result = [];

        foreach ($diff as $item) {
            switch ($item['type']) {
                case 'nested':
                    $result[] = "{$indent}{$item['key']}: " . $this->format($item['children'], $depth + 1);
                    break;
                case 'added':
                case 'removed':
                case 'unchanged':
                    $value = $this->formatValue($item['value'], $depth);
                    $result[] = "{$indent}{$this->getSignByType($item['type'])} {$item['key']}: {$value}";
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
        }

        return json_encode($value);
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
