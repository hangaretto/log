<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagnetarLogLogsTable extends Migration
{
    public function up()
    {
        Schema::create('magnetar_log_logs', function (Blueprint $table) {

            $table->increments('id');
            $table->text('text');
            $table->string('code');
            $table->string('level');

            if(config('database.default') == 'pgsql')
                $table->jsonb('data')->nullable();
            else
                $table->json('data')->nullable();

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::drop('magnetar_tariffs_user_balances');
    }
}