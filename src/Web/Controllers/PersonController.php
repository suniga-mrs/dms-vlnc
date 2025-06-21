<?php

namespace App\Web\Controllers;

use App\Domain\Enums\EntityEnum;
use App\Domain\Enums\GenderEnum;
use Illuminate\Http\Request;
use App\Web\Controllers\Controller;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Helpers\PersonHelper;
use App\Domain\Person\PersonQueryModel;

class PersonController extends Controller
{
    public function save(Request $request, PersonRepositoryInterface $repo)
    {
        $data = PersonHelper::validateData($request->all());
        $personId = $data->id;
        $personEntity = $repo->save($personId, $data);
        $status = $personId ? 200 : 201;
        return response()->json(PersonDataModel::fromEntity($personEntity), $status);
    }

    public function getList(Request $request, PersonRepositoryInterface $repo)
    {
        $validated = $request->validate([
            'firstName'     => 'nullable|string|max:255',
            'lastName'      => 'nullable|string|max:255',
            'gender'        => 'nullable|string|in:Male,Female,Unspecified',
            'lifeStageId'   => 'nullable|integer',
            'page'          => 'sometimes|integer|min:1',
            'perPage'       => 'sometimes|integer|min:1|max:100',
        ]);
        $queryModel = new PersonQueryModel(
            firstName: $validated['firstName'] ?? '',
            lastName: $validated['lastName'] ?? '',
            gender: !empty($validated['gender']) ? GenderEnum::from($validated['gender']) : null,
            lifeStageId: $validated['lifeStageId'] ?? null
        );
        $page = $validated['page'] ?? 1;
        $perPage = $validated['perPage'] ?? 15;
        $results = $repo->getList($queryModel, $page, $perPage);
        return response()->json($results);
    }
}
