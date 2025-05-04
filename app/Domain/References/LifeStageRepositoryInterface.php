<?php

namespace App\Domain\References;

interface LifeStageRepositoryInterface
{
    public function save(string $id, array $data): LifeStageEntity;
    public function delete(string $id): bool;
}