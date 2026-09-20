<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('headline')->nullable();
            $table->enum('employment_preference', ['full_time', 'part_time', 'contract', 'temporary', 'internship', 'cdi', 'cdd', 'stage', 'freelance', 'independant', 'independent'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'profile_photo', 'bio', 'location', 'headline', 'employment_preference']);
        });
    }
};
