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
            $table->boolean('leave_at_door')->default(false)->after('note');
            $table->boolean('no_bell')->default(false)->after('leave_at_door');
            $table->boolean('eco_friendly')->default(false)->after('no_bell');
            $table->text('courier_note')->nullable()->after('eco_friendly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['leave_at_door', 'no_bell', 'eco_friendly', 'courier_note']);
        });
    }
};
