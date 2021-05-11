<?php

/**
 * Работа с массивами
 */

class User
{
    protected string $firstName;
    protected string $lastName;
    protected string $secondName;
    protected string $birthDay;
    protected string $passport;
    protected bool $forceScore = true;

    protected function validateForceScoreFields(): bool
    {
        if ($this->forceScore === true) {
            $fields = [
                'firstName',
                'lastName',
                'secondName',
                'birthDay',
                'passport',
            ];

            foreach ($fields as $field) {
                if ($this->$field === null) {
                    throw new InvalidArgumentException($field, $this);
                }
            }
        }

        return true;
    }
}

/**
 * К примеру я хочу изменить название свойства firstName на firstName2. Как такие места рефакторить?
 * Вам IDE тут ничем не поможет, т.к. она не найдет это и не заменит.
 * Нет подсветки и велика вероятность сделать опечатку в ключах массива...
 * Не желательно так делать
 */
