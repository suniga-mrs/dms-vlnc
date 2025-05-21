<?php

namespace App\Domain\Events;

use App\Domain\Enums\ScheduleFrequencyEnum;

class SmallGroupUpdatedEvent extends SmallGroupSaveAbstract
{

    public function __construct(
        string                      $id,
        string                      $description,
        ?int                        $lifeStageId,
        int                         $scheduleDayOfWeek,
        string                      $scheduleTimeOfDay,
        ScheduleFrequencyEnum       $scheduleFrequency,
        ?string     $createdById = null
    ) {
        parent::__construct(
            $id, 
            $description, 
            $lifeStageId, 
            $scheduleDayOfWeek, 
            $scheduleTimeOfDay, 
            $scheduleFrequency, 
            $createdById);
    }
}

