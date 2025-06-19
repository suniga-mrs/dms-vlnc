<?php

namespace App\Infrastructure\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class QueryEntityService implements QueryEntityServiceInterface
{
    protected array $includedColumns = [];

    abstract protected function buildQuery(mixed $queryModel): Builder;

    public function getPaginatedResults(mixed $queryModel, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->buildQuery($queryModel)
            ->paginate($perPage, $this->includedColumns, 'page', $page);
    }
}
