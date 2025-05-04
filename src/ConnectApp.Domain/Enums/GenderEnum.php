<?php 

namespace App\Domain\Enums;

enum GenderEnum: string
{
    case Male = 'Male';
    case Female = 'Female';
    case Unspecified = 'Unspecified';
}
