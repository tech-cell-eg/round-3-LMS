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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('My Site');
            $table->string('site_email')->default('info@example.com');
            $table->string('site_phone')->default('+1 (555) 123-4567');
            $table->string('site_address')->default('123 Main St, Anytown USA');
            $table->string('site_logo')->default('logo.png');
            $table->string('site_favicon')->default('favicon.ico');
            $table->string('site_description')->default('This is a sample site description.');
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('pinterest_link')->nullable();
            $table->string('tiktok_link')->nullable();
            $table->string('snapchat_link')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
