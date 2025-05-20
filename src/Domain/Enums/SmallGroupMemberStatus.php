<?php 

namespace App\Domain\Enums;

enum SmallGroupMemberStatus: string
{
    case New = "New";
    case Active = "Active";
    case Inactive = "Inactive";
}