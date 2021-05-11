<?php

/**
 * Пример с методом, который протестировать невозможно
 */

class ApocalypseChecker
{
    private const JUDGMENT_TIME = '2030-05-19T15:16:30+0700';// дата высечена на камне

    public function isStarted(): bool
    {
        $now = new DateTimeImmutable();// здесь может быть вызов глобальной функции date() и другие вариации

        return (new DateTimeImmutable(static::JUDGMENT_TIME))->getTimestamp() <= $now->getTimestamp();
    }
}

/**
 * Я хочу проверить два сценария - true и false
 * Как мне это сделать? В самом тесте на лету подменить системное время?)
 * Нужно дату сегодняшнего дня передавать через параметр
 */
class CorrectApocalypseChecker
{
    private const JUDGMENT_TIME = '2030-05-19T15:16:30+0700';// дата высечена на камне

    public function isStarted(DateTimeImmutable $now): bool
    {
        return (new DateTimeImmutable(static::JUDGMENT_TIME))->getTimestamp() <= $now->getTimestamp();
    }
}
/**
 * При таком подходе я могу в тестах подставить и прошлую и настоящую и будущую дату, чтобы проверить работу этого метода,
 * не дожидаясь этого дня
 */