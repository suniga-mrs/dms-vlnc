<?php

namespace App\Web\Controllers;

use App\Application\Services\SmallGroupServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\Events\SmallGroupUpdatedEvent;
use App\Domain\SmallGroup\SmallGroupDataModel;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Domain\Helpers\DateTimeHelpers;
use App\Domain\Helpers\PersonHelper;
use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\SmallGroup\SmallGroupMemberEntity;
use App\Domain\SmallGroup\SmallGroupMemberRepositoryInterface;

class SmallGroupController extends Controller
{
    public function create(
        Request $request,
        SmallGroupRepositoryInterface $repo,
        PersonRepositoryInterface $personRepository)
    {
        $request->merge([
            'scheduleTimeOfDay' =>  DateTimeHelpers::normalizeToTimeOfDay($request->input('scheduleTimeOfDay')),
            'scheduleFrequency' =>  strtolower($request->input('scheduleFrequency'))
        ]);
        $validated = $request->validate([
            'description'           => 'nullable|string|max:255',
            'lifeStageId'           => 'required|integer',
            'leaderPersonId'        => 'required|string',
            'scheduledDayOfWeek'    => 'required|integer|min:1|max:7',
            'scheduleTimeOfDay'     => 'required|date_format:H:i:s',
            'scheduleFrequency'     => 'required|in:weekly,fortnightly,monthly',
        ]);
        
        $leaderPersonId = $validated['leaderPersonId'];
        $isLeaderExists = $personRepository->isExists($leaderPersonId);
        if (!$isLeaderExists) {
            throw (new ModelNotFoundException)->setModel(PersonEntity::class, $leaderPersonId);
        }
        
        $scheduleFrequency = ScheduleFrequencyEnum::fromLabel($validated['scheduleFrequency']);
        $event = new SmallGroupCreatedEvent(
                description:       $validated['description'],
                lifeStageId:       $validated['lifeStageId'],
                leaderPersonId:    $leaderPersonId,
                scheduleDayOfWeek: (int) $validated['scheduledDayOfWeek'],
                scheduleTimeOfDay: $validated['scheduleTimeOfDay'],
                scheduleFrequency: $scheduleFrequency,
                createdById:       null);

        // Dispatch the event - the handler will persist event
        // TODO: create class that consolidates and dispatches these events
        //        to centralize persistence and do it one time
        Event::dispatch($event);

        $group = $repo->get($event->getEntityId());
        $dataModel = SmallGroupDataModel::fromEntity($group);
        $status = 201;
        return response()->json($dataModel, $status);        
    }

    public function update(Request $request, SmallGroupRepositoryInterface $repo)
    {
        $request->merge([
            'scheduleTimeOfDay' =>  DateTimeHelpers::normalizeToTimeOfDay($request->input('scheduleTimeOfDay')),
            'scheduleFrequency' =>  strtolower($request->input('scheduleFrequency'))
        ]);
        $validated = $request->validate([
            'id'                    => 'required|uuid',
            'description'           => 'nullable|string|max:255',
            'scheduledDayOfWeek'    => 'required|integer|min:1|max:7',
            'scheduleTimeOfDay'     => 'required|date_format:H:i:s',
            'scheduleFrequency'     => 'required|in:weekly,fortnightly,monthly',
        ]);
        $scheduleFrequency = ScheduleFrequencyEnum::fromLabel($validated['scheduleFrequency']);
        $event = new SmallGroupUpdatedEvent(
                id:                $validated['id'],
                description:       $validated['description'],
                scheduleDayOfWeek: (int) $validated['scheduledDayOfWeek'],
                scheduleTimeOfDay: $validated['scheduleTimeOfDay'],
                scheduleFrequency: $scheduleFrequency,
                updatedById:       null
            );

        // Dispatch the event - the handler will persist event
        // TODO: create class that consolidates and dispatches these events
        //        to centralize persistence and do it one time
        Event::dispatch($event);

        $group = $repo->get($event->getEntityId());
        $dataModel = SmallGroupDataModel::fromEntity($group);
        $status = 200;
        return response()->json($dataModel, $status);        
    }
    
    public function addMember(Request $request, SmallGroupServiceInterface $service)
    {
        $validated = $request->validate([
            'smallGroupId'      => 'required|uuid',
            'personId'          => 'nullable|string|max:255',
        ]);
        $smallGroupId = $validated['smallGroupId'];
        $personId = $validated['personId'] ?? null;
        // TODO: Create small group validation process
        // The leader or admin must be able to setup certain validations when adding a member?
        // Gender, life stage

        if ($personId != null)
        {
            // TODO: Create an event for Small Group
            // Simply create a new member record
            $member = $service->createSmallGroupMember($smallGroupId, $personId);
            return response()->json($member, 201);
        }
        else {
            // TODO: Create an event for Small Group
            // Create person and member
            $person = PersonHelper::validateData($request->input('person'));
            $member = $service->createSmallGroupMemberAndPerson($smallGroupId, $person);
            return response()->json($member, 201);
        }
    }

    public function updateInternStatus(Request $request, SmallGroupMemberRepositoryInterface $repository)
    {
        $validated = $request->validate([
            'smallGroupMemberId'      => 'required|uuid',
        ]);
        $smallGroupMemberId = $validated['smallGroupMemberId'] ?? null;
        $entity = $repository->updateInternStatus(($smallGroupMemberId));
        return response()->json($entity, 200);
    }
}