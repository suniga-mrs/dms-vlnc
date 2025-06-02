<?php

namespace App\Application\Services;

use App\Domain\Person\PersonDataModel;
use App\Domain\SmallGroup\SmallGroupMemberEntity;

interface SmallGroupServiceInterface
{
    public function createSmallGroupMemberAndPerson(
        string $smallGroupId,
        PersonDataModel $data) : SmallGroupMemberEntity;
    
    public function createSmallGroupMember(
        string $smallGroupId,
        string $personId) : SmallGroupMemberEntity;
}