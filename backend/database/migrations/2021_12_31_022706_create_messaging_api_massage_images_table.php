<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingApiMassageImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_api_massage_image', function (Blueprint $table) {
            $table->unsignedBigInteger('messageId');
            $table->foreign('messageId')
                ->references('id')
                ->on('messaging_api_massages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('imageSetId')->nullable();
            $table->integer("imageSetIndex");
            $table->integer("imageSetTotal");
            $table->string('type')->nullable();
            $table->string('originalContentUrl')->nullable();
            $table->string('previewImageUrl')->nullable();

            // アプリケーション上の配置
            $table->string('fileName')->nullable();
            $table->string('path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messaging_api_massage_image');
    }
}
