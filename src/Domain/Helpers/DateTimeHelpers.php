<?php

namespace App\Domain\Helpers;

use Carbon\Carbon;
use \DateTimeImmutable;

class DateTimeHelpers {
    
    public static function normalizeToTimeOfDay(string $input): string
    {
        try {
            return Carbon::parse($input)->format('H:i:s');
        } catch (\Exception $e) {
            // TODO: create a proper exception error here
            // Research: exception stack trace in PHP
            throw $e;
        }
    }

    public static function toDateImmutable(?string $date): ?DateTimeImmutable
    {
        if (empty($date)) {
            return null;
        }

        try {
            return Carbon::parse($date)->toImmutable();
        } catch (\Exception $e) {
            // TODO: create a proper exception error here
            return null;
        }
    }

}

