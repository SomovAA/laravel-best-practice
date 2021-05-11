<?php

/**
 * Работа с массивами
 */

$data = [
    [
        'first_name' => 'Иванов',
        'middle_name' => 'Иван',
        'last_name' => 'Иванович',
        'age' => 15,
        'job' => false
    ],
    [
        'first_name' => 'Алексеевич',
        'middle_name' => 'Культов',
        'last_name' => 'Алексей',
        'age' => 20,
        'job' => true
    ],
    [
        'first_name' => 'Василий',
        'middle_name' => 'Протонов',
        'last_name' => 'Васильевич',
        'age' => 23,
        'job' => true
    ]
];

// ищем самого старшего
foreach ($data as $key => $value) {
    //ToDo: implements
}

// получаем тех, кто имеет работу
foreach ($data as $key => $value) {
    //ToDo: implements
}

/**
 * Логика лежит вне массива, а если вам нужно её использовать в разных местах будет дублирование кода
 * Поэтому делаем через классы
 */
class Name
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

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getMiddle(): string
    {
        return $this->middle;
    }

    public function getLast(): string
    {
        return $this->last;
    }
}

class User
{
    private Name $name;
    private int $age;
    private bool $job;

    public function __construct(Name $name, int $age, bool $job)
    {
        $this->name = $name;
        $this->age = $age;
        $this->job = $job;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function hasJob(): bool
    {
        return $this->job;
    }
}

class UserCollection
{
    protected SplObjectStorage $items;

    public function __construct()
    {
        $this->items = new SplObjectStorage();
    }

    public function add(User $user): void
    {
        $this->items->attach($user);
    }

    public function getOldest(): ?User
    {
        $array = $this->toArray();

        usort($array,
            function (User $one, User $two) {
                return $two->getAge() - $one->getAge();
            }
        );

        foreach ($array as $item) {
            return $item;
        }

        return null;
    }

    public function filterByHasJob(): self
    {
        $collection = new static();

        $array = array_filter(
            $this->toArray(),
            function (User $user) {
                return $user->hasJob();
            },
            ARRAY_FILTER_USE_BOTH
        );

        foreach ($array as $item) {
            $collection->add($item);
        }

        return $collection;
    }

    private function toArray(): array
    {
        return iterator_to_array($this->items);
    }
}

$users = new UserCollection();

$name = new Name('Иван', 'Иванович', 'Иванов');
$user = new User($name, 15, false);
$users->add($user);

$name = new Name('Алексей', 'Алексеевич', 'Культов');
$user = new User($name, 20, true);
$users->add($user);

$name = new Name('Василий', 'Васильевич', 'Протонов');
$user = new User($name, 23, true);
$users->add($user);

print_r($users->getOldest());
print_r($users->filterByHasJob());

/**
 * В итоге всё подсвечивается, код не нужно документировать, реализация скрыта, ей можно пользоваться в разных местах,
 * Легко сделать валидацию в самих классах, чтобы не было возможности создать некорректный объект
 */