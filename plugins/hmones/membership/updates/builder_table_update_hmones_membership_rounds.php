<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipRounds extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_rounds', function($table)
        {
            $table->dropColumn('total_draft');
            $table->dropColumn('total_submit');
            $table->dropColumn('total_accept');
            $table->dropColumn('total_reject');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_rounds', function($table)
        {
            $table->integer('total_draft')->unsigned()->default(0);
            $table->integer('total_submit')->unsigned()->default(0);
            $table->integer('total_accept')->unsigned()->default(0);
            $table->integer('total_reject')->unsigned()->default(0);
        });
    }
}
