<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingApiWebhookEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_api_webhook_events', function (Blueprint $table) {
            $table->id();
            $table->string('destination');

            // 共通プロパティ
            $table->string('mode');
            $table->string('sourceType');
            $table->string('userId');
            $table->string('groupId');
            $table->string('roomId');
            $table->timestamp('createdAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('massages');
    }
}
