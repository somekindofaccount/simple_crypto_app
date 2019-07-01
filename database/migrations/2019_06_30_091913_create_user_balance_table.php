<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->float('amount', 19, 13);
            $table->integer('currency_id');
            $table->string('currency_name');
            $table->float('usd_rate',19, 13);
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
        Schema::dropIfExists('user_balances');
    }
}
