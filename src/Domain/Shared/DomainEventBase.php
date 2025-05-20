<?php

namespace App\Domain\Shared;

use App\Domain\Shared\DomainEventInterface;
use \DateTimeImmutable;

abstract class DomainEventBase implements DomainEventInterface, \JsonSerializable
{
    protected string $entityId;
    protected string $entityType;
    protected ?string $createdById;
    protected DateTimeImmutable $occurredAt;

    public function __construct(string $entityId, string $entityType, ?string $createdById = null)
    {
        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->createdById = $createdById;
        $this->occurredAt = new DateTimeImmutable();
    }

    public function getEntityId(): string
    {
        return $this->entityId;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function getCreatedById(): ?string
    {
        return $this->createdById;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function toJsonPayload(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    }

    // Require child classes to define serialization
    abstract public function jsonSerialize(): array;
}