<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipResponses6 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_responses', function($table)
        {
            $table->boolean('prefilled')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_responses', function($table)
        {
            $table->dropColumn('prefilled');
        });
    }
}
