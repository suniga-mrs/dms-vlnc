<?php

namespace App\Domain\SmallGroup;

use App\Domain\SmallGroup\SmallGroupDataModel;
use App\Domain\SmallGroup\SmallGroupQueryModel;
use App\Domain\SmallGroup\SmallGroupEntity;
use Illuminate\Support\Collection;

interface SmallGroupRepositoryInterface
{
    public function get(string $id): SmallGroupEntity;
    public function create(SmallGroupDataModel $data): SmallGroupEntity;
    public function update(?string $id, SmallGroupDataModel $data): SmallGroupEntity;
    public function delete(string $id): bool;
    public function getList(SmallGroupQueryModel $queryModel, int $page, int $perPage): Collection;
}