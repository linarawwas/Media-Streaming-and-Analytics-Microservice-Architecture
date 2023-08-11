<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuedLogsTable extends Migration
{
    public function up()
    {
        Schema::create('queued_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stream_log_id');
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('stream_log_id')->references('id')->on('stream_logs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('queued_logs');
    }
}
