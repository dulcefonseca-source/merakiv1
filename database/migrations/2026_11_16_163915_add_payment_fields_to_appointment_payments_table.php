
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment_payments', function (Blueprint $table) {

            $table->foreignId('appointment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->dateTime('payment_date');

            $table->string('payment_method', 30);

            $table->string('reference')->nullable();

            $table->text('notes')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('appointment_payments', function (Blueprint $table) {

            $table->dropForeign(['appointment_id']);

            $table->dropColumn([
                'appointment_id',
                'amount',
                'payment_date',
                'payment_method',
                'reference',
                'notes',
            ]);

        });
    }
};
