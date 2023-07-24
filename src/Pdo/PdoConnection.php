<?php

declare(strict_types = 1);

namespace FireHead996\Database\Pdo;

use FireHead996\Database\Connection;
use FireHead996\Database\Statement;
use PDO;

final class PdoConnection implements Connection
{
    public function __construct(
        private PDO $connection
    ) {
    }

    public function query(string $query, array $params = []): Statement
    {
        $statement = new PdoStatement($this->connection->prepare($query));
        $statement->prepareParams($params);
        $statement->execute();

        return $statement;
    }
}
