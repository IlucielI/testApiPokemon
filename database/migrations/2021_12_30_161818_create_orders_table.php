<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('pokemon_id')->nullable();
            $table->foreign('pokemon_id')
                ->on('my_pokemons')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('transaction_token');
            $table->string('transaction_status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('fraud_status')->nullable();
            $table->bigInteger('price')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->dateTime('paid_date')->nullable();
            $table->dateTime('expired')->nullable();
            $table->string('to_level');
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
        Schema::dropIfExists('orders');
    }
}
