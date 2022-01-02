<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingApiBeaconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_api_beacons', function (Blueprint $table) {
            $table->unsignedBigInteger("webhookEventId");
            $table->foreign('webhookEventId')
                ->references('id')
                ->on('messaging_api_webhook_events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('replyToken')->nullable();
            $table->string('beaconHwid')->nullable();
            $table->string('beaconType')->nullable();
            $table->string('beaconDm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messaging_api_beacons');
    }
}
