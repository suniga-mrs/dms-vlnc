<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use App\Web\Controllers\Controller;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Enums\GenderEnum;
use App\Web\Helpers\DateTimeHelpers;

class PersonController extends Controller
{
    public function save(Request $request, PersonRepositoryInterface $repo)
    {
        $validated = $request->validate([
            'id'            => 'nullable|uuid',
            'firstName'     => 'required|string|max:100',
            'lastName'      => 'required|string|max:100',
            'gender'        => 'nullable|string',
            'birthdate'     => 'nullable|date',
            'lifeStageId'   => 'nullable|integer',
        ]);
        $personId = $validated["id"] ?? null;
        $gender = !is_null($validated["gender"]) 
            ? GenderEnum::fromString($validated["gender"])
            : GenderEnum::Unspecified;
        $data = new PersonDataModel(
            null,
            $validated['firstName'],
            $validated['lastName'],
            $gender,
            $validated['lifeStageId'],
            DateTimeHelpers::toDateImmutable($validated['birthdate']),
        );
        $personEntity = $repo->save($personId, $data);
        $status = $personId ? 200 : 201;
        return response()->json(PersonDataModel::fromEntity($personEntity), $status);
    }
}
