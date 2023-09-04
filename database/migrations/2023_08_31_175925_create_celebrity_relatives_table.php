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
        Schema::create('celebrity_relatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('celebrity_id');
            $table->unsignedBigInteger('relative_id')->nullable();
            $table->string('first_name_uz')->nullable();
            $table->string('first_name_uz_cy')->nullable();
            $table->string('first_name_ru')->nullable();
            $table->string('first_name_en')->nullable();
            $table->string('last_name_uz')->nullable();
            $table->string('last_name_uz_cy')->nullable();
            $table->string('last_name_ru')->nullable();
            $table->string('last_name_en')->nullable();
            $table->string('middle_name_uz')->nullable();
            $table->string('middle_name_uz_cy')->nullable();
            $table->string('middle_name_ru')->nullable();
            $table->string('middle_name_en')->nullable();
            $table->string('relation_type');
            $table->timestamp('marry_date')->nullable();
            $table->timestamp('divorce_date')->nullable();
            $table->string('divorce_reason')->nullable();
            $table->tinyInteger('children')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::table('celebrity_relatives', function (Blueprint $table) {
            $table->foreign('celebrity_id')->references('id')->on('celebrity_celebrities')->onDelete('cascade');
            $table->foreign('relative_id')->references('id')->on('celebrity_celebrities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celebrity_relatives');
    }
};
