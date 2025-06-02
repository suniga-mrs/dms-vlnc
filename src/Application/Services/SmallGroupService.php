<?php

namespace App\Application\Services;

use Illuminate\Support\Str;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonEntity;
use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\SmallGroup\SmallGroupMemberEntity;
use App\Domain\SmallGroup\SmallGroupMemberRepositoryInterface;

class SmallGroupService implements SmallGroupServiceInterface
{
    public function __construct(
        private PersonRepositoryInterface $personRepository,
        private SmallGroupMemberRepositoryInterface $smallGroupMemberRepository
    ) {        
    }

    public function createSmallGroupMemberAndPerson(
        string $smallGroupId,
        PersonDataModel $data) : SmallGroupMemberEntity
    {
        SmallGroupEntity::findOrFail($smallGroupId);        
        $personEntity = $this->personRepository->save($data->id, $data);
        $entityId = Str::uuid();
        $smallGroupMember = $this->smallGroupMemberRepository->createNewMember(
             $entityId,
             $smallGroupId,
             $personEntity->id,
        );
        return $smallGroupMember;
    }  

    public function createSmallGroupMember(
        string $smallGroupId,
        string $personId) : SmallGroupMemberEntity
    {
        SmallGroupEntity::findOrFail($smallGroupId);    
        PersonEntity::findOrFail($personId);
        $entityId = Str::uuid();
        $smallGroupMember = $this->smallGroupMemberRepository->createNewMember(
             $entityId,
             $smallGroupId,
             $personId,
        );
        return $smallGroupMember;
    }  
}