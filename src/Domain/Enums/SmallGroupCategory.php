<?php 

namespace App\Domain\Enums;

enum SmallGroupCategory: int
{
    case SmallGroup = 1;
    case ClusterGroup = 2;

    public function label(): string
    {
        return match($this) {
            self::SmallGroup => 'Small Group',
            self::ClusterGroup => 'Cluster Group',
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
