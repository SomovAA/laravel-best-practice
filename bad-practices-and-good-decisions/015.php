<?php

/**
 * Принцип подстановки Барбары Лисков
 */

/**
 * У нас есть коллекция, у которой есть метод добавления одного элемента
 */
class Collection
{
    protected array $items = [];

    public function add($obj)
    {
        $this->items[] = $obj;
    }
}

/**
 * Теперь постараемся нарушить этот принцип у наследника
 */

class UserCollection extends Collection
{
    public function add($obj)
    {
        $this->items[] = $obj;
        $this->items[] = $obj;
    }
}

/**
 * Вот мы и получили наследника, у которого метод добавляет элемент дважды в коллекцию,
 * т.е. данный подкласс не может быть заменой супер класса
 */