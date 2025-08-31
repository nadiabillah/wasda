<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->string('opd', 500)->nullable();
            $table->string('url_app', 500)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 500)->nullable();
            $table->text('message')->nullable();
            $table->string('imagepath', 65535)->nullable();
            $table->dateTime('schedule')->nullable();
            $table->boolean('sent')->default(false);
            $table->dateTime('sent_time')->nullable();
            $table->integer('server')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp');
    }
};
