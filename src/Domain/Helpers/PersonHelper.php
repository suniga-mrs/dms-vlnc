<?php

namespace App\Domain\Helpers;

use Illuminate\Http\Request;
use App\Domain\Person\PersonDataModel;
use App\Domain\Enums\GenderEnum;
use App\Domain\Helpers\DateTimeHelper;

class PersonHelper 
{
    public static function validateData(array $data): PersonDataModel
    {
        $validator = validator($data, [
            'id'            => 'nullable|uuid',
            'firstName'     => 'required|string|max:100',
            'lastName'      => 'required|string|max:100',
            'gender'        => 'nullable|string',
            'birthdate'     => 'nullable|date',
            'lifeStageId'   => 'nullable|integer',
        ]);
        $validated = $validator->validate();
        $birthdate = $validated['birthdate'] != null
            ? DateTimeHelpers::toDateImmutable($validated['birthdate'])
            : null;
        $gender = !is_null($validated["gender"]) 
            ? GenderEnum::fromString($validated["gender"])
            : GenderEnum::Unspecified;
        $data = new PersonDataModel(
            $validated['id'] ?? null,
            $validated['firstName'],
            $validated['lastName'],
            $gender,
            $validated['lifeStageId'],
            $birthdate,
        );
        return $data;
    }
}