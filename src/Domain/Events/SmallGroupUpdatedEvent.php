<?php

namespace App\Domain\Events;

use App\Domain\Shared\DomainEventBase;
use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\Enums\ScheduleFrequencyEnum;

class SmallGroupUpdatedEvent extends DomainEventBase
{
    readonly public ?string $id;
    readonly public string $description;
    readonly public int $scheduleDayOfWeek;
    readonly public string $scheduleTimeOfDay;
    readonly public ScheduleFrequencyEnum $scheduleFrequency;

    public function __construct(
        string $id,
        string $description,
        int $scheduleDayOfWeek,
        string $scheduleTimeOfDay,
        ScheduleFrequencyEnum $scheduleFrequency,
        ?string $updatedById = null
    ) {
        parent::__construct($id, class_basename(SmallGroupEntity::class), $updatedById);
        $this->id = $id;
        $this->description = $description;
        $this->scheduleDayOfWeek = $scheduleDayOfWeek;
        $this->scheduleTimeOfDay = $scheduleTimeOfDay;
        $this->scheduleFrequency = $scheduleFrequency;
    }

    public static function fromPayload(array $dataArray): static
    {
        return new static(
            $dataArray["id"] ?? null,
            $dataArray["description"],
            $dataArray["scheduledDayOfWeek"],
            $dataArray["scheduleTimeOfDay"],
            $dataArray["scheduleFrequency"]
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'id'                    => $this->id,
            'description'           => $this->description,
            'scheduledDayOfWeek'    => $this->scheduleDayOfWeek,
            'scheduleTimeOfDay'     => $this->scheduleTimeOfDay,
            'scheduleFrequency'     => $this->scheduleFrequency,
        ], fn ($value) => $value !== null);
    }
}