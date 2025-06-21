<?php

namespace App\Domain\SearchIndex;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Enums\GenderEnum;

class PersonEntity extends Model
{
    protected $table = 'person_search_index';
    protected $primaryKey = 'person_id';
    public $incrementing = false;
    public $timestamps = true;
    protected $keyType = 'string';

    protected $fillable = [
        'person_id',
        'small_group_member_id',
        'small_group_id',
        'full_name_normalized',
        'full_name_soundex',
    ];

    // If you need to define a relationship back to Person:
    public function person()
    {
        return $this->belongsTo(PersonEntity::class, 'person_id');
    }
}