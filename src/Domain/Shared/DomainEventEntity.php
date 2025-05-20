<?php

namespace App\Domain\Shared;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DomainEventEntity extends Model
{
    use HasUuids;

    protected $table = 'domain_events';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'entity_id',
        'entity_type',
        'event_type',
        'created_by_id',
        'timestamp',
        'event_json',
        'sequence_number'
    ];

    protected $casts = [
        'id' => 'string',
        'entity_type' => 'string',
        'entity_id' => 'string',
        'event_type' => 'string',
        'created_by_id' => 'string',
        'timestamp' => 'datetime',
        'event_json' => 'string',
        'sequence_number' => 'integer'
    ];
}