<?php

namespace App\Domain\SmallGroup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Enums\DayOfWeekEnum;

class SmallGroupEntity extends Model
{
    use HasUuids;

    protected $table = 'small_groups';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'description',
        'life_stage_id',
        'schedule_day_of_week',
        'schedule_time_of_day',
        'schedule_frequency',
    ];

    protected $casts = [
        'id' => 'string',
        'life_stage_id' => 'integer',
        'created_ticks_since_epoch' => 'integer',
        'schedule_time_of_day' => 'datetime:H:i:s',
        'schedule_day_of_week' => DayOfWeekEnum::class,
        'schedule_frequency' => ScheduleFrequencyEnum::class,
    ];
}