<?php

declare(strict_types = 1);

namespace FireHead996\Database;

interface Statement
{
    public function fetch(string $classOrClassName): object;

    public function fetchAll(string $classOrClassName): array;
}
