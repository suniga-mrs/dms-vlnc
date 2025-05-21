<?php

namespace App\Domain\SmallGroup;

use App\Domain\Enums\DayOfWeekEnum;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Events\SmallGroupSaveAbstract;
use App\Domain\SmallGroup\SmallGroupEntity;
use \DateTimeImmutable;
use \DateTimeInterface;

class SmallGroupDataModel
{
    public function __construct(
        public string $id,
        public string $description,
        public int $lifeStageId,
        public DayOfWeekEnum $scheduleDayOfWeek,
        public DateTimeInterface $scheduleTimeOfDay,
        public ScheduleFrequencyEnum $scheduleFrequency
    ) {
        $this->scheduleFrequencyLabel = $scheduleFrequency->label();
        $this->scheduleDayOfWeekLabel = $scheduleDayOfWeek->label();
    }
    
    readonly public string $scheduleFrequencyLabel;
    readonly public string $scheduleDayOfWeekLabel;
    readonly public ?string $createdById;
    readonly public ?string $createdBy;
    readonly public ?string $createdAt;
    readonly public ?string $updatedAt;

    public static function fromSaveEvent(SmallGroupSaveAbstract $event): self
    {
        return new self(
            $event->getEntityId(),
            $event->description,
            $event->lifeStageId,
            DayOfWeekEnum::from($event->scheduleDayOfWeek),
            new DateTimeImmutable($event->scheduleTimeOfDay),
            $event->scheduleFrequency
        );
    }

    public static function fromEntity(SmallGroupEntity $entity): self
    {
        $self = new self(
            $entity->id,
            $entity->description,
            $entity->life_stage_id,
            $entity->schedule_day_of_week,
            $entity->schedule_time_of_day,
            $entity->schedule_frequency
        );

        $self->createdAt = $entity->created_at;
        $self->updatedAt = $entity->updated_at;
        
        return $self;
    }
}