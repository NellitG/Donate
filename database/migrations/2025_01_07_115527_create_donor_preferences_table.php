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
    Schema::create('goods_donations', function (Blueprint $table) {
        $table->id('goods_id');
        $table->foreignId('donation_id')->constrained('donations');
        $table->string('item_name');
        $table->integer('quantity');
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
