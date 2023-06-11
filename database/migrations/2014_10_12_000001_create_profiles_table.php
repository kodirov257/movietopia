<?php

use App\Entity\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        DB::table('profiles')->insert([
            'user_id'           => 1,
            'first_name'        => 'admin',
            'last_name'         => 'adminoff',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        DB::table('profiles')->insert([
            'user_id'           => 2,
            'first_name'        => 'moderator',
            'last_name'         => 'moderatoroff',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        DB::table('profiles')->insert([
            'user_id'           => 3,
            'first_name'        => 'critic',
            'last_name'         => 'criticoff',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        DB::table('profiles')->insert([
            'user_id'           => 4,
            'first_name'        => 'user',
            'last_name'         => 'useroff',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
