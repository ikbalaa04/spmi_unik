<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkreditasisTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('akreditasis')) {
            return;
        }

        Schema::create('akreditasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prodi_id')->unique();
            $table->string('fakultas', 150);
            $table->string('peringkat', 100);
            $table->text('sertifikat_url')->nullable();
            $table->string('nomor_sk', 255);
            $table->date('tanggal_akreditasi');
            $table->timestamps();

            $table->foreign('prodi_id')
                ->references('id')
                ->on('prodis')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akreditasis');
    }
}
