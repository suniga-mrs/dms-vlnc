<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\Rule;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\Events\SmallGroupUpdatedEvent;
use App\Domain\Events\SmallGroupSaveAbstract;
use App\Domain\SmallGroup\SmallGroupDataModel;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Web\Helpers\DateTimeHelpers;

class SmallGroupController extends Controller
{
    public function save(Request $request, SmallGroupRepositoryInterface $repo)
    {
        $request->merge([
            'scheduleTimeOfDay' =>  DateTimeHelpers::normalizeToTimeOfDay($request->input('scheduleTimeOfDay')),
            'scheduleFrequency' =>  strtolower($request->input('scheduleFrequency'))
        ]);

        $validated = $request->validate([
            'id'                    => 'nullable|uuid',
            'description'           => 'required|string|max:255',
            'lifeStageId'           => 'nullable|integer',
            'scheduledDayOfWeek'    => 'required|integer|min:1|max:7',
            'scheduleTimeOfDay'     => 'required|date_format:H:i:s',
            'scheduleFrequency'     => 'required|in:weekly,fortnightly,monthly',
        ]);
        $groupId = $validated['id'] ?? null;
        $event = $this->buildSaveEvent($validated, $groupId);

        // Dispatch the event - the handler will persist event
        // TODO - create class that consolidates and dispatches these events
        //        to centralize persistence and do it one time
        Event::dispatch($event);

        $group = $repo->get($event->getEntityId());
        $dataModel = SmallGroupDataModel::fromEntity($group);
        $status = $groupId ? 200 : 201;
        return response()->json($dataModel, $status);        
    }

    private function buildSaveEvent(array $data, ?string $id): SmallGroupSaveAbstract
    {
        $scheduleFrequency = ScheduleFrequencyEnum::fromLabel($data['scheduleFrequency']);

        return $id
            ? new SmallGroupUpdatedEvent(
                id:                $id,
                description:       $data['description'],
                lifeStageId:       $data['lifeStageId'] ?? null,
                scheduleDayOfWeek: (int) $data['scheduledDayOfWeek'],
                scheduleTimeOfDay: $data['scheduleTimeOfDay'],
                scheduleFrequency: $scheduleFrequency,
                createdById:       null
            )
            : new SmallGroupCreatedEvent(
                description:       $data['description'],
                lifeStageId:       $data['lifeStageId'] ?? null,
                scheduleDayOfWeek: (int) $data['scheduledDayOfWeek'],
                scheduleTimeOfDay: $data['scheduleTimeOfDay'],
                scheduleFrequency: $scheduleFrequency,
                createdById:       null
            );
    }
    
}