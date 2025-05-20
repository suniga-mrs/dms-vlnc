<?php

namespace App\Domain\Events;

class SmallGroupUpdatedEvent extends SmallGroupSaveAbstract
{

    public function __construct(
        string      $id,
        string      $description,
        ?int        $lifeStageId,
        int         $scheduleDayOfWeek,
        string      $scheduleTimeOfDay,
        string      $scheduleFrequency,
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

