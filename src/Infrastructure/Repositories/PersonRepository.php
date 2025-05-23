<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonRepositoryInterface;

class PersonRepository implements PersonRepositoryInterface
{
    public function save(?string $id, PersonDataModel $data): PersonEntity
    {
        if (!is_null($id) || !blank($id)) {
            $entity = PersonEntity::findOrFail($id);
            $entity->update($data);
            return $entity;
        }
        return PersonEntity::create($data);
    }

    public function delete(string $id): bool
    {
        $entity = PersonEntity::findOrFail($id);
        return $entity->delete();
    }
}