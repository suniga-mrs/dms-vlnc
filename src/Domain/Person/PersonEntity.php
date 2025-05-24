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
        'life_stage_id',
        'gender',
        'birthdate',
    ];

    protected $casts = [
        'life_stage_id'     => 'integer',
        'gender'            =>  GenderEnum::class,
        'birthdate'         => 'datetime',
    ];    

    public static function createFromData(PersonDataModel $data): self
    {
        return new self([
            'id'                    => $data->id,
            'first_name'            => $data->firstName,
            'last_name'             => $data->lastName,
            'life_stage_id'         => $data->lifeStageId,
            'gender'                => $data->gender,
            'birthdate'             => $data->birthdate,
        ]);
    }

     public static function updateFromData(PersonDataModel $data): self
    {
        return new self([
            'first_name'            => $data->firstName,
            'last_name'             => $data->lastName,
            'life_stage_id'         => $data->lifeStageId,
            'gender'                => $data->gender,
            'birthdate'             => $data->birthdate,
        ]);
    }
}