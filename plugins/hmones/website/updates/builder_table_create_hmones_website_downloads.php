<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesWebsiteDownloads extends Migration
{
    public function up()
    {
        Schema::create('hmones_website_downloads', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 500);
            $table->integer('display_order')->default(0)->index();
            $table->string('identifier', 500)->index();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_website_downloads');
    }
}
