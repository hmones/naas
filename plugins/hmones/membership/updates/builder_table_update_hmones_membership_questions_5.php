<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipQuestions5 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->text('subheader')->nullable();
            $table->text('validation')->nullable();
            $table->boolean('required')->default(0);
            $table->boolean('repeat_active')->default(0);
            $table->renameColumn('repeat_btn_txt', 'repeat_text');
            $table->renameColumn('repeat_group', 'group');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->dropColumn('subheader');
            $table->dropColumn('validation');
            $table->dropColumn('required');
            $table->dropColumn('repeat_active');
            $table->renameColumn('repeat_text', 'repeat_btn_txt');
            $table->renameColumn('group', 'repeat_group');
        });
    }
}
