<?php
declare(strict_types=1);

function exampleAdd(int|float|string $a, int|float|string $b): int {
    return intval($a) + intval($b);
}

echo exampleAdd(10, 10);
echo exampleAdd('10', '10');
echo exampleAdd(10.0, 10.5);
