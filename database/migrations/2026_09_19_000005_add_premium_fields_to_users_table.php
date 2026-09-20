<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'is_premium')) {
                $table->boolean('is_premium')->default(false)->after('is_blocked');
            }

            if (! Schema::hasColumn('users', 'premium_plan')) {
                $table->string('premium_plan')->nullable()->after('is_premium');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_premium')) {
                $table->dropColumn('is_premium');
            }

            if (Schema::hasColumn('users', 'premium_plan')) {
                $table->dropColumn('premium_plan');
            }
        });
    }
};
