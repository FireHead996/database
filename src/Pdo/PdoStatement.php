<?php

declare(strict_types = 1);

namespace FireHead996\Database\Pdo;

use FireHead996\Database\Entity;
use FireHead996\Database\Statement;
use IteratorAggregate;
use PDO;
use PDOStatement as DatabaseStatement;
use Traversable;

final class PdoStatement implements Statement, IteratorAggregate
{
    public function __construct(
        private DatabaseStatement $statement
    ) {
    }

    private function getParamType(mixed $value): int
    {
        switch (true) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }

    public function fetch(string $classOrClassName): Entity
    {
        return $this->statement->fetch(PDO::FETCH_CLASS);
    }

    public function fetchAll(string $classOrClassName): array
    {
        return $this->statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }

    public function prepareParams(array $params): void
    {
        foreach ($params as $key => $value) {
            $this->statement->bindValue($key, $value, $this->getParamType($value));
        }
    }

    public function execute(): void
    {
        $this->statement->execute();
    }

    public function getIterator(): Traversable
    {
        return $this->statement->getIterator();
    }
}
