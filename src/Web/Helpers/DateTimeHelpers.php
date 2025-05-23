<?php

namespace App\Web\Helpers;

use Carbon\Carbon;

class DateTimeHelpers {
    
    public static function normalizeToTimeOfDay(string $input): ?string
    {
        try {
            return Carbon::parse($input)->format('H:i:s');
        } catch (\Exception $e) {
            // TODO: create a proper exception error here
            return null;
        }
    }
}

