<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;

class SmallGroupRepository implements SmallGroupRepositoryInterface
{
    public function save(string $id, array $data): SmallGroupEntity
    {
        if (!blank($id)) {
            $entity = SmallGroupEntity::findOrFail($id);
            $entity->update($data);
            return $entity;
        }
        return SmallGroupEntity::create($data);
    }

    public function delete(string $id): bool
    {
        $entity = SmallGroupEntity::findOrFail($id);
        return $entity->delete();
    }
}