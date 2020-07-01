<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipQuestions4 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->boolean('old_member')->default(0)->index('old_member');
            $table->boolean('new_member')->default(1)->index('new_member');
            $table->boolean('prefill')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->dropColumn('old_member');
            $table->dropColumn('new_member');
            $table->dropColumn('prefill');
        });
    }
}
