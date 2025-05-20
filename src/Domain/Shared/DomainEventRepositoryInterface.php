<?php

namespace App\Domain\Shared;

use App\Domain\Shared\DomainEventInterface;

interface DomainEventRepositoryInterface
{
    public function store(DomainEventInterface $event): void;
}