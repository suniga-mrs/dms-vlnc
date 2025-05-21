<?php

namespace App\Domain\Events;

use Illuminate\Support\Str;
use App\Domain\Enums\ScheduleFrequencyEnum;

class SmallGroupCreatedEvent extends SmallGroupSaveAbstract
{
    public function __construct(
        string                      $description,
        ?int                        $lifeStageId,
        int                         $scheduleDayOfWeek,
        string                      $scheduleTimeOfDay,
        ScheduleFrequencyEnum       $scheduleFrequency,
        ?string     $createdById = null
    ) {
        parent::__construct(
            (string) Str::uuid(), 
            $description, 
            $lifeStageId, 
            $scheduleDayOfWeek, 
            $scheduleTimeOfDay, 
            $scheduleFrequency, 
            $createdById);
    }
}

