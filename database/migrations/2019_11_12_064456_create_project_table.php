<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name','100')->comment('项目名称');
            $table->timestamp('estimated_time')->comment('预计完成时间')->nullable();
            $table->timestamp('finish_time')->comment('实际完成时间')->nullable();
            $table->integer('estimated_count')->comment('预计总量')->nullable();
            $table->integer('true_count')->comment('实际完成量')->nullable();
            $table->string('summary')->comment('项目简介')->nullable();
            $table->decimal('unit_price',6,3)->comment('单价')->nullable();
            $table->decimal('total_revenue',10,3)->comment('总收入')->nullable();
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
        Schema::dropIfExists('project');
    }
}
