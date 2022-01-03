<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingApiThingsScenarioResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_api_things_scenario_results', function (Blueprint $table) {
            $table->unsignedBigInteger("webhookEventId");
            $table->foreign('webhookEventId')
                ->references('id')
                ->on('messaging_api_webhook_events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('replyToken')->nullable();
            $table->string('thingsDeviceId')->nullable();
            $table->string('thingsResultScenarioId')->nullable();
            $table->integer('thingsResultRevision');
            $table->integer('thingsResultStartTime');
            $table->integer('thingsResultEndTime');
            $table->string('thingsResultResultCode')->nullable();
            $table->json('thingsResultActionResults')->nullable();
            $table->string('thingsResultBleNotificationPayload')->nullable();
            $table->string('thingsResultErrorReason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messaging_api_things_scenario_results');
    }
}
