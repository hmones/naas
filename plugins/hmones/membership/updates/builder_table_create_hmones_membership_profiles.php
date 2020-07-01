<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesMembershipProfiles extends Migration
{
    public function up()
    {
        Schema::create('hmones_membership_profiles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->boolean('old_member')->default(0)->index('old_member');
            $table->smallInteger('role')->unsigned()->default(0)->index('role');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_membership_profiles');
    }
}
