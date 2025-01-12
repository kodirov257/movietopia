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
        Schema::create('film_film_types', function (Blueprint $table) {
            $table->unsignedBigInteger('film_id');
            $table->unsignedInteger('type_id');
        });

        Schema::table('film_film_types', function (Blueprint $table) {
            $table->primary(['film_id', 'type_id']);
            $table->foreign('film_id')->references('id')->on('film_films')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_film_types');
    }
};
