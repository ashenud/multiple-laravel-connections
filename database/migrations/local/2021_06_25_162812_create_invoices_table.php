<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_local')->create('invoices', function (Blueprint $table) {
            $table->bigIncrements('inv_id');
            $table->string('inv_no')->nullable();
            $table->date('inv_date')->nullable();
            $table->time('inv_time')->nullable();
            $table->unsignedBigInteger('inv_user')->nullable();
            $table->decimal('inv_amount',15,2)->nullable();
            $table->decimal('inv_discount',15,2)->nullable();

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
        Schema::connection('mysql_local')->dropIfExists('invoices');
    }
}
