<?php

use Illuminate\Database\Migrations\Migration;
class CreateElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // The elements table is already created by
        // 2022_01_18_081208_element.php.
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Do not drop a table owned by an earlier migration.
    }
}
