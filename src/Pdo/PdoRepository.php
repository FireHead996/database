<?php

declare(strict_types = 1);

namespace FireHead996\Database\Pdo;

use FireHead996\Database\Connection;
use FireHead996\Database\Entity;
use FireHead996\Database\Repository;

abstract class PdoRepository implements Repository
{
    public function __construct(
        private Connection $db,
        private string $entityName,
        private string $table
    ) {
    }

    public function find(string $id): Entity
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        $statement = $this->db->query($query, [
            ':id' => $id,
        ]);

        return $statement->fetch($this->entityName);
    }

    public function fetchByParameters(array $parameters): Entity
    {
        $query = "SELECT * FROM {$this->table} WHERE %s;";
        $paramString = $this->parseParamsAsString($parameters);
        $statement = $this->db->query(sprintf($query, $paramString), $parameters);

        return $statement->fetch($this->entityName);
    }

    public function fetchAll(): array
    {
        $query = "SELECT * FROM {$this->table};";
        $statement = $this->db->query($query);

        return $statement->fetchAll($this->entityName);
    }

    public function persist(Entity $entity): void
    {
        $params = new PdoParams($entity);

        $exists = $this->exists($entity);

        if ($exists) {
            $this->update($params);

            return;
        }

        $this->insert($params);
    }

    public function delete(Entity $entity): void
    {
        if (!$this->exists($entity)) {
            return;
        }

        $query = "DELETE FROM {$this->table} WHERE id = :id;";
        $this->db->query($query, [
            ':id' => $entity->getId(),
        ]);
    }

    private function insert(PdoParams $params): void
    {
        $schema = implode(', ', $params->getKeys());
        $values = $params->getAllFieldsToInsert();
        $sql = "INSERT INTO {$this->table} ($schema) VALUES ($values)";
        $this->db->query($sql, $params->getAllBindableParameters());
    }

    private function update(PdoParams $params): void
    {
        $values = $params->getAllFieldsToUpdate();
        $sql = "UPDATE {$this->table} SET $values WHERE id = :id";
        $this->db->query($sql, $params->getAllBindableParameters());
    }

    public function exists(Entity $entity): bool
    {
        $query = "SELECT id FROM {$this->table} WHERE id = :id;";
        $statement = $this->db->query($query, [
            ':id' => $entity->getId(),
        ]);

        return $statement->rowCount() === 1;
    }

    private function parseParamsAsString(array $parameters): string
    {
        $paramStrings = [];

        foreach ($parameters as $key) {
            array_push(
                $paramStrings,
                sprintf('%1$s = :%1$s', $key)
            );
        }

        return implode(' AND ', $paramStrings);
    }
}
