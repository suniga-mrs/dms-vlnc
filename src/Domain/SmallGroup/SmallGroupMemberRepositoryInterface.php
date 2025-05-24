<?php

namespace App\Domain\SmallGroup;

use App\Domain\SmallGroup\SmallGroupMemberEntity;
use App\Domain\Enums\SmallGroupMemberStatus;

interface SmallGroupMemberRepositoryInterface
{
    public function createNewMember(string $smallGroupId, string $personId): SmallGroupMemberEntity;
    public function updateInternStatus(?string $smallGroupMemberId): SmallGroupMemberEntity;
    public function updateMemberStatus(?string $smallGroupMemberId, SmallGroupMemberStatus $status): SmallGroupMemberEntity;
    public function updateSmallGroup(?string $smallGroupMemberId, string $smallGroupId): SmallGroupMemberEntity;
}