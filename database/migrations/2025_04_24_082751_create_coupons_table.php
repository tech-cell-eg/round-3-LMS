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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->string('offer_name');
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed_amount'])->default('percentage');
            $table->integer('amount');
            $table->integer('quantity')->default(0);
            $table->integer('redemptions')->default(0);
            $table->enum('status', ['active', 'expired' , 'draft' , 'scheduled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
