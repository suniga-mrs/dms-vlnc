<?php

namespace App\Application\EventHandlers;

use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\Events\SmallGroupUpdatedEvent;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Domain\SmallGroup\SmallGroupDataModel;
use App\Domain\Shared\DomainEventRepositoryInterface;
use App\Domain\Shared\UnitOfWorkInterface;

class SmallGroupEventHandler
{

    public function __construct(
        private SmallGroupRepositoryInterface $smallGroupRepository,
        private DomainEventRepositoryInterface $eventRepository,
        private UnitOfWorkInterface $unitOfWork
    ) { }

    public function handle(object $event): void
    {
        $this->unitOfWork->execute(function () use ($event) {            
            match(true) {
                $event instanceof SmallGroupCreatedEvent => $this->handleCreate($event),
                $event instanceof SmallGroupUpdatedEvent => $this->handleUpdated($event->getEntityId(), $event),
            };    
            $this->eventRepository->store($event);
        });      
    }

    private function handleCreate(SmallGroupCreatedEvent $event): void
    {
           $data = SmallGroupDataModel::fromCreateEvent($event);
           $this->smallGroupRepository->create( $data);
    }

    private function handleUpdated(?string $id, SmallGroupUpdatedEvent $event): void
    {
           $data = SmallGroupDataModel::fromUpdateEvent($event);
           $this->smallGroupRepository->update($id, $data);
    }
}