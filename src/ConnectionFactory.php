<?php

declare(strict_types = 1);

namespace FireHead996\Database;

interface ConnectionFactory
{
    public function create(): Connection;
}
