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
    Schema::create('donation_leaderboard', function (Blueprint $table) {
        $table->id('leaderboard_id');
        $table->foreignId('donor_id')->constrained('donors');
        $table->foreignId('campaign_id')->constrained('campaigns');
        $table->decimal('total_donated', 10, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_leaderboard');
    }
};
