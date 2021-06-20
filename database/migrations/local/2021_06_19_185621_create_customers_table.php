<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_local')->create('customers', function (Blueprint $table) {
            $table->bigIncrements('cus_id');
            $table->string('cus_name')->nullable();
            $table->integer('cus_no')->nullable();
            $table->string('cus_add1')->nullable();
            $table->string('cus_add2')->nullable();
            $table->string('cus_add3')->nullable();
            $table->string('cus_tel')->nullable();
            $table->string('cus_fax')->nullable();
            $table->string('cus_email')->nullable();
            $table->dateTime('cus_adddate')->nullable();
            $table->string('cus_addtime')->nullable();

            $table->index('cus_no');

            $table->softDeletes();
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
        Schema::connection('mysql_server')->dropIfExists('customers');
    }
}
