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
        Schema::table('trips', function (Blueprint $table) {
            // Adicionar apenas os campos que não existem
            $table->string('trip_name')->nullable()->after('id');
            $table->string('rule')->nullable()->after('trip_name');
            $table->date('trip_date')->nullable()->after('rule');
            $table->string('ticket_price')->nullable()->after('arrival_time');
            $table->string('driver_registration')->nullable()->after('passenger_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn([
                'trip_name',
                'rule', 
                'trip_date',
                'ticket_price',
                'driver_registration'
            ]);
        });
    }
};
