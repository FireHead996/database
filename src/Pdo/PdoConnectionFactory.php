<?php

declare(strict_types = 1);

namespace FireHead996\Database\Pdo;

use FireHead996\Database\Connection;
use FireHead996\Database\ConnectionFactory;
use PDO;

final class PdoConnectionFactory implements ConnectionFactory
{
    private string $driver;

    private string $host;

    private string $username;

    private string $password;

    private string $name;

    public function __construct(array $settings)
    {
        $this->driver = $settings['driver'];
        $this->host = $settings['host'];
        $this->username = $settings['username'];
        $this->password = $settings['password'];
        $this->name = $settings['name'];
    }

    private function getConnectionString(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s',
            $this->driver,
            $this->host,
            $this->name
        );
    }

    public function create(): Connection
    {
        $pdo = new PDO(
            $this->getConnectionString(),
            $this->username,
            $this->password
        );

        return new PdoConnection($pdo);
    }
}
