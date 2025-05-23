<?php

namespace App\Domain\Person;

use App\Domain\Enums\GenderEnum;
use App\Domain\Shared\BaseDataModel;

class PersonDataModel extends BaseDataModel
{
     public function __construct(
        public ?string $id,
        public string $firstName,
        public string $lastName,
        public int $lifeStageId,
        public GenderEnum $gender,
        public \DateTimeImmutable $birthdate,
    ) {
        $this->genderLabel = $gender->value;
    }
    
    readonly public string $genderLabel;

    public static function fromEntity(PersonEntity $entity): self
    {
        $self = new self(
            $entity->id,
            $entity->first_name,
            $entity->last_name,
            $entity->life_stage_id,
            $entity->gender,
            $entity->birthdate
        );

        $self->createdAt = $entity->created_at;
        $self->updatedAt = $entity->updated_at;
        
        return $self;
    }
}