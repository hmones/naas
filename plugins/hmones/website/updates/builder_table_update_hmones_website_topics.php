<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesWebsiteTopics extends Migration
{
    public function up()
    {
        Schema::table('hmones_website_topics', function($table)
        {
            $table->string('slug', 500)->nullable(false)->unsigned(false)->default(null)->index()->change();
        });
    }
    
    public function down()
    {
        Schema::table('hmones_website_topics', function($table)
        {
            $table->text('slug')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
