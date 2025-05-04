<?php

namespace App\Domain\Person;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Enums\GenderEnum;

class PersonEntity extends Model
{
    use HasFactory, HasUuids;

    // Specify custom table name if not plural of model
    protected $table = 'persons';

    // Use UUIDs
    protected $keyType = 'string';
    public $incrementing = false;

    // Allow mass-assignment on these fields
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birthdate',
    ];

    // Cast fields to appropriate data types
    protected $casts = [
        'gender' => GenderEnum::class,
        'birthdate' => 'datetime',
    ];
}