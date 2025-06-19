<?php

namespace App\Infrastructure\Services;

use App\Infrastructure\Services\QueryEntityServiceInterface;
use App\Infrastructure\Services\PersonQueryService;
use App\Domain\Enums\EntityEnum;
use InvalidArgumentException;

interface QueryEntityServiceFactoryInterface
{
    public function make(EntityEnum $model): QueryEntityServiceInterface;
}

class QueryEntityServiceFactory implements QueryEntityServiceFactoryInterface
{
    public function make(EntityEnum $model): QueryEntityServiceInterface
    {
        return match ($model) {
            EntityEnum::Person => app(PersonQueryService::class),
            default  => throw new InvalidArgumentException("No query service found for: $model"),
        };
    }
}