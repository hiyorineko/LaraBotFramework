<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingApiMemberJoinedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_api_member_joineds', function (Blueprint $table) {
            $table->unsignedBigInteger("webhookEventId");
            $table->foreign('webhookEventId')
                ->references('id')
                ->on('messaging_api_webhook_events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('members')->nullable();
            $table->string('replyToken')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messaging_api_member_joineds');
    }
}
