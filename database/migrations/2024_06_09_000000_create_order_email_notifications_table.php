<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_email_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->text('message_content');
            $table->string('template_used')->nullable();
            $table->enum('status', ['sent', 'saved']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_email_notifications');
    }
}; 