<?php

namespace App\Domain\References;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LifeStageEntity extends Model
{
    protected $table = 'life_stages';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'name',
        'description',
    ];
}