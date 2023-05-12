<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_tutes', function (Blueprint $table) {
            $table->id();
            $table->integer('institute_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('tution_id')->unsigned();
            $table->string('month_for');
            $table->tinyInteger('is_issued')->default('0');
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
        Schema::dropIfExists('student_tutes');
    }
}
