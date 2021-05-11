<?php

/**
 * Пример с одним return при использовании множества вложенных конструкций if else
 */
class PaymentSystem
{
    public function pay(string $orderId, int $cost): int
    {
        if ($cost > 0) {
            if ($orderId > 0 && $orderId < 200) {
                if ($cost > 200) {
                    $result = 100;
                } elseif ($cost > 0 && $cost <= 150) {
                    $result = 150;
                } else {
                    throw new RuntimeException();
                }
            } elseif ($orderId >= 200 && $orderId < 500) {
                $result = 1000;
            } else {
                if ($cost < 500) {
                    $result = 300;
                } else {
                    throw new Exception();
                }
            }
        } else {
            throw new InvalidArgumentException();
        }

        return $result;
    }
}

/**
 * Это увеличивает цикломатическую сложность, код становится нечитабельным.
 * Чтобы дойти до определенного места, приходится все время продумывать эти условия.
 * И это лишь пример с цикломатической сложностью равной 3, бывает ещё больше вложенностей...
 */
class CorrectPaymentSystem
{
    public function pay(string $orderId, int $cost): int
    {
        if ($cost <= 0) {
            throw new InvalidArgumentException();
        }

        if ($orderId > 0 && $orderId < 200) {
            if ($cost > 200) {
                return 100;
            }

            if ($cost <= 150) {
                return 150;
            }

            throw new RuntimeException();
        }

        if ($orderId >= 200 && $orderId < 500) {
            return 1000;
        }

        if ($cost < 500) {
            return 300;
        }

        throw new Exception();
    }
}

/**
 * Теперь намного лучше! Не всегда можно вложенности равной 1 добиться, но в некоторых местах это получилось сделать.
 * Если здесь сделать вложенность равной 1 будет дублирование условий, что ещё хуже
 * Можно делать return и с возвращаемым типом void, выглядит это так 'return;'
 */
/**
 * Тоже самое касается и циклов, только там можно сделать выход или продолжение через break и continue
 */
$ids = [];

$sum = 0;
foreach ($ids as $id) {
    if ($id == 13) {
        $sum += 1;
    } elseif ($id == 44) {
        $sum += 2;
    } elseif ($id == 50) {
        break;
    } else {
        $sum += 3;
    }
}

/**
 * Вот в более читабельном виде
 */

$sum = 0;
foreach ($ids as $id) {
    if ($id == 13) {
        $sum += 1;

        continue;
    }

    if ($id == 44) {
        $sum += 2;

        continue;
    }

    if ($id == 50) {
        break;
    }

    $sum += 3;
}