<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('fields')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete()->cascadeOnUpdate();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('total_price', 8, 2);
            $table->enum('payment_method', ['cash'])->default('cash');
            $table->enum('status', ['confirmed', 'canceled', 'pending'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['field_id', 'date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

