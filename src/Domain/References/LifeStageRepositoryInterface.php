<?php

namespace App\Domain\References;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface LifeStageRepositoryInterface
{
    public function save(?int $id, array $data): LifeStageEntity;

    public function delete(int $id): bool;

    /**
     * @return LifeStageEntity[] 
     */
    public function all(): EloquentCollection;
}