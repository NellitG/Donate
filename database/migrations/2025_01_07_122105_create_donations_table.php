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
    Schema::create('donations', function (Blueprint $table) {
        $table->id('donation_id');
        $table->foreignId('donor_id')->constrained('donors');
        $table->foreignId('campaign_id')->nullable()->constrained('campaigns');
        $table->decimal('amount', 10, 2);
        $table->timestamp('donation_date')->useCurrent();
        $table->enum('payment_method', ['Credit Card', 'PayPal', 'Bank Transfer']);
        $table->enum('status', ['Pending', 'Completed', 'Failed'])->default('Pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
