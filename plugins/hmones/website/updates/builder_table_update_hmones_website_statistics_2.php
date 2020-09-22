<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesWebsiteStatistics2 extends Migration
{
    public function up()
    {
        Schema::table('hmones_website_statistics', function($table)
        {
            $table->integer('step')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('hmones_website_statistics', function($table)
        {
            $table->dropColumn('step');
        });
    }
}
