<?php

namespace App\Application\EventHandlers;

use App\Domain\Events\SmallGroupCreatedEvent;
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

        $this->eventRepository->store($event);

        // match(true) {
        //     $event instanceof SmallGroupCreatedEvent => $this->handleCreated($event),
        // };
    }

    // private function handleCreated(SmallGroupCreatedEvent $event): void
    // {
    //     // $this->unitOfWork->execute(function () use ($event) {
    //         $this->eventRepository->store($event);
    //     // });         
    // }
}