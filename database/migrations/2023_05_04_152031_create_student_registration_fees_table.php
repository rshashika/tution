<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRegistrationFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_registration_fees', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->unsigned();
            $table->integer('payment_cat')->unsigned();
            $table->integer('amount');
            $table->tinyInteger('is_deleted')->default('0');
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
        Schema::dropIfExists('student_registration_fees');
    }
}
