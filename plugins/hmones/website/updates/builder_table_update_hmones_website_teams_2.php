<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesWebsiteTeams2 extends Migration
{
    public function up()
    {
        Schema::table('hmones_website_teams', function($table)
        {
            $table->string('email', 500)->nullable();
            $table->string('facebook', 500)->nullable();
            $table->string('instagram', 500)->nullable();
            $table->string('twitter', 500)->nullable();
            $table->string('linkedin', 500)->nullable();
            $table->string('website', 500)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('hmones_website_teams', function($table)
        {
            $table->dropColumn('email');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('twitter');
            $table->dropColumn('linkedin');
            $table->dropColumn('website');
        });
    }
}
