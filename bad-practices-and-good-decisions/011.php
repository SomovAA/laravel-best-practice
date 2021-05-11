<?php

/**
 * Неинкапсулированная логика
 */
/*
if (app()->environment() == "production") {

}

if ($this->app->environment() != 'testing') {

}

if (Application::environment() === 'local') {

}
*/
/**
 * А если у нас поменяется условие, к примеру вместо testing станет test?
 * Или добавится ещё дополнительное условия для того, чтобы определить, что это тестовый режим?
 * Мы тогда будем искать все места, и во всех делать изменения, а они ещё могут выглядеть иначе, как
 * в примерах выше.
 * Следовательно здесь нужно применить паттерн Информационный эксперт из GRASP.
 * Там, где находятся данные, должна быть и логика, связанная с ними
 */
class CorrectApplication
{
    public const PRODUCTION = 'production';

    public const TESTING = 'testing';

    public const LOCAL = 'local';

    private string $environment;

    public function __construct(string $environment)
    {
        $this->checkValid($environment);
        $this->environment = $environment;
    }

    public function isProd(): bool
    {
        return $this->environment === static::PRODUCTION;
    }

    public function isTest(): bool
    {
        return $this->environment === static::TESTING;
    }

    public function isLocal(): bool
    {
        return $this->environment === static::LOCAL;
    }

    private function checkValid(string $environment): void
    {
        if (!in_array($environment, [static::PRODUCTION, static::TESTING, static::LOCAL])) {
            throw new InvalidArgumentException();
        }
    }
}

$application = new CorrectApplication('production');

if ($application->isProd()) {
    echo 'Это prod';
}

if ($application->isTest()) {
    echo 'Это test';
}

if ($application->isLocal()) {
    echo 'Это local';
}