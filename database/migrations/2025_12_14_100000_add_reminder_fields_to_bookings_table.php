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
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('event_date')->nullable()->after('status');
            $table->timestamp('reminder_sent_at')->nullable()->after('event_date');
            $table->boolean('reminder_enabled')->default(true)->after('reminder_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['event_date', 'reminder_sent_at', 'reminder_enabled']);
        });
    }
};
