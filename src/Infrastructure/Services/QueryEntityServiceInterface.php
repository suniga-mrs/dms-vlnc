<?php

namespace App\Infrastructure\Services;

interface QueryEntityServiceInterface
{
    public function getPaginatedResults(mixed $queryModel, int $page, int $perPage): mixed;
}