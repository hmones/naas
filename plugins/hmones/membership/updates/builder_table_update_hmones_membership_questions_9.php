<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipQuestions9 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->text('file_type')->nullable(false)->unsigned(false)->default('.jpg,.jpeg,.png,.gif,image/*')->change();
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_questions', function($table)
        {
            $table->string('file_type', 200)->nullable(false)->unsigned(false)->default('.jpg,.jpeg,.png,.gif,image/*')->change();
        });
    }
}
