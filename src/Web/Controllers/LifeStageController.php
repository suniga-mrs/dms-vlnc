<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use App\Web\Controllers\Controller;
use App\Domain\References\LifeStageRepositoryInterface;

class LifeStageController extends Controller
{
    public function save(Request $request, LifeStageRepositoryInterface $repo)
    {  
        $validated = $request->validate([
            'id'          => 'nullable|integer',
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);
        $lifeStageId    = $validated['id'] ?? null;
        $lifeStage      = $repo->save($lifeStageId, [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);
        $status = $lifeStageId ? 200 : 201;
        return response()->json($lifeStage, $status);
    }

    public function all(LifeStageRepositoryInterface $repo)
    { 
        $lifeStages     = $repo->all();
        $status         = 200;
        return response()->json($lifeStages, $status);
    }
}
