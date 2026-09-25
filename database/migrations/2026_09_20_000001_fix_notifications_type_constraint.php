<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('notifications')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('application', 'alert', 'system', 'message', 'profile_match', 'status_update', 'deadline', 'confirmation') DEFAULT 'system'");

            return;
        }

        if (DB::getDriverName() === 'pgsql') {
            return;
        }

        Schema::rename('notifications', 'notifications_backup');

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['application', 'alert', 'system', 'message', 'profile_match', 'status_update', 'deadline', 'confirmation'])->default('system');
            $table->unsignedBigInteger('related_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        DB::statement('INSERT INTO notifications (id, user_id, title, message, type, related_id, is_read, created_at, updated_at)
            SELECT id, user_id, title, message, type, related_id, is_read, created_at, updated_at
            FROM notifications_backup');

        Schema::dropIfExists('notifications_backup');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('notifications')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('application', 'alert', 'system', 'message', 'profile_match', 'deadline', 'confirmation') DEFAULT 'system'");

            return;
        }

        if (DB::getDriverName() === 'pgsql') {
            return;
        }

        Schema::rename('notifications', 'notifications_backup');

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['application', 'alert', 'system', 'message', 'profile_match', 'deadline', 'confirmation'])->default('system');
            $table->unsignedBigInteger('related_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        DB::statement('INSERT INTO notifications (id, user_id, title, message, type, related_id, is_read, created_at, updated_at)
            SELECT id, user_id, title, message, type, related_id, is_read, created_at, updated_at
            FROM notifications_backup');

        Schema::dropIfExists('notifications_backup');
    }
};
