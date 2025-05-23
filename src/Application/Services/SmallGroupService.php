<?php

namespace App\Application\Services;

use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonEntity;

class SmallGroupService
{

    public function __construct(
        private PersonRepositoryInterface $personRepository,
    ) {        
    }

    public function createSmallGroupMemberAndPerson(
        string $smallGroupId,
        PersonDataModel $data) : PersonEntity
    {
        // CONTINUE HERE
         $person = $this->personRepository->save($data->id, $data);
         return $person;
    }

  
}