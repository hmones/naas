<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipQuestions3 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->text('header')->nullable();
            $table->integer('repeat_group')->nullable()->index('repeat_group');
            $table->string('repeat_btn_txt', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->dropColumn('header');
            $table->dropColumn('repeat_group');
            $table->dropColumn('repeat_btn_txt');
        });
    }
}
