<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if doctrine/dbal is installed for cross-db compatibility
        // If not, we use raw SQL for MySQL which is the active DB here.
        // MODIFY COLUMN is MySQL syntax.
        
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('midtrans', 'manual', 'free') NOT NULL DEFAULT 'midtrans'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('midtrans', 'manual') NOT NULL DEFAULT 'midtrans'");
    }
};
