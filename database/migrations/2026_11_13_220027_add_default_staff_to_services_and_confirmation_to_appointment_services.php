
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Profesional predeterminada de cada servicio
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('staff_id')
                ->nullable()
                ->after('category')
                ->constrained('staff')
                ->nullOnDelete();
        });

        // Confirmación individual de cada servicio de una cita
        Schema::table('appointment_services', function (Blueprint $table) {
            $table->string('staff_confirmation_status', 30)
                ->default('not_required')
                ->after('staff_id');
        });
    }

    public function down(): void
    {
        Schema::table('appointment_services', function (Blueprint $table) {
            $table->dropColumn('staff_confirmation_status');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropConstrainedForeignId('staff_id');
        });
    }
};
