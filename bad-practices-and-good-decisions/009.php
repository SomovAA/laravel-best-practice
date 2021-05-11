<?php

/**
 * Неатомарное создание, через множество последовательных вызовов сеттеров
 */

class Name
{
    private string $first;
    private string $middle;
    private string $last;

    public function setFirst(string $first): void
    {
        $this->first = $first;
    }

    public function setMiddle(string $middle): void
    {
        $this->middle = $middle;
    }

    public function setLast(string $last): void
    {
        $this->last = $last;
    }

    public function getFio(): string
    {
        return sprintf('%s %s %s', $this->first, $this->middle, $this->last);
    }
}

/**
 * Чтобы метод getFio() не кидал исключение, вам придется явно вызвать все сеттеры, если один забыли, то беда...
 * И так во всех местах, где вы работаете с этим объектом
 */

$name = new Name();
$name->setFirst('Иван');
$name->setMiddle('Иванович');
$name->setLast('Иванов');

echo $name->getFio();

/**
 * Нужно сделать через конструктор
 */

class CorrectName
{
    private string $first;
    private string $middle;
    private string $last;

    public function __construct(string $first, string $middle, string $last)
    {
        $this->first = $first;
        $this->middle = $middle;
        $this->last = $last;
    }

    public function getFio(): string
    {
        return sprintf('%s %s %s', $this->first, $this->middle, $this->last);
    }
}

$name = new CorrectName( 'Иван', 'Иванович', 'Иванов');
echo $name->getFio();