<?php namespace Hmones\Website\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesWebsiteTeams extends Migration
{
    public function up()
    {
        Schema::create('hmones_website_teams', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 500);
            $table->string('slug', 500)->index();
            $table->text('bio')->nullable();
            $table->integer('category')->default(0)->index();
            $table->integer('display_order')->default(0)->index();
            $table->string('img_credits', 500)->nullable();
            $table->string('position', 500)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_website_teams');
    }
}
