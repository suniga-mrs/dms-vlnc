<?php

namespace App\Domain\Person;

interface PersonRepositoryInterface
{
    public function save(string $id, array $data): PersonEntity;
    public function delete(string $id): bool;
}