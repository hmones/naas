<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipEmails extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_emails', function($table)
        {
            $table->text('name');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_emails', function($table)
        {
            $table->dropColumn('name');
        });
    }
}
