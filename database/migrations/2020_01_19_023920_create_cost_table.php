<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('social_security',12,3)->comment('社保费用')->nullable();
            $table->decimal('social_security_per_person',12,3)->comment('社保人均缴纳金额')->default(0)->nullable();
            $table->decimal('chummage',12,3)->comment('房租')->default(0)->nullable();
            $table->decimal('property_fee',12,3)->comment('物业费用')->default(0)->nullable();
            $table->decimal('travel_expenses',12,3)->comment('差旅费用')->default(0)->nullable();
            $table->decimal('entertainment_expenses',12,3)->comment('招待费用')->default(0)->nullable();
            $table->timestamp('date')->comment('年-月');
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
        Schema::dropIfExists('cost');
    }
}
