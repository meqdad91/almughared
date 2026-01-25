<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['admins', 'qas', 'trainers', 'trainees'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('gender')->nullable();
                $table->date('birthdate')->nullable();
                $table->string('avatar')->nullable();
                $table->string('phone')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['admins', 'qas', 'trainers', 'trainees'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['gender', 'birthdate', 'avatar', 'phone']);
            });
        }
    }
};
