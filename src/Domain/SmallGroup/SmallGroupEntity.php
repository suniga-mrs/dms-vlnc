<?php

namespace App\Domain\SmallGroup;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Enums\DayOfWeekEnum;
use App\Domain\SmallGroup\SmallGroupDataModel;

class SmallGroupEntity extends Model
{
    protected $table        = 'small_groups';
    protected $primaryKey   = 'id';
    public $incrementing    = false;
    public $timestamps = true;
    protected $keyType      = 'string';

    protected $fillable = [
        'id',
        'description',
        'life_stage_id',
        'schedule_day_of_week',
        'schedule_time_of_day',
        'schedule_frequency',
    ];

    protected $casts = [
        'id'                    => 'string',
        'life_stage_id'         => 'integer',
        'schedule_day_of_week'  => DayOfWeekEnum::class,
        'schedule_time_of_day'  => 'datetime:H:i:s',
        'schedule_frequency'    => ScheduleFrequencyEnum::class,
    ];

    public static function createFromData(SmallGroupDataModel $data): self
    {
        return new self([
            'id'                    => $data->id,
            'description'           => $data->description,
            'life_stage_id'         => $data->lifeStageId,
            'schedule_day_of_week'  => $data->scheduleDayOfWeek,
            'schedule_time_of_day'  => $data->scheduleTimeOfDay,
            'schedule_frequency'    => $data->scheduleFrequency,
        ]);
    }

    public function updateFromData(SmallGroupDataModel $data): self
    {
        $this->description          = $data->description;
        $this->life_stage_id        = $data->lifeStageId;
        $this->schedule_day_of_week = $data->scheduleDayOfWeek;
        $this->schedule_time_of_day = $data->scheduleTimeOfDay;
        $this->schedule_frequency   = $data->scheduleFrequency;
        return $this;
    }
}