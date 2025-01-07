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
    Schema::create('donor_subscriptions', function (Blueprint $table) {
        $table->id('subscription_id');
        $table->foreignId('donor_id')->constrained('donors');
        $table->foreignId('plan_id')->constrained('subscription_plans');
        $table->date('start_date')->default(DB::raw('CURRENT_DATE'));
        $table->date('end_date')->nullable();
        $table->enum('status', ['Active', 'Expired'])->default('Active');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donor_subscriptions');
    }
};
