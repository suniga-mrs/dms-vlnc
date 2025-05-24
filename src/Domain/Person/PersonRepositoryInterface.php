<?php

namespace App\Domain\Person;

use App\Domain\Person\PersonDataModel;

interface PersonRepositoryInterface
{
    public function isExists(string $personId): bool;
    public function save(?string $id, PersonDataModel $data): PersonEntity;
    public function delete(string $id): bool;
}