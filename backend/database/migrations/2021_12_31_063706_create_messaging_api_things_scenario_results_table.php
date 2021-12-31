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
            $table->string('replyToken');
            $table->string('thingsDeviceId');
            $table->string('thingsResultScenarioId');
            $table->integer('thingsResultRevision');
            $table->timestamp('thingsResultStartTime');
            $table->timestamp('thingsResultEndTime');
            $table->string('thingsResultResultCode');
            $table->json('thingsResultActionResults');
            $table->string('thingsResultBleNotificationPayload');
            $table->string('thingsResultErrorReason');
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
