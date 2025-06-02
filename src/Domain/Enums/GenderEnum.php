<?php 

namespace App\Domain\Enums;

enum GenderEnum: string
{
    case Male = 'Male';
    case Female = 'Female';
    case Unspecified = 'Unspecified';

    public static function fromString(string $label): ?self
    {
        $normalized = strtolower($label);
        foreach (self::cases() as $case) {
            if (strtolower($case->name) === $normalized) {
                return $case;
            }
        }
        return null; 
    }
}
