<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonRepositoryInterface;

class PersonRepository implements PersonRepositoryInterface
{
    public function isExists(string $personId): bool
    {
        return PersonEntity::whereKey($personId)->exists();
    }

    public function save(?string $id, PersonDataModel $data): PersonEntity
    {
        if (!is_null($id) || !blank($id)) {
            $entity = PersonEntity::findOrFail($id);
            $entity->updateFromData($data);
            $entity->save();
            return $entity;
        }
        $entity = PersonEntity::createFromData($data);
        $entity->save();
        return $entity;
    }

    public function delete(string $id): bool
    {
        $entity = PersonEntity::findOrFail($id);
        return $entity->delete();
    }
}