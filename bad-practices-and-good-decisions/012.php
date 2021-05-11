<?php

/**
 * Волшебные константы
 */
class OrderCalculator
{
    public function calculate(array $ids): int
    {
        $sum = 0;
        foreach ($ids as $id) {
            if ($id === 13 || $id === 54) {
                $sum += 1;

                continue;
            }

            $sum += 1;
        }

        return $sum;
    }
}

/**
 * Что за константы 13 и 54 тут не понятно, а ниже уже понятнее
 */
class CorrectOrderCalculator
{
    // Срок годности истек
    public const EXPIRATION_DATE_OUT_ID = 13;

    // Товар с дефектом
    public const WITH_DEFECT_ID = 54;

    public function calculate(array $ids): int
    {
        $sum = 0;
        foreach ($ids as $id) {
            if ($id === static::EXPIRATION_DATE_OUT_ID || $id === static::WITH_DEFECT_ID) {
                $sum += 1;

                continue;
            }

            $sum += 1;
        }

        return $sum;
    }
}

/**
 * Если по чистому коду делать, то лучше это логику вынести в метод, так будет понятно из названия,
 * и не нужно будет проваливаться при чтении в него
 */
class CorrectOrderWithCleanArchitectureCalculator
{
    // Срок годности истек
    public const EXPIRATION_DATE_OUT_ID = 13;

    // Товар с дефектом
    public const WITH_DEFECT_ID = 54;

    public function calculate(array $ids): int
    {
        $sum = 0;
        foreach ($ids as $id) {
            if ($this->isBadOrder($id)) {
                $sum += 1;

                continue;
            }

            $sum += 1;
        }

        return $sum;
    }

    private function isBadOrder(int $id): bool
    {
        return $id === static::EXPIRATION_DATE_OUT_ID || $id === static::WITH_DEFECT_ID;
    }
}
/**
 * Помните, это может касаться не только числовых значений, но и строковых
 */