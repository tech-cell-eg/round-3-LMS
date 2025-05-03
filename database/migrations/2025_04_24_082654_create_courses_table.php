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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration')->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced']);
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('status')->default(1);
            $table->decimal('sale', 10, 2)->default(0);
            $table->string('language')->default('Arabic');
            $table->boolean('certificate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
