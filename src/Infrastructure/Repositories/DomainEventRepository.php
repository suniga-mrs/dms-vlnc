<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Shared\DomainEventEntity;
use App\Domain\Shared\DomainEventInterface;
use App\Domain\Shared\DomainEventRepositoryInterface;

class DomainEventRepository implements DomainEventRepositoryInterface
{
    public function store(DomainEventInterface $event): void
    {
        $normalizedEntityId = strtolower($event->getEntityId());
        $sequence = DomainEventEntity::where('entity_id', $normalizedEntityId)
            ->where('entity_type', $event->getEntityType())
            ->max('sequence_number') ?? 0;
        $entity = DomainEventEntity::create([
            'entity_id'       => $normalizedEntityId,
            'entity_type'     => $event->getEntityType(),
            'event_type'      => get_class($event),
            'created_by_id'   => $event->getCreatedById(),
            'timestamp'       => $event->getOccurredAt(),
            'event_json'      => $event->toJsonPayload(),
            'sequence_number' => $sequence + 1,
        ]);
        $entity->save();
    }
}