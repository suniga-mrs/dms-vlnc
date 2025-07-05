<?php

namespace App\Domain\SmallGroup;

use App\Domain\Enums\SmallGroupCateogry;

class SmallGroupQueryModel
{
    public function __construct(
        public array $lifeStageIds,
        public ?string $leaderPersonId,
        public array $scheduleDays, // list of DaysOfWeekEnum
        public SmallGroupCategory $category,
    ) {
    }
}
    