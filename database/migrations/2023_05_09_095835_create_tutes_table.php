<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutes', function (Blueprint $table) {
            $table->id();
             $table->integer('institute_id')->unsigned();
            $table->integer('tution_id')->unsigned();
            $table->string('month_for');
            $table->tinyInteger('is_free')->default('0');
            $table->integer('price')->unsigned()->nullable()->default(0);
            $table->integer('added');
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
        Schema::dropIfExists('tutes');
    }
}
