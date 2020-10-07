<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesWebsiteAccordions extends Migration
{
    public function up()
    {
        Schema::create('hmones_website_accordions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title', 500);
            $table->text('content');
            $table->integer('display_order')->unsigned()->default(0)->index();
            $table->string('identifier', 500)->index();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_website_accordions');
    }
}
