<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipQuestions7 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->boolean('file_multiple')->default(0);
            $table->smallInteger('file_type')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->dropColumn('file_multiple');
            $table->dropColumn('file_type');
        });
    }
}
