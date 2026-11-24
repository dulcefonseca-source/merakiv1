<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {

            $table->string('price_type', 20)
                ->default('fixed')
                ->after('price');

            $table->string('price_unit', 50)
                ->nullable()
                ->after('price_type');

        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {

            $table->dropColumn([
                'price_type',
                'price_unit',
            ]);

        });
    }
};
