<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('fields')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_booked')->default(false);
            $table->timestamps();

            $table->unique(['field_id', 'date', 'start_time', 'end_time'], 'field_slot_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_availability');
    }
};

