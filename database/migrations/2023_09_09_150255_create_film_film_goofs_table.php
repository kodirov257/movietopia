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
        Schema::create('film_film_goofs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id')->index();
            $table->text('goof_uz');
            $table->text('goof_uz_cy')->nullable();
            $table->text('goof_ru');
            $table->text('goof_en');
            $table->unsignedTinyInteger('type_id');
            $table->boolean('spoiler')->default(false);
            $table->integer('sort')->default(1000);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::table('film_film_goofs', function (Blueprint $table) {
            $table->foreign('film_id')->references('id')->on('film_films')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('film_goof_types')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_film_goofs');
    }
};
