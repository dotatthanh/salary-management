<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('month');
            $table->string('year');
            $table->integer('paid_day_off'); // ngày nghỉ có lương
            $table->integer('unpaid_day_off'); // ngày nghỉ không lương
            $table->integer('total_days_off'); // tổng số ngày nghỉ
            $table->integer('total_working_days'); // tổng số ngày làm việc
            $table->bigInteger('salary'); // tiền lương
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
        Schema::dropIfExists('salary');
    }
}
