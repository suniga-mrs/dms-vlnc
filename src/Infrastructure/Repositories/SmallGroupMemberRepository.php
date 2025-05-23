<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SmallGroup\SmallGroupMemberEntity;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Domain\SmallGroup\SmallGroupDataModel;

class SmallGroupMemberRepository
{
    public function get(string $id): SmallGroupMemberEntity
    {
        return SmallGroupMemberEntity::findOrFail($id);
    }

    public function save(?string $id, SmallGroupDataModel $data): SmallGroupMemberEntity
    {
        if (!blank($id)) {
            $entity = SmallGroupMemberEntity::findOrFail($id);
            $entity->updateFromData($data);
            $entity->save();
            return $entity;
        }
        $entity = SmallGroupMemberEntity::createFromData($data);
        $entity->save();
        return $entity;
    }
}