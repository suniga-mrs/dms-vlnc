<?php 

namespace App\Domain\Enums;

enum GenderEnum: string
{
    case Male = 'male';
    case Female = 'female';
    case Unspecified = 'unspecified';

    public function label(): string
    {
        return match($this) {
            self::Male => 'Male',
            self::Female => 'Female',
            self::Unspecified => 'Unspecified',
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
