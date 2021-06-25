<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOracleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle')->create('oracle_products', function (Blueprint $table) {
            $table->bigIncrements('pro_id');
            $table->string('pro_name')->nullable();
            $table->integer('pro_no')->nullable();
            $table->decimal('pro_weight',15,2)->nullable();
            $table->integer('pro_pack_size')->nullable();
            $table->date('pro_exp_date')->nullable();

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
        Schema::connection('oracle')->dropIfExists('oracle_products');
    }
}
