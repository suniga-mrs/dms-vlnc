<?php

namespace App\Application\EventHandlers;

use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\Events\SmallGroupSaveAbstract;
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
                $event instanceof SmallGroupCreatedEvent => $this->handleSave(null, $event),
                $event instanceof SmallGroupUpdatedEvent => $this->handleSave($event->getEntityId(), $event),
            };    
            $this->eventRepository->store($event);
        });      
    }

    private function handleSave(?string $id, SmallGroupSaveAbstract $event): void
    {
           $data = SmallGroupDataModel::fromSaveEvent($event);
           $this->smallGroupRepository->save($id, $data);
    }
}