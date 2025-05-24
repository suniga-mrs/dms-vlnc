<?php

namespace App\Domain\Events;

use Illuminate\Support\Str;
use App\Domain\Shared\DomainEventBase;
use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\Enums\ScheduleFrequencyEnum;

class SmallGroupCreatedEvent extends DomainEventBase
{
    readonly public ?string $id;
    readonly public string $description;
    readonly public ?int $lifeStageId;
    readonly public ?string $leaderPersonId;
    readonly public int $scheduleDayOfWeek;
    readonly public string $scheduleTimeOfDay;
    readonly public ScheduleFrequencyEnum $scheduleFrequency;

    public function __construct(
        string $description,
        ?int $lifeStageId,
        string $leaderPersonId,
        int $scheduleDayOfWeek,
        string $scheduleTimeOfDay,
        ScheduleFrequencyEnum $scheduleFrequency,
        ?string $createdById = null
    ) {
        $entityId = Str::uuid();
        parent::__construct($entityId, class_basename(SmallGroupEntity::class), $createdById);
        $this->id = $entityId;
        $this->description = $description;
        $this->lifeStageId = $lifeStageId;
        $this->leaderPersonId = $leaderPersonId;
        $this->scheduleDayOfWeek = $scheduleDayOfWeek;
        $this->scheduleTimeOfDay = $scheduleTimeOfDay;
        $this->scheduleFrequency = $scheduleFrequency;
    }

    public static function fromPayload(array $dataArray): static
    {
        return new static(
            $dataArray["id"] ?? null,
            $dataArray["description"],
            $dataArray["lifeStageId"] ?? null,
            $dataArray["leaderPersonId"],
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
            'leaderPersonId'        => $this->leaderPersonId,
            'lifeStageId'           => $this->lifeStageId,
            'scheduledDayOfWeek'    => $this->scheduleDayOfWeek,
            'scheduleTimeOfDay'     => $this->scheduleTimeOfDay,
            'scheduleFrequency'     => $this->scheduleFrequency,
        ], fn ($value) => $value !== null);
    }
}
