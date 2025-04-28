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
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->char('source_currency', 3);
            $table->char('target_currency', 3);
            $table->decimal('amount', 20, 6);
            $table->decimal('converted_amount', 20, 6);
            $table->foreignId('exchange_rate_id')->constrained('exchange_rates');
            $table->timestamps();
            
            // Index for frequently queried fields
            $table->index(['source_currency', 'target_currency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};
