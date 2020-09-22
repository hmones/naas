<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesWebsiteAccordions extends Migration
{
    public function up()
    {
        Schema::table('hmones_website_accordions', function($table)
        {
            $table->boolean('is_open')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('hmones_website_accordions', function($table)
        {
            $table->dropColumn('is_open');
        });
    }
}
