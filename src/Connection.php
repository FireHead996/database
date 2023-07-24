<?php

declare(strict_types = 1);

namespace FireHead996\Database;

interface Connection
{
    public function query(string $query, array $params = []): Statement;
}
