<?php

/**
 * Пример с магией, которая на лету расширяет функционал класса
 */

class Router
{
    protected static array $macros = [];

    public static function macro($name, $macro): void
    {
        static::$macros[$name] = $macro;
    }

    public static function hasMacro($name): bool
    {
        return isset(static::$macros[$name]);
    }

    public static function __callStatic($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            $macro = $macro->bindTo(null, static::class);
        }

        return $macro(...$parameters);
    }

    public function __call($method, $parameters)
    {
        if (! static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            $macro = $macro->bindTo($this, static::class);
        }

        return $macro(...$parameters);
    }
}

Router::macro('toUpper', function ($value) {
    return mb_strtoupper($value, 'UTF-8');
});

$upper = Router::toUpper('я сделалъ');
print_r($upper);
print_r(' | ');

$router = new Router();
$upper = $router->toUpper('я сделалъ');
print_r($upper);