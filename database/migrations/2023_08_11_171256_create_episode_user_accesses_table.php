<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeUserAccessesTable extends Migration
{
    public function up()
    {
        Schema::create('episode_user_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('episode_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            // Add foreign key constraints
            $table->foreign('episode_id')->references('id')->on('episodes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('episode_user_accesses');
    }
}
