<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Validation\ValidationException;
use App\Domain\SmallGroup\SmallGroupMemberEntity;
use App\Domain\SmallGroup\SmallGroupMemberRepositoryInterface;

class SmallGroupMemberRepository implements SmallGroupMemberRepositoryInterface
{
    public function get(string $id): SmallGroupMemberEntity
    {
        return SmallGroupMemberEntity::findOrFail($id);
    }

    public function createNewMember(
        string $id,
        string $smallGroupId,
        string $personId): SmallGroupMemberEntity
    {
        // Check if the member already exists
        $existingMember = SmallGroupMemberEntity::where('small_group_id', $smallGroupId)
            ->where('person_id', $personId)
            ->first();

        if ($existingMember) {
            throw ValidationException::withMessages([
                'member' => ['This person is already a member of the small group.']
            ]);
        }

        $entity = SmallGroupMemberEntity::createNew($id, $smallGroupId, $personId);
        $entity->save();
        return $entity;
    }
}