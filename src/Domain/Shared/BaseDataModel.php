<?php

namespace App\Domain\Shared;

use \DateTimeImmutable;

abstract class BaseDataModel {
    readonly public ?string $createdById;
    readonly public ?string $createdByName;
    readonly public ?DateTimeImmutable $createdAt;
    readonly public ?DateTimeImmutable $updatedAt;

    public function setBaseProperties(
        ?DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt,
        ?string $createdById,
        ?string $createdByName
    ): void
    {
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->createdById = $createdById;
        $this->createdByName = $createdByName;
    }
}