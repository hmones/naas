<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesWebsiteStatistics extends Migration
{
    public function up()
    {
        Schema::table('hmones_website_statistics', function($table)
        {
            $table->string('icon', 250)->default('stop');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_website_statistics', function($table)
        {
            $table->dropColumn('icon');
        });
    }
}
