<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domain_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('entity_id');
            $table->string('entity_type');
            $table->string('event_type');
            $table->uuid('created_by_id')->nullable();
            $table->timestamp('timestamp');
            $table->json('event_json');
            $table->unsignedBigInteger('sequence_number');
            $table->index(['entity_id', 'entity_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domain_events');
    }
};
