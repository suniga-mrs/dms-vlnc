<?php

namespace App\Domain\Person;

interface SmallGroupRepositoryInterface
{
    public function save(string $id, array $data): SmallGroupEntity;
    public function delete(string $id): bool;
}