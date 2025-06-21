<?php

namespace App\Domain\Person;

use App\Domain\Person\PersonDataModel;
use Illuminate\Support\Collection;

interface PersonRepositoryInterface
{
    public function isExists(string $personId): bool;
    public function save(?string $id, PersonDataModel $data): PersonEntity;
    public function delete(string $id): bool;
    
    /**
     * @return Collection<int, PersonDataModel>
     */
    public function getList(PersonQueryModel $queryModel, int $page, int $perPage): Collection;
}