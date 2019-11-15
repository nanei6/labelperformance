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
            $table->string('employee_number',30)->comment('工号');
            $table->string('group',10)->comment('组长名字');
            $table->string('type',10)->comment('组员;组长');
            $table->timestamp('entry_time')->comment('入职时间')->nullable();
            $table->string('status',10)->comment('正常;删除');
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
