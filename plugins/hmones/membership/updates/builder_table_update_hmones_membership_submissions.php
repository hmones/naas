<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipSubmissions extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_submissions', function($table)
        {
            $table->string('lang', 100)->default('en');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_submissions', function($table)
        {
            $table->dropColumn('lang');
        });
    }
}
