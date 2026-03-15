<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_intervals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->date('date');       // 2026-03-15   
            $table->time('start_time'); // 14:00:00
            $table->time('end_time');   // 17:00:00
            $table->string('specific_location')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_intervals');
    }
};
