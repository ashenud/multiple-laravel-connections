<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegrationSyncTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_local')->create('integration_sync_time', function (Blueprint $table) {
            $table->id();
            $table->string('server_table_name')->nullable();
            $table->string('local_table_name')->nullable();
            $table->dateTime('last_sync_time')->nullable();
            $table->tinyInteger('last_sync_status')->default(1)->comments('1-completed, 0-locked');
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
        Schema::connection('mysql_server')->dropIfExists('integration_sync_time');
    }
}
