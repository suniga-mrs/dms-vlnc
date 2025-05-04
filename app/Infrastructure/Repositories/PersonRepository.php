<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;

class PersonRepository implements PersonRepositoryInterface
{
    public function save(string $id, array $data): PersonEntity
    {
        if (!blank($id)) {
            $person = PersonEntity::findOrFail($id);
            $person->update($data);
            return $person;
        }
        return PersonEntity::create($data);
    }

    public function delete(string $id): bool
    {
        $person = PersonEntity::findOrFail($id);
        return $person->delete();
    }
}