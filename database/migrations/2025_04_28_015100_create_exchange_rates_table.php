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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->char('base_currency', 3); // ISO currency codes are 3 chars (USD, EUR, etc.)
            $table->char('target_currency', 3);
            $table->decimal('rate', 20, 6); // Sufficient precision for exchange rates
            $table->timestamp('timestamp');
            $table->timestamps();
            
            // Index for frequently queried fields
            $table->index(['base_currency', 'target_currency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
