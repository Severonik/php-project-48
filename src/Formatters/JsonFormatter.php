<?php

namespace Hexlet\Code\Formatters;

class JsonFormatter
{
    /**
     * Форматирует разницу в формате JSON.
     *
     * @param array $diff Дифференциальная разница между двумя данными
     *
     * @return string Строковое представление отформатированной разницы
     */
    public function format(array $diff): string
    {
        return json_encode($diff, JSON_PRETTY_PRINT);
    }
}
