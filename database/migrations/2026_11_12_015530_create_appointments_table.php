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
       
Schema::create('appointments', function (Blueprint $table) {
    $table->id();

    $table->foreignId('client_id')
        ->constrained('clients')
        ->restrictOnDelete();

    $table->date('appointment_date');
    $table->time('start_time');
    $table->time('end_time')->nullable();

    $table->string('location')->nullable();
    $table->text('address')->nullable();
    $table->text('notes')->nullable();

    $table->enum('status', [
        'pending',
        'confirmed',
        'completed',
        'cancelled',
        'no_show'
    ])->default('pending');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
