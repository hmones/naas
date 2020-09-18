<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipEmails2 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_emails', function($table)
        {
            $table->text('subject')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_emails', function($table)
        {
            $table->dropColumn('subject');
        });
    }
}
