<?php

namespace App\Domain\Person;

use App\Domain\Enums\GenderEnum;
use App\Domain\Shared\BaseDataModel;
use App\Web\Helpers\DateTimeHelpers;
use \DateTimeImmutable;

    
class PersonDataModel extends BaseDataModel implements \JsonSerializable
{
     public function __construct(
        public ?string $id,
        public string $firstName,
        public string $lastName,
        public GenderEnum $gender,
        public ?int $lifeStageId,
        public ?DateTimeImmutable $birthdate,
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
            $entity->gender,
            $entity->life_stage_id,
            DateTimeHelpers::toDateImmutable($entity->birthdate)
        );        
        $self->setBaseProperties(
            DateTimeHelpers::toDateImmutable($entity->created_at),
            DateTimeHelpers::toDateImmutable($entity->updated_at),
            $entity->createdById,
            $entity->createdByName,
        );        
        return $self;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'id'            => $this->id,
            'firstName'     => $this->firstName,
            'lastName'      => $this->lastName,
            'gender'        => $this->gender,
            'lifeStageId'   => $this->lifeStageId,
            'birthdate'     => $this->birthdate,
            'createdAt'     => $this->createdAt,
            'updatedAt'     => $this->updatedAt,
            'createdByName' => $this->createdByName
        ], fn ($value) => $value !== null);
    }
}