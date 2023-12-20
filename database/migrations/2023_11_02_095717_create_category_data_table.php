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
        Schema::create('category_data', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->longText('description')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('image')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_data');
    }
};
