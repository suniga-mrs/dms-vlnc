<?php

namespace App\Domain\Events;

use App\Domain\Shared\DomainEventBase;
use App\Domain\SmallGroup\SmallGroupEntity;
use Illuminate\Support\Str;

class SmallGroupCreatedEvent extends DomainEventBase
{
    readonly public string    $description;
    readonly public ?int      $lifeStageId;
    readonly public int       $scheduleDayOfWeek;
    readonly public string    $scheduleTimeOfDay;
    readonly public string    $scheduleFrequency;

    public function __construct(
        string      $description,
        ?int        $lifeStageId,
        int         $scheduleDayOfWeek,
        string      $scheduleTimeOfDay,
        string      $scheduleFrequency,
        ?string     $createdById = null
    ) {
        $uuid = (string) Str::uuid();
        parent::__construct($uuid, class_basename(SmallGroupEntity::class), $createdById);
        $this->description          = $description;
        $this->lifeStageId          = $lifeStageId;
        $this->scheduleDayOfWeek    = $scheduleDayOfWeek;
        $this->scheduleTimeOfDay    = $scheduleTimeOfDay;
        $this->scheduleFrequency    = $scheduleFrequency;
    }

    public static function fromPayload(array $dataArray): SmallGroupCreatedEvent
    {
        return new self(
            $dataArray["description"],
            $dataArray["lifeStageId"],
            $dataArray["scheduledDayOfWeek"],
            $dataArray["scheduleTimeOfDay"],
            $dataArray["scheduleFrequency"]
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'lifeStageId' => $this->lifeStageId,
            'scheduledDayOfWeek' => $this->scheduleDayOfWeek,
            'scheduleTimeOfDay' => $this->scheduleTimeOfDay,
            'scheduleFrequency' => $this->scheduleFrequency,
        ];
    }
}

