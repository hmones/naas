<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipQuestions6 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->renameColumn('order', 'display_order');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->renameColumn('display_order', 'order');
        });
    }
}
