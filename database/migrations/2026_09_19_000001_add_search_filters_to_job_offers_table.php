<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->string('city')->nullable()->after('location');
            $table->string('region')->nullable()->after('city');
            $table->string('domain')->nullable()->after('region');
            $table->string('education_level')->nullable()->after('required_experience');
            $table->enum('work_mode', ['remote', 'hybrid', 'on_site'])->nullable()->after('education_level');
        });
    }

    public function down(): void
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['city', 'region', 'domain', 'education_level', 'work_mode']);
        });
    }
};
