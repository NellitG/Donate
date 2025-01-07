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
    Schema::create('events', function (Blueprint $table) {
        $table->id('event_id');
        $table->string('title');
        $table->text('description');
        $table->timestamp('start_date');
        $table->timestamp('end_date');
        $table->string('location');
        $table->foreignId('campaign_id')->nullable()->constrained('campaigns');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
