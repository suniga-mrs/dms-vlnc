<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Domain\SmallGroup\SmallGroupDataModel;

class SmallGroupRepository implements SmallGroupRepositoryInterface
{
    public function get(string $id): SmallGroupEntity
    {
        return SmallGroupEntity::findOrFail($id);
    }

    public function create(SmallGroupDataModel $data): SmallGroupEntity
    {
        $entity = SmallGroupEntity::createFromData($data);
        $entity->save();
        return $entity;
    }

    public function update(?string $id, SmallGroupDataModel $data): SmallGroupEntity
    {
        $entity = SmallGroupEntity::findOrFail($id);
        $entity->updateFromData($data);
        $entity->save();
        return $entity;
    }

    public function delete(string $id): bool
    {
        $entity = SmallGroupEntity::findOrFail($id);
        return $entity->delete();
    }
}