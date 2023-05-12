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
        Schema::create('expedition', function (Blueprint $table) {
            $table->id();
            $table->uuid('order')->unique();
            $table->enum('status', ['analise', 'aproved', 'production', 'expedition']);
            $table->string('vehicle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedition');
    }
};
