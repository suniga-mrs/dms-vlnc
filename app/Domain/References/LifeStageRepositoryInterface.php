<?php

namespace App\Domain\References;

interface LifeStageRepositoryInterface
{
    public function save(?int $id, array $data): LifeStageEntity;
    public function delete(int $id): bool;
}