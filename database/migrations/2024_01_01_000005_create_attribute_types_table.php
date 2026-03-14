<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('display_type', 20)->default('select'); // select, color_swatch, button
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_types');
    }
};
