<?php

namespace App\Infrastructure\Services;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Person\PersonEntity;

class PersonQueryService extends QueryEntityService
{
    protected function buildQuery(mixed $queryModel): Builder
    {
        $query = PersonEntity::query();
        if (!empty($queryModel['first_name'])) {
            $query->where('first_name', 'like', '%' . $queryModel['first_name'] . '%');
        }
        return $query;
    }   

    protected array $includedColumns = [
        'first_name',
        'last_name',
        'life_stage_id',
        'gender',
        'birthdate',
    ];
}