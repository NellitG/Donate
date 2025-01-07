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
        Schema::create('donor_preferences', function (Blueprint $table) {
            $table->id('preference_id');
            $table->foreignId('donor_id')->constrained('donors');
            $table->enum('communication_method', ['Email', 'Phone', 'SMS'])->default('Email');
            $table->enum('preferred_donation_type', ['Money', 'Goods', 'Services'])->default('Money');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donor_preferences');
    }
};
