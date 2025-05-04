<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;

class PersonRepository implements PersonRepositoryInterface
{
    public function save(string $id, array $data): PersonEntity
    {
        if (!blank($id)) {
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