# PHP8 Overview

## The null safe operator

Basically checks for `null` and when encountered stops the expression and returns
`null`.  Useful in object composition as no further calls will be made once `null`
is returned by anywhere along the chain. Think of it as `null` short circuiting.

```PHP
class Person
{
    private $name = null;
    private $occupation = null;

    public function setup(string $name, string $occupation)
    {
        $this->name = $name;
        $this->name = $occupation;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }
}

$personA = new Person();
var_dump($personA?->getName());
var_dump($personA?->getName() ?? 'Person has no name.');

$personB = new Person();
$personB->setup('Jhon', 'Doe');
var_dump($personB?->getName());
var_dump($personB?->getName() ?? 'Person has no name.');
```

## Match expression

Very useful new introduction. Can be used in any branching situation. And the
comparisons are strict `===`. Lookup table.

```PHP
function fizzbuzz($num) {
    print match (0) {
        $num % 15 => "FizzBuzz" . PHP_EOL,
        $num % 3  => "Fizz" . PHP_EOL,
        $num % 5  => "Buzz" . PHP_EOL,
        default   => $num . PHP_EOL,
    };
}

for ($i = 0; $i <=100; $i++)
{
    fizzbuzz($i);
}
```

## Constructor property promotion

Automatically sets a class's properties if accessibility properties are given
directly in the constructor.

```PHP
class Person
{
    public function __construct(
        private string $name,
        private string $occupation
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }
}
```

## Object class

Instead of needing to make use of `get_class($obj)` to get the class name of an
object. We can now use a call to a static member directly on the object.

```php
$someObject = new stdClass();

// Instead of doing this:
var_dump(get_class($someObject));

// We can now just do:
var_dump($someObject::class);
```

## Named parameters

Parameter naming allows us to pass arguments to a method by name and not order.
This helps avoid cases where we might need to respecify default arguments just
to get to set a parameter later down the line.

One issue is that if we make use of named parameters, the values we pass to the
method is becomes tightly coupled. If for example we're making use of a 3rd
party library, if they decide to refactor the parameter names it would cause an
issue. But regardless, they might also change the position in wish case the same
issue.

```php
function addNoteEntry( string $description = '', string $title = '', ?int $time = null ) {
    printf(
        'Description: %s, Title: %s, Time: %d',
        $description, $title, $time ?: time()
    );
}

addNoteEntry(
    title: 'My new note entry',
    time: time(),
);
```
## String Helpers

```php
// Returns true.
str_starts_with('prefix_some_data', 'prefix_');

// Returns true.
str_ends_with('prefix_some_data', '_data');

// Returns true.
str_contains('prefix_some_data', 'some');
```
## Weak Maps

Allows us to use `objects` as keys. Imagine using this to count the frequencies
of objects of specific objects in a collection of randomly created `objects`.

```php
// Some sample object.
$ourObject = new stdClass();
$ourObject->idx = 10;
$ourObject->direction = 'left';

// The new weak map.
$map = new WeakMap();

// Using our object as a key.
$map[$ourObject] = 'This object key as this value.';

// Using our object to retrieve the set value.
echo $map[$ourObject];
```

## Unions

Specify a collection of types as possible arguments. Only really makes sense if
you make use of `declare(strict_types=1)`. There's also a keyword as `mixed`
incase you want to take in anything.

```php
function exampleAdd(int|float|string $a, int|float|string $b): int {
    return intval($a) + intval($b);
}

echo exampleAdd(10, 10);
echo exampleAdd('10', '10');
echo exampleAdd(10.0, 10.5);
```