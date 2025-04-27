<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('activity_type_company', function (Blueprint $table) {
            $table->foreignId('company_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('activity_type_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['company_id', 'activity_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_types');
        Schema::dropIfExists('company_activity_type');
    }
};
