
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment_services', function (Blueprint $table) {
            $table->dropForeign(['service_id']);

            $table->unsignedBigInteger('service_id')
                ->nullable()
                ->change();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->restrictOnDelete();

            $table->string('category')->nullable()->after('service_id');
        });
    }

    public function down(): void
    {
        Schema::table('appointment_services', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('category');

            // El servicio podrá quedar sin asignar al revertir.
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->restrictOnDelete();
        });
    }
};
