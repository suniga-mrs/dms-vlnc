<?php

namespace App\Domain\Person;

use App\Domain\Person\PersonDataModel;

interface PersonRepositoryInterface
{
    public function save(?string $id, PersonDataModel $data): PersonEntity;
    public function delete(string $id): bool;
}