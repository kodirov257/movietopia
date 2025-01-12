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
        Schema::create('film_films', function (Blueprint $table) {
            $table->id();
            $table->string('title_uz');
            $table->string('title_uz_cy')->nullable();
            $table->string('title_ru');
            $table->string('title_en');
            $table->string('original_title');
            $table->string('description_uz');
            $table->string('description_uz_cy')->nullable();
            $table->string('description_ru');
            $table->string('description_en');
            $table->string('storyline_uz');
            $table->string('storyline_uz_cy')->nullable();
            $table->string('storyline_ru');
            $table->string('storyline_en');
            $table->string('slug');
            $table->boolean('tv_series')->default(false);
            $table->tinyInteger('status');
            $table->string('poster')->nullable();
            $table->integer('age_rating');
            $table->float('film_rating')->default(0);
            $table->integer('film_rating_number')->default(0);
            $table->integer('duration_minutes');
            $table->timestamp('world_released_at');
            $table->timestamp('last_season_released_at')->nullable();
            $table->timestamp('last_episode_released_at')->nullable();
            $table->boolean('budget_estimated')->nullable();
            $table->string('budget_from')->nullable();
            $table->string('budget_to')->nullable();
            $table->string('box_office_local')->nullable();
            $table->string('box_office_worldwide')->nullable();
            $table->timestamp('filming_date_from')->nullable();
            $table->timestamp('filming_date_to')->nullable();
            $table->jsonb('sites')->nullable();
            $table->float('imdb_rating')->nullable();
            $table->integer('imdb_rating_votes')->nullable();
            $table->jsonb('meta_json')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('film_films', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_films');
    }
};
