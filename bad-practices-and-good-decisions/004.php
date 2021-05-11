<?php

/**
 * Пример с классом, для которого нельзя сделать заглушку
 */
final class Logger
{
    public function info(string $message): void
    {

    }
}

class ApocalypseChecker
{
    private const JUDGMENT_TIME = '2030-05-19T15:16:30+0700';// дата высечена на камне
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function isStarted(DateTimeImmutable $now): bool
    {
        $this->logger->info('Я сделалъ!');

        return (new DateTimeImmutable(static::JUDGMENT_TIME))->getTimestamp() <= $now->getTimestamp();
    }
}

/**
 * Я хочу проверить два сценария - true и false модульно, заглушая всё лишнее
 * Как мне это сделать?
 * Финальный класс нельзя заглушить, а как думаете почему?
 * Потому что тесты используют наследование при использовании заглушек.
 * Поэтому лучше не связываться с финальными классами, также лучше делать инверсию зависимостей, а не инъекцию,
 * тогда тесты будут использовать анонимные классы при использовании заглушек.
 * По SOLID(здесь конкретно буква D)
 */
interface CorrectLoggerInterface
{
    public function info(string $message): void;
}

class CorrectLogger implements CorrectLoggerInterface
{
    public function info(string $message): void
    {

    }
}

class CorrectApocalypseChecker
{
    private const JUDGMENT_TIME = '2030-05-19T15:16:30+0700';// дата высечена на камне
    private CorrectLoggerInterface $logger;

    public function __construct(CorrectLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function isStarted(DateTimeImmutable $now): bool
    {
        $this->logger->info('Я сделал хорошо!');

        return (new DateTimeImmutable(static::JUDGMENT_TIME))->getTimestamp() <= $now->getTimestamp();
    }
}