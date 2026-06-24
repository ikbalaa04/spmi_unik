<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('targets')) {
            return;
        }

        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('l1_id')->nullable();
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->decimal('value', 6, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('targets');
    }
}
