<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->enum('status', ['present', 'absent'])->default('absent');
            $table->timestamps();

            $table->unique(['subject_id', 'trainee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
