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
        Schema::create('celebrity_trivias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('celebrity_id');
            $table->text('trivia_uz');
            $table->text('trivia_uz_cy');
            $table->text('trivia_ru');
            $table->text('trivia_en');
            $table->integer('sort')->default(1000);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::table('celebrity_trivias', function (Blueprint $table) {
            $table->foreign('celebrity_id')->references('id')->on('celebrity_celebrities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celebrity_trivias');
    }
};
