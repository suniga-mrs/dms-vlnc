<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Domain\References\LifeStageEntity;
use App\Domain\References\LifeStageRepositoryInterface;

class LifeStageRepository implements LifeStageRepositoryInterface
{
    public function save(?int $id, array $data): LifeStageEntity
    {
        if (!blank($id)) {
            $entity = LifeStageEntity::findOrFail($id);
            $entity->update($data);
            return $entity;
        }
        return LifeStageEntity::create($data);
    }

    public function delete(int $id): bool
    {
        $entity = LifeStageEntity::findOrFail($id);
        return $entity->delete();
    }

    /**
     * @return Collection|LifeStageEntity[]
     */
    public function all(): EloquentCollection
    {
        return LifeStageEntity::all();
    }
}