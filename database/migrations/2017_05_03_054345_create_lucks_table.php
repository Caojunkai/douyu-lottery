<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('lucks',function (Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('douyu_name');
                $table->integer('douyu_id',false,true);
                $table->integer('vote_id',false,true);
                $table->timestamp('vote_time');
                $table->integer('lucknum',false,true);
                $table->timestamp('created_at')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lucks');
    }
}
