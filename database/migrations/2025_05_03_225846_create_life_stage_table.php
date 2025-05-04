<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('life_stages', function (Blueprint $table) {
            $table->id(); // auto-incrementing integer primary key
            $table->string('name', 75);
            $table->string('description', 150)->nullable();
            $table->timestamps();
            $table->softDeletes(); // ← adds `deleted_at` column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('life_stage');
    }
};
