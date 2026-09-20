<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('name');
            $table->string('company_logo')->nullable()->after('company_name');
            $table->text('company_description')->nullable()->after('company_logo');
            $table->string('company_website')->nullable()->after('company_description');
            $table->string('company_phone')->nullable()->after('company_website');
            $table->string('company_location')->nullable()->after('company_phone');
            $table->string('company_size')->nullable()->after('company_location');
            $table->boolean('is_recruiter')->default(false)->after('company_size');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'company_logo',
                'company_description',
                'company_website',
                'company_phone',
                'company_location',
                'company_size',
                'is_recruiter',
            ]);
        });
    }
};
