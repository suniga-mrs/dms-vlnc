<?php

namespace App\Domain\SmallGroup;

use App\Domain\Enums\DayOfWeekEnum;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Enums\SmallGroupCategory;
use App\Domain\Events\SmallGroupCreatedEvent;
use App\Domain\Events\SmallGroupUpdatedEvent;
use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\Shared\BaseDataModel;
use App\Domain\Helpers\DateTimeHelpers;
use \DateTimeImmutable;
use \DateTimeInterface;
/**
 * Data transfer object for various small group operations.
 * Nullability of values here does not reflect the SmallGroupEntity properties' nullability
 */
class SmallGroupDataModel extends BaseDataModel
{
    public function __construct(
        public string $id,
        public string $description,
        public ?int $lifeStageId,
        public ?string $leaderPersonId,
        public DayOfWeekEnum $scheduleDayOfWeek,
        public DateTimeInterface $scheduleTimeOfDay,
        public ScheduleFrequencyEnum $scheduleFrequency,
        public SmallGroupCategory $category,
    ) {
        $this->scheduleFrequencyLabel   = $scheduleFrequency->label();
        $this->scheduleDayOfWeekLabel   = $scheduleDayOfWeek->label();
        $this->categoryName             = $category->label();
    }
    
    readonly public string $scheduleFrequencyLabel;
    readonly public string $scheduleDayOfWeekLabel;
    readonly public string $categoryName;
    public string $lifeStageName;
    public string $leaderPersonName;

    public static function fromCreateEvent(SmallGroupCreatedEvent $event): self
    {
        return new self(
            $event->getEntityId(),
            $event->description,
            $event->lifeStageId,
            $event->leaderPersonId,
            DayOfWeekEnum::from($event->scheduleDayOfWeek),
            new DateTimeImmutable($event->scheduleTimeOfDay),
            $event->scheduleFrequency
        );
    }

    public static function fromUpdateEvent(SmallGroupUpdatedEvent $event): self
    {
        return new self(
            $event->getEntityId(),
            $event->description,
            $event->lifeStageId ?? null,
            $event->leaderPersonId ?? null,
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
            $entity->leader_person_id,
            $entity->schedule_day_of_week,
            $entity->schedule_time_of_day,
            $entity->schedule_frequency,
            $entity->category,
        );
        $self->setBaseProperties(
            DateTimeHelpers::toDateImmutable($entity->created_at),
            DateTimeHelpers::toDateImmutable($entity->updated_at),
            null,
            null,
        );        
        return $self;
    }
}