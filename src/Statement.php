<?php

declare(strict_types = 1);

namespace FireHead996\Database;

use Traversable;

interface Statement
{
    public function fetch(string $classOrClassName): Entity;

    public function fetchAll(string $classOrClassName): array;

    public function rowCount(): int;

    public function getIterator(): Traversable;
}
