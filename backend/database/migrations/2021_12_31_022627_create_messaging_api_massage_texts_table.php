<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingApiMassageTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_api_massage_texts', function (Blueprint $table) {
            $table->unsignedBigInteger('messageId');
            $table->text('text')->nullable();
            $table->json('emojis')->nullable();
            $table->json('mention')->nullable();
            $table->foreign('messageId')
                ->references('id')
                ->on('messaging_api_massages')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messaging_api_massage_text');
    }
}
