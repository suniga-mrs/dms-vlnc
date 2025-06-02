<?php

namespace App\Domain\SmallGroup;

use Illuminate\Database\Eloquent\Model;
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
        'id',
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

    public static function createNew(
        string $memberId,
        string $smallGroupId,
        string $personId): self
    {
        return new self([
            'id'                    => $memberId,
            'small_group_id'        => $smallGroupId,
            'person_id'             => $personId,
            'intern'                => false,
            'status'                => SmallGroupMemberStatus::New,
        ]);
    }
}