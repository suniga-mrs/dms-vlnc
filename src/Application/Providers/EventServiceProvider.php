<?php

namespace App\Application\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\Events\SmallGroupUpdatedEvent;
use App\Application\EventHandlers\SmallGroupEventHandler;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SmallGroupCreatedEvent::class => [ SmallGroupEventHandler::class ],
        SmallGroupUpdatedEvent::class => [ SmallGroupEventHandler::class ],
    ];
}