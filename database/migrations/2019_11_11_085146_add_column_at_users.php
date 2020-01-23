<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAtUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_number',30)->comment('工号')->nullable();
            $table->string('group',10)->comment('组长名字')->nullable();
            $table->string('type',10)->comment('组员;组长;审核;测速;项目经理');
            $table->timestamp('entry_time')->comment('入职时间')->nullable();
            $table->decimal('base_salary',12,3)->comment('基本工资')->nullable();
            $table->integer('working_days_per_month')->comment('每月工作天数')->nullable();
            $table->string('status',10)->comment('正常;删除')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
