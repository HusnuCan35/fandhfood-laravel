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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('delivery_time_type', ['now', 'scheduled'])->default('now')->after('courier_note');
            $table->date('delivery_date')->nullable()->after('delivery_time_type');
            $table->string('delivery_hour', 5)->nullable()->after('delivery_date'); // Format: "14:00"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_time_type', 'delivery_date', 'delivery_hour']);
        });
    }
};
