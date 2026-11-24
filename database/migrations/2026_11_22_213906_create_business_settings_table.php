
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();

            // Identidad del estudio
            $table->string('business_name')->default('Meraki Estudio de Belleza');
            $table->string('tagline')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('cover_path')->nullable();

            // Información comercial
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();

            // Personalización visual
            $table->string('primary_color', 7)->default('#BD8980');
            $table->string('secondary_color', 7)->default('#654D50');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_settings');
    }
};
