<?php

namespace App\Domain\SmallGroup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Enums\DayOfWeekEnum;
use App\Domain\Enums\SmallGroupMemberStatus;
use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\Person\PersonEntity;

class SmallGroupMemberEntity extends Model
{
    protected $table = 'small_group_members';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $keyType = 'string';

    protected $fillable = [
        'small_group_id',
        'person_id',
        'intern',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'small_group_id' => 'string',
        'person_id' => 'string',
        'intern' => 'bool',
        'status' => SmallGroupMemberStatus::class,
    ];

    public function smallGroup()
    {
        return $this->belongsTo(SmallGroupEntity::class);
    }

    public function person()
    {
        return $this->belongsTo(PersonEntity::class);
    }
}