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
        Schema::create('countries_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name_uz');
            $table->string('name_uz_cy')->nullable();
            $table->string('name_ru');
            $table->string('name_en');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('type');
            $table->string('slug');
            $table->jsonb('meta_json')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::table('countries_regions', function (Blueprint $table) {
            $table->unique(['slug', 'parent_id']);
            $table->foreign('parent_id')->references('id')->on('countries_regions')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries_regions');
    }
};
