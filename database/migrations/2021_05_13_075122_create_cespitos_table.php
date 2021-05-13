<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCespitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cespiti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoris_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('serialnumber');
            $table->string('marco');
            $table->string('modello');
            $table->foreignId('status_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('costo');
            $table->date('acquisto');
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
        Schema::dropIfExists('cespitos');
    }
}
