<?php

namespace App\Domain\Shared;

use \DateTimeImmutable;

interface DomainEventInterface
{
    public function getEntityId(): string;
    public function getEntityType(): string;
    public function getCreatedById(): ?string;
    public function getOccurredAt(): DateTimeImmutable;
    public function toJsonPayload(): string;
}