<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('vote_id', false, true);
            $table->string('douyu_name');
            //TODO douyu只传字符串 待加工
//            $table->integer('douyu_id', false, true);
            $table->string('douyu_id');
            $table->timestamp('vote_time');
            $table->tinyInteger('shark_fin');
            $table->index(['vote_id','douyu_id','vote_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
