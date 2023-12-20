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
        Schema::create('user_variations', function (Blueprint $table) {
            $table->id();
            $table->string('cookie_user_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('bg_id')->nullable();
            $table->bigInteger('variation_id')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_variations');
    }
};
