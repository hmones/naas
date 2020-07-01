<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipProfiles extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_profiles', function($table)
        {
            $table->integer('user_id')->unsigned()->index('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_profiles', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
