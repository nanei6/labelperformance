<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitPriceAtProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->decimal('label_unit_price',6,3)->comment('标注单价')->nullable();
            $table->decimal('check_unit_price',6,3)->comment('审核单价')->nullable();
            $table->integer('accepted_count')->comment('入库量')->nullable();

        });//
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
