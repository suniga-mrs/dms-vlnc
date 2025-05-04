<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('small_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('description', 255)->nullable();
            $table->unsignedBigInteger('life_stage_id')->nullable();
            $table->unsignedTinyInteger('schedule_day_of_week')->nullable();
            $table->time('schedule_time_of_day')->nullable();
            $table->unsignedTinyInteger('schedule_frequency')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ← adds `deleted_at` column
            
            // Foreign key constraint (optional but recommended)
            $table->foreign('life_stage_id')->references('id')->on('life_stage')->onDelete('set null');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('small_group');
    }
};
