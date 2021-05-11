<?php

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Пример с методом, который протестировать модульно невозможно, нужно тянуть весь фреймворк
 */
class ApocalypseChecker
{
    private const JUDGMENT_TIME = '2030-05-19T15:16:30+0700';// дата высечена на камне

    public function isStarted(DateTimeImmutable $now): bool
    {
        /** @var LoggerInterface $logger */
        $logger = app()->get('logger');// здесь могут быть и фасады и другие обертки и способы, которые дергают singleton фреймворка
        $logger->info('Я сделалъ');

        return (new DateTimeImmutable(static::JUDGMENT_TIME))->getTimestamp() <= $now->getTimestamp();
    }
}

/**
 * Я хочу проверить два сценария - true и false модульно, заглушая всё лишнее
 * Как мне это сделать? В самом тесте на лету нужно подменять реализацию, делая инъекцию в контейнер внедрения зависимостей...
 * Это боль, это интеграционный тест. В некоторых случаях мы не работаем ни с файловым хранилищем, ни с БД и прочими
 * хранилищами или внешними сервисами.
 * Нужно это внедрять через конструктор и тогда легко можно будет заглушку использовать для LoggerInterface
 */
class CorrectApocalypseChecker
{
    private const JUDGMENT_TIME = '2030-05-19T15:16:30+0700';// дата высечена на камне
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function isStarted(DateTimeImmutable $now): bool
    {
        $this->logger->info('Я хорошо сделал!');

        return (new DateTimeImmutable(static::JUDGMENT_TIME))->getTimestamp() <= $now->getTimestamp();
    }
}

/**
 * А теперь представьте, что вы разрабатывали бы функционал для ракеты, каждая строчка кода которого тщательнейшим образом
 * проверяется разными программистами, и патентуется, т.е. далее этот код изменять невозможно.
 * Как же быть, чтобы его можно было расширить, и не затронуть при этом старый запатентованный код?
 * SOLID (В этом случае буква O) нам предлагает сделать вот так
 */
interface ApocalypseCheckerInterface
{
    public function isStarted(DateTimeImmutable $now): bool;
}

class CorrectBySolidApocalypseChecker implements ApocalypseCheckerInterface
{
    private const JUDGMENT_TIME = '2030-05-19T15:16:30+0700';// дата высечена на камне

    public function isStarted(DateTimeImmutable $now): bool
    {
        return (new DateTimeImmutable(static::JUDGMENT_TIME))->getTimestamp() <= $now->getTimestamp();
    }
}

/**
 * Теперь мы добавляем новый функционал, логирование
 */

class ApocalypseCheckerDecorator implements ApocalypseCheckerInterface
{
    private ApocalypseCheckerInterface $apocalypseChecker;
    private LoggerInterface $logger;

    public function __construct(ApocalypseCheckerInterface $apocalypseChecker, LoggerInterface $logger)
    {
        $this->apocalypseChecker = $apocalypseChecker;
        $this->logger = $logger;
    }

    public function isStarted(DateTimeImmutable $now): bool
    {
        $this->logger->info('Я хорошо сделал!');// вот оно расширение функционала

        return $this->apocalypseChecker->isStarted($now);// вот вызов старого кода
    }
}

$apocalypseChecker = new ApocalypseCheckerDecorator(new CorrectBySolidApocalypseChecker(), new NullLogger());
/**
 * В результате при наращивании нового функционала через декораторы, основной класс остается неизменным и его тесты тоже,
 * т.е. мы полностью уверенны в том, что он работает корректно, как и ранее + мы дописываем простые тесты для декоратора.
 * Также можно сделать и для кэширования и других наращиваний функционалов.
 */