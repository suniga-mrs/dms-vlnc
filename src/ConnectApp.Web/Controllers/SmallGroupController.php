<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\Enums\DayOfWeekEnum;
use App\Domain\ScheduleFrequencyEnum;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;

class SmallGroupController extends Controller
{
    public function save(Request $request, SmallGroupRepositoryInterface $repo)
    {
        $validated = $request->validate([
            'id'                    => 'nullable|uuid',
            'description'           => 'required|string|max:255',
            'life_stage_id'         => 'nullable|integer|exists:life_stages,id',
            'schedule_day_of_week'  => 'required|integer|min:0|max:6',
            'schedule_time_of_day'  => 'required|date_format:H:i:s',
            'schedule_frequency'    => 'required|in:Weekly,Fortnightly,Monthly',
        ]);
        $groupId = $validated['id'] ?? null;
        $group = $repo->save($groupId, [
            'description'           => $validated['description'],
            'life_stage_id'         => $validated['life_stage_id'] ?? null,
            'schedule_day_of_week'  => DayOfWeekEnum::from($validated['schedule_day_of_week']),
            'schedule_time_of_day'  => $validated['schedule_time_of_day'],
            'schedule_frequency'    => ScheduleFrequencyEnum::from($validated['schedule_frequency']),
        ]);
        $status = $groupId ? 200 : 201;
        return response()->json($group, $status);
    }
}