<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReplayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replayments', function (Blueprint $table) {
            $table->increments('rid');
            $table->integer('uid');
            $table->integer('pid');
            $table->string('title');
            $table->float('amount',10,2);
            $table->date('paydate');
            $table->tinyinteger('status')->default(0);
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
        Schema::dropIfExists('replayments');
    }
}
