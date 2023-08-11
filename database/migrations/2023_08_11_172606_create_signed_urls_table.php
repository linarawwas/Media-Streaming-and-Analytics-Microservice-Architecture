<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignedUrlsTable extends Migration
{
    public function up()
    {
        Schema::create('signed_urls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('episode_id');
            $table->string('token')->unique();
            $table->timestamp('expiration_time');
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('episode_id')->references('id')->on('episodes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('signed_urls');
    }
}
