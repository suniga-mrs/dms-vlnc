<?php

namespace App\Domain\SmallGroup;

use App\Domain\SmallGroup\SmallGroupDataModel;
use App\Domain\SmallGroup\SmallGroupEntity;

interface SmallGroupRepositoryInterface
{
    public function get(string $id): SmallGroupEntity;
    public function save(?string $id, SmallGroupDataModel $data): SmallGroupEntity;
    public function delete(string $id): bool;
}