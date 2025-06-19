<?php

namespace App\Web\Controllers;

use App\Domain\Enums\EntityEnum;
use Illuminate\Http\Request;
use App\Web\Controllers\Controller;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Helpers\PersonHelper;
use App\Infrastructure\Services\QueryEntityServiceFactoryInterface;

class PersonController extends Controller
{
    public function __construct(
        private QueryEntityServiceFactoryInterface $queryFactory
    ) {}

    public function save(Request $request, PersonRepositoryInterface $repo)
    {
        $data = PersonHelper::validateData($request->all());
        $personId = $data->id;
        $personEntity = $repo->save($personId, $data);
        $status = $personId ? 200 : 201;
        return response()->json(PersonDataModel::fromEntity($personEntity), $status);
    }

    public function getList(Request $request)
    {
        $service = $this->queryFactory->make(EntityEnum::Person);

        $results = $service->getPaginatedResults(
            $request->only(['first_name']),
            $request->input('page', 1),
            $request->input('per_page', 15)
        );

        return response()->json($results);
    }
}
