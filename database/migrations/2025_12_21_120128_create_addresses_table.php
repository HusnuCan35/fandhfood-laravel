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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 50); // Ev, İş, Annem, vb.
            $table->enum('address_type', ['home', 'work', 'other'])->default('home');
            $table->text('full_address');
            $table->string('district', 100)->nullable(); // İlçe
            $table->string('city', 100)->nullable(); // Şehir
            $table->string('building_no', 20)->nullable();
            $table->string('floor', 10)->nullable();
            $table->string('apartment_no', 20)->nullable();
            $table->text('directions')->nullable(); // Tarif notu
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
