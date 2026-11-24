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
       
Schema::create('appointment_services', function (Blueprint $table) {
    $table->id();

    $table->foreignId('appointment_id')
        ->constrained('appointments')
        ->cascadeOnDelete();

    $table->foreignId('service_id')
        ->constrained('services')
        ->restrictOnDelete();

    $table->foreignId('staff_id')
        ->nullable()
        ->constrained('staff')
        ->nullOnDelete();

    // Datos del servicio al momento de reservar
    $table->string('service_name');
    $table->decimal('price', 10, 2)->nullable();
    $table->unsignedSmallInteger('duration_minutes')->nullable();

    // Horario individual de cada servicio
    $table->time('start_time')->nullable();
    $table->time('end_time')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_services');
    }
};
