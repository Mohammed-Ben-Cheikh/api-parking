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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('number');  // Numéro de la place
            $table->decimal('Fee',10,2);
            $table->enum('status', ['available', 'occupied', 'reserved'])->default('available');
            $table->unsignedBigInteger('parking_id');
            $table->foreign('parking_id')->references('id')->on('parkings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
