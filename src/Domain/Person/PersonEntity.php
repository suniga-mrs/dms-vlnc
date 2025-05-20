<?php

namespace App\Domain\Person;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Enums\GenderEnum;

class PersonEntity extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'persons';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birthdate',
    ];

    protected $casts = [
        'gender' => GenderEnum::class,
        'birthdate' => 'datetime',
    ];
}