<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use App\Web\Controllers\Controller;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Helpers\PersonHelper;

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
}
