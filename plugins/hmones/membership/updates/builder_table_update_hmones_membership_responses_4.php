<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipResponses4 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_responses', function($table)
        {
            $table->renameColumn('isgroup', 'group');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_responses', function($table)
        {
            $table->renameColumn('group', 'isgroup');
        });
    }
}
