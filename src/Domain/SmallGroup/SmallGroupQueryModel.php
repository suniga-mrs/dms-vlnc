<?php

namespace App\Domain\SmallGroup;

class SmallGroupQueryModel
{
    public function __construct(
        public array $lifeStageIds,
        public ?string $leaderPersonId,
        public array $scheduleDays, // list of DaysOfWeekEnum
    ) {
    }
}
    