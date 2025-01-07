<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('services_donations', function (Blueprint $table) {
            $table->id('service_id');
            $table->foreignId('donation_id')->constrained('donations');
            $table->text('service_description');
            $table->decimal('estimated_value', 10, 2)->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_donations');
    }
};
