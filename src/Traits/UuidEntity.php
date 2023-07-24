<?php

declare(strict_types = 1);

namespace FireHead996\Database\Traits;

use Ramsey\Uuid\Uuid;

trait UuidEntity
{
    public function __construct(
        private ?string $id = null
    ) {
        if (is_null($this->id)) {
            $this->id = Uuid::uuid4();
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id;
    }
}
