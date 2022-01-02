<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingApiMassageStickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_api_massage_stickers', function (Blueprint $table) {
            $table->unsignedBigInteger('messageId');
            $table->foreign('messageId')
                ->references('id')
                ->on('messaging_api_massages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('packageId')->nullable();
            $table->string('stickerId')->nullable();
            $table->string('stickerResourceType')->nullable();
            $table->json('keywords')->nullable();
            $table->string('text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messaging_api_massage_stamps');
    }
}
