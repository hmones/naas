<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteHmonesMembershipProfiles extends Migration
{
    public function up()
    {
        Schema::dropIfExists('hmones_membership_profiles');
    }
    
    public function down()
    {
        Schema::create('hmones_membership_profiles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->boolean('old_member')->default(0);
            $table->smallInteger('role')->unsigned()->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('user_id')->unsigned();
        });
    }
}
