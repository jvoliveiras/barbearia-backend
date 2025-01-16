<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogCarimbos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_carimbos', function (Blueprint $table) {
            $table->id();

            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')
            ->on('users')->onDelete('cascade');

            $table->integer('cartao_id')->unsigned();
            $table->foreign('cartao_id')->references('id')
            ->on('cartao_fidelidades')->onDelete('cascade');

            $table->string('referencia');

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
        Schema::dropIfExists('log_carimbos');
    }
}
