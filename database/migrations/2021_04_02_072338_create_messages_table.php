<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            // $table->unsignedBigInteger('sender_id')->index('messages_sender_id_foreign');
            $table->foreignId('sender_id')->constrained('users');
            $table->text('message');
            $table->foreignId('receiver_id')->constrained('users');
            // $table->unsignedBigInteger('receiver_id')->index('messages_receiver_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}