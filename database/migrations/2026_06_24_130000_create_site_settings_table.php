<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('site_settings')) {
            return;
        }

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->default('Sistem Penjaminan Mutu Internal');
            $table->string('campus_name')->default('Nama Perguruan Tinggi');
            $table->string('logo_path')->nullable();
            $table->string('admin_logo_path')->nullable();
            $table->string('banner_1_path')->nullable();
            $table->string('banner_2_path')->nullable();
            $table->string('banner_3_path')->nullable();
            $table->string('about_image_path')->nullable();
            $table->string('hero_1_title')->nullable();
            $table->text('hero_1_description')->nullable();
            $table->string('hero_2_title')->nullable();
            $table->text('hero_2_description')->nullable();
            $table->string('hero_3_title')->nullable();
            $table->text('hero_3_description')->nullable();
            $table->string('feature_1_title')->nullable();
            $table->text('feature_1_description')->nullable();
            $table->string('feature_2_title')->nullable();
            $table->text('feature_2_description')->nullable();
            $table->string('feature_3_title')->nullable();
            $table->text('feature_3_description')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
}
