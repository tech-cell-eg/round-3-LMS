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
        Schema::table('enrollments', function (Blueprint $table) {

            //remove column
            $table->dropColumn(columns: 'enrollment_date');
            $table->float('discount_percentage')->default(0);
            $table->string('discount_code')->nullable();
            $table->float('total_price');
            $table->enum('role', ['student', 'instructor','admin'])->default('student');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            //
        });
    }
};
