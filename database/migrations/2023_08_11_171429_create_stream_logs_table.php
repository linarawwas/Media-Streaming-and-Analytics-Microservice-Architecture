<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamLogsTable extends Migration
{
    public function up()
    {
        Schema::create('stream_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('episode_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('timestamp');
            // Add other logging fields as needed
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('episode_id')->references('id')->on('episodes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stream_logs');
    }
}
