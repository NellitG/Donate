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
    Schema::create('subscription_plans', function (Blueprint $table) {
        $table->id('plan_id');
        $table->string('plan_name');
        $table->text('plan_description')->nullable();
        $table->decimal('plan_price', 10, 2);
        $table->integer('duration_months');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
