<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminLogoPathToSiteSettingsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('site_settings') && !Schema::hasColumn('site_settings', 'admin_logo_path')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->string('admin_logo_path')->nullable()->after('logo_path');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('site_settings') && Schema::hasColumn('site_settings', 'admin_logo_path')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->dropColumn('admin_logo_path');
            });
        }
    }
}
