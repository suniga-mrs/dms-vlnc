<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Enums\GenderEnum;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Enums\SmallGroupMemberStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
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

        Schema::create('life_stages', function (Blueprint $table) {
            $table->id(); // auto-incrementing integer primary key
            $table->string('name', 75);
            $table->string('description', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('persons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->enum('gender', array_column(GenderEnum::cases(), 'value'))->nullable();
            $table->unsignedBigInteger('life_stage_id')->nullable();
            $table->dateTime('birthdate')->nullable();
            $table->timestamps();

            // Foreign key constraint (optional but recommended)
            $table->foreign('life_stage_id')->references('id')->on('life_stages')->restrictOnDelete();
        });

        Schema::create('small_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('description', 255)->nullable();
            $table->uuid('leader_person_id');
            $table->unsignedBigInteger('life_stage_id')->nullable();
            $table->unsignedTinyInteger('schedule_day_of_week')->nullable();
            $table->time('schedule_time_of_day')->nullable();
            $table->string('schedule_frequency')->nullable()
                ->checkIn(array_map(fn($case) => "'{$case->value}'", ScheduleFrequencyEnum::cases()));
            $table->timestamps();
            $table->softDeletes(); // ← adds `deleted_at` column

            // Foreign key constraint (optional but recommended)
            $table->foreign('life_stage_id')->references('id')->on('life_stages')->restrictOnDelete();
            $table->foreign('leader_person_id')->references('id')->on('persons')->restrictOnDelete();
        });

        Schema::create('small_group_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('small_group_id')->nullable();
            $table->uuid('person_id');
            $table->boolean('intern');
            $table->string('status')
                ->checkIn(array_map(fn($case) => "'{$case->value}'", SmallGroupMemberStatus::cases()));
            $table->timestamps();

            $table->foreign('small_group_id')->references('id')->on('small_groups')->nullOnDelete();
            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('small_group_members');
        Schema::dropIfExists('small_groups');
        Schema::dropIfExists('persons');
        Schema::dropIfExists('life_stages');
        Schema::dropIfExists('domain_events');
    }
};
