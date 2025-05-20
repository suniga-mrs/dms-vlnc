<?php

namespace App\Web\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\SmallGroup\SmallGroupDataModel;
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
            'scheduleFrequency'    => 'required|integer',
        ]);
        $groupId = $validated['id'] ?? null;
        if ($groupId == null)
        {
            // Create domain event
            $event = new SmallGroupCreatedEvent(
                description: $validated['description'],
                lifeStageId: $validated['lifeStageId'] ?? null,
                scheduleDayOfWeek: (int) $validated['scheduledDayOfWeek'],
                scheduleTimeOfDay: $validated['scheduleTimeOfDay'],
                scheduleFrequency: $validated['scheduleFrequency'],
                createdById: null,
            );
            $data = SmallGroupDataModel::fromCreatedEvent($event);
            $entity = $repo->save($groupId, $data);

            // Dispatch the event - the handler will persist event
            // TODO - create class that consolidates and dispatches these events
            //        to centralize persistence and do it one time
            Event::dispatch($event);

            $group = $repo->get($event->getEntityId());
            $status = $groupId ? 200 : 201;
            return response()->json($group, $status);
        }

        
        // TODO: Updated logic and event
        $group = $repo->get($groupId);
        return response()->json($group, 200);
        
    }
}