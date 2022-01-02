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
            $table->string('destination')->nullable();

            // 共通プロパティ
            $table->string('mode')->nullable();
            $table->string('sourceType')->nullable();
            $table->string('userId')->nullable();
            $table->string('groupId')->nullable();
            $table->string('roomId')->nullable();
            $table->timestamp('createdAt')->nullable();
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
