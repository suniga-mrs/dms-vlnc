<?php 

namespace App\Domain\Enums;

enum ScheduleFrequencyEnum: int
{
    case Weekly = 1;
    case Fortnightly = 2;
    case Monthly = 3;

    public function label(): string
    {
        return match($this) {
            self::Weekly => 'Weekly',
            self::Fortnightly => 'Fortnightly',
            self::Monthly => 'Monthly',
        };
    }
}