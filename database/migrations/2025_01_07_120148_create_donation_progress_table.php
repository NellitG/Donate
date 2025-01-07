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
    Schema::create('donation_progress', function (Blueprint $table) {
        $table->id('progress_id');
        $table->foreignId('campaign_id')->constrained('campaigns');
        $table->timestamp('update_date')->useCurrent();
        $table->text('progress_description')->nullable();
        $table->decimal('progress_percentage', 5, 2)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_progress');
    }
};
