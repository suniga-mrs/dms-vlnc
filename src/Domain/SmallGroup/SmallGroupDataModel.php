<?php

namespace App\Domain\SmallGroup;

use App\Domain\Enums\DayOfWeekEnum;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Events\SmallGroupCreatedEvent;
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
    ) {}

    public static function fromCreatedEvent(SmallGroupCreatedEvent $event): self
    {
        return new self(
            $event->getEntityId(),
            $event->description,
            $event->lifeStageId,
            DayOfWeekEnum::from($event->scheduleDayOfWeek),
            new DateTimeImmutable($event->scheduleTimeOfDay),
            ScheduleFrequencyEnum::from($event->scheduleFrequency)
        );
    }
}