<?php 

namespace App\Domain\Enums;

enum ScheduleFrequencyEnum: string
{
    case Weekly = 'weekly';
    case Fortnightly = 'fortnightly';
    case Monthly = 'monthly';

    public function label(): string
    {
        return match($this) {
            self::Weekly => 'Weekly',
            self::Fortnightly => 'Fortnightly',
            self::Monthly => 'Monthly',
        };
    }

    public static function fromLabel(string $label): ?self
    {
        $normalized = strtolower($label);
        foreach (self::cases() as $case) {
            if (strtolower($case->label()) === $normalized) {
                return $case;
            }
        }
        return null; 
    }
}