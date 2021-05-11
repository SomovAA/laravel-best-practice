<?php

/**
 * Пример с магией
 */

class Router
{
    protected function prefix(): string
    {
        return '';
    }

    public function __call($a, $b)
    {
        return [
            'Я сделалъ'
        ];
    }
}

$router = new Router();
print_r($router->prefix());

/**
 * Старайтесь делать всегда без магии, используя новый метод с подходящим названием
 */
class CorrectRouter
{
    public function prefixes(): array
    {
        return [
            'Я сделалъ'
        ];
    }
}

$router = new CorrectRouter();
print_r($router->prefixes());