<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipQuestions2 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->boolean('published')->default(0)->index('published');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->dropColumn('published');
        });
    }
}
