<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Enums\SmallGroupMemberStatus;

return new class extends Migration
{
    public function up(): void
    {
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

        Schema::table('small_groups', function (Blueprint $table) {
            $table->uuid('leader_person_id');
            $table->foreign('leader_person_id')->references('id')->on('persons')->restrictOnDelete();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('small_group_members');
        Schema::table('small_groups', function (Blueprint $table) {
            $table->dropForeign(['leader_person_id']);
            $table->dropColumn(['leader_person_id']);
        });
    }
};
