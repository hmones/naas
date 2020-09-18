<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipResponses2 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_responses', function($table)
        {
            $table->dropColumn('option_id');
            $table->dropColumn('options_id');
            $table->dropColumn('text_other');
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_responses', function($table)
        {
            $table->bigInteger('option_id')->nullable();
            $table->text('options_id')->nullable();
            $table->text('text_other')->nullable();
        });
    }
}
