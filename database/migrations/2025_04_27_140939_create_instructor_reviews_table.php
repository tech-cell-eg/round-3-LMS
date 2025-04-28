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
        Schema::create('instructor_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_review');
            $table->foreignId('instructor_id')->constrained()->onDelete('cascade');
            $table->enum('rating',['1' , '2', '3', '4', '5'])->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_reviews');
    }
};
