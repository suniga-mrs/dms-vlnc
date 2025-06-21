<?php

namespace App\Domain\Person;

use App\Domain\Enums\GenderEnum;

class PersonQueryModel
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public ?GenderEnum $gender,
        public ?int $lifeStageId
    ) {
    }
}