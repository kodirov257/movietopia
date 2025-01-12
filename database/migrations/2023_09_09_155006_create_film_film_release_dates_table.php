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
        Schema::create('film_film_release_dates', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('country_id');
            $table->timestamp('release_date');
            $table->string('details_uz');
            $table->string('details_uz_cy')->nullable();
            $table->string('details_ru');
            $table->string('details_en');
            $table->integer('sort')->default(1000);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::table('film_film_release_dates', function (Blueprint $table) {
            $table->index(['model_type', 'model_id']);
            $table->unique(['model_type', 'model_id', 'country_id']);
            $table->foreign('country_id')->references('id')->on('countries_regions')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_film_release_dates');
    }
};
