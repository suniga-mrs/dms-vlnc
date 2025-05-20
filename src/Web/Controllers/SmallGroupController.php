<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\Events\SmallGroupUpdatedEvent;
use App\Domain\Events\SmallGroupSaveAbstract;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;

class SmallGroupController extends Controller
{
    public function save(Request $request, SmallGroupRepositoryInterface $repo)
    {
        $validated = $request->validate([
            'id'                    => 'nullable|uuid',
            'description'           => 'required|string|max:255',
            'lifeStageId'           => 'nullable|integer',
            'scheduledDayOfWeek'    => 'required|integer|min:0|max:6',
            'scheduleTimeOfDay'     => 'required|date_format:H:i:s',
            'scheduleFrequency'     => 'required|integer',
        ]);
        $groupId = $validated['id'] ?? null;
        $event = $this->buildSaveEvent($validated, $groupId);

        // Dispatch the event - the handler will persist event
        // TODO - create class that consolidates and dispatches these events
        //        to centralize persistence and do it one time
        Event::dispatch($event);

        $group = $repo->get($event->getEntityId());
        $status = $groupId ? 200 : 201;
        return response()->json($group, $status);        
    }

    private function buildSaveEvent(array $data, ?string $id): SmallGroupSaveAbstract
    {
        return $id
            ? new SmallGroupUpdatedEvent(
                id:                $id,
                description:       $data['description'],
                lifeStageId:       $data['lifeStageId'] ?? null,
                scheduleDayOfWeek: (int) $data['scheduledDayOfWeek'],
                scheduleTimeOfDay: $data['scheduleTimeOfDay'],
                scheduleFrequency: $data['scheduleFrequency'],
                createdById:       null
            )
            : new SmallGroupCreatedEvent(
                description:       $data['description'],
                lifeStageId:       $data['lifeStageId'] ?? null,
                scheduleDayOfWeek: (int) $data['scheduledDayOfWeek'],
                scheduleTimeOfDay: $data['scheduleTimeOfDay'],
                scheduleFrequency: $data['scheduleFrequency'],
                createdById:       null
            );
    }
    
}