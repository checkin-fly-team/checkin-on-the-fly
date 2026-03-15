<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'complete', 'cancelled'])->default('upcoming');
            $table->integer('capacity')->nullable();

            $table->string('location');
            $table->text('location_description')->nullable();

            
            $table->string('image')->nullable();
            $table->boolean('show_organizer_profiles')->default(true);
            // $table->string('support_contact')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
