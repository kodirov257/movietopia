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
        Schema::create('celebrity_celebrities', function (Blueprint $table) {
            $table->id();
            $table->string('first_name_uz');
            $table->string('first_name_uz_cy')->nullable();
            $table->string('first_name_ru');
            $table->string('first_name_en');
            $table->string('last_name_uz');
            $table->string('last_name_uz_cy')->nullable();
            $table->string('last_name_ru');
            $table->string('last_name_en');
            $table->string('middle_name_uz')->nullable();
            $table->string('middle_name_uz_cy')->nullable();
            $table->string('middle_name_ru')->nullable();
            $table->string('middle_name_en')->nullable();
            $table->string('photo')->nullable();
            $table->jsonb('professions_uz');
            $table->jsonb('professions_uz_cy')->nullable();
            $table->jsonb('professions_ru');
            $table->jsonb('professions_en');
            $table->text('biography_uz')->nullable();
            $table->text('biography_uz_cy')->nullable();
            $table->text('biography_ru')->nullable();
            $table->text('biography_en')->nullable();
            $table->unsignedInteger('live_place')->nullable();
            $table->string('original_name')->nullable();
            $table->string('birth_name')->nullable();
            $table->jsonb('nicknames')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->unsignedInteger('birth_place')->nullable();
            $table->timestamp('death_date')->nullable();
            $table->unsignedInteger('death_place')->nullable();
            $table->string('gender')->nullable();
            $table->float('height_foot')->nullable();
            $table->float('height_meter')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('slug');
            $table->jsonb('meta_json')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::table('celebrity_celebrities', function (Blueprint $table) {
            $table->foreign('live_place')->references('id')->on('countries_regions')->onDelete('cascade');
            $table->foreign('birth_place')->references('id')->on('countries_regions')->onDelete('cascade');
            $table->foreign('death_place')->references('id')->on('countries_regions')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celebrity_celebrities');
    }
};
