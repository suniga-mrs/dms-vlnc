<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;

class SmallGroupRepository implements SmallGroupRepositoryInterface
{
    public function save(string $id, array $data): SmallGroupEntity
    {
        if (!blank($id)) {
            $person = SmallGroupEntity::findOrFail($id);
            $person->update($data);
            return $person;
        }
        return SmallGroupEntity::create($data);
    }

    public function delete(string $id): bool
    {
        $person = SmallGroupEntity::findOrFail($id);
        return $person->delete();
    }
}