<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use App\Web\Controllers\Controller;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Enums\GenderEnum;

class PersonController extends Controller
{
    public function save(Request $request, PersonRepositoryInterface $repo)
    {  
        $validated = $request->validate([
            'id' => 'nullable|uuid',
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'gender'     => 'required|in:MALE,FEMALE,NOT SPECIFIED',
            'birthdate'  => 'required|date',
        ]);
        $personId = $validated["id"];
        $person = $repo->save($personId, [
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'gender'     => GenderEnum::from($validated['gender']),
            'birthdate'  => $validated['birthdate'],
        ]);
        $status = $personId ? 200 : 201;
        return response()->json($person, $status);
    }
}
