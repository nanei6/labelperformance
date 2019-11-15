<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProjectDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_project_day', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_number',30)->comment('工号');
            $table->integer('project_id')->comment('项目ID');
            $table->dateTime('date');
            $table->integer('daily_standard')->comment('日标准量');
            $table->integer('daily_label')->comment('日标注量');
            $table->timestamps();
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_project_day');
    }
}
