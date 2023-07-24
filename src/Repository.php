<?php

declare(strict_types = 1);

namespace FireHead996\Database;

interface Repository
{
    public function find(string $id): Entity;

    public function fetchByParameters(array $parameters): Entity;

    public function fetchAll(): array;

    public function persist(Entity $entity): void;

    public function delete(Entity $entity): void;
}
