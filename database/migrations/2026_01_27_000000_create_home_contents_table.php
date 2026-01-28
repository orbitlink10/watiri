<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('hero_badge')->nullable();
            $table->string('hero_heading')->nullable();
            $table->string('hero_heading_highlight')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_primary_label')->nullable();
            $table->string('hero_primary_link')->nullable();
            $table->string('hero_secondary_label')->nullable();
            $table->string('hero_secondary_link')->nullable();
            $table->json('delivery_points')->nullable();
            $table->string('categories_title')->nullable();
            $table->text('categories_subtitle')->nullable();
            $table->string('bestsellers_title')->nullable();
            $table->text('bestsellers_subtitle')->nullable();
            $table->string('consult_title')->nullable();
            $table->text('consult_body')->nullable();
            $table->string('consult_primary_label')->nullable();
            $table->string('consult_primary_link')->nullable();
            $table->string('consult_secondary_label')->nullable();
            $table->string('consult_secondary_link')->nullable();
            $table->string('newsletter_title')->nullable();
            $table->text('newsletter_body')->nullable();
            $table->string('hero_image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};
