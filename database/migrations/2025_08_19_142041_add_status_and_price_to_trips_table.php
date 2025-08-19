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
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->after('arrival_time');
            $table->decimal('price', 8, 2)->nullable()->after('status');
            $table->string('category')->default('Turismo')->after('price');
            $table->integer('passenger_count')->default(50)->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['status', 'price', 'category', 'passenger_count']);
        });
    }
};
