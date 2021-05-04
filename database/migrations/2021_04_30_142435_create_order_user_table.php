<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('order_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->date('start');
            $table->string('title');
            $table->integer('hour');
            $table->boolean('ferie');
            $table->timestamps();

            $table->primary(['user_id', 'order_id', 'start']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_user');
    }
}
