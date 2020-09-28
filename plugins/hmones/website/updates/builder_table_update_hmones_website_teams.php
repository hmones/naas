<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesWebsiteTeams extends Migration
{
    public function up()
    {
        Schema::table('hmones_website_teams', function($table)
        {
            $table->string('bio_summary', 500)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('hmones_website_teams', function($table)
        {
            $table->dropColumn('bio_summary');
        });
    }
}
