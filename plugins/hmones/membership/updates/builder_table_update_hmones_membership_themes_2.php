<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipThemes2 extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_themes', function($table)
        {
            $table->integer('display_order')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_themes', function($table)
        {
            $table->dropColumn('display_order');
        });
    }
}
