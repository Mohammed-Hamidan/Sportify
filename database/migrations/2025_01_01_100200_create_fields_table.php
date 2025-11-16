<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('sport_id')->constrained('sports')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('district_id')->constrained('districts')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->decimal('price_per_hour', 8, 2);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('rating', 3, 2)->default(0);
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['sport_id', 'district_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};

