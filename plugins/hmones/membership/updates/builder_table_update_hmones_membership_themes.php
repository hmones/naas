<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHmonesMembershipThemes extends Migration
{
    public function up()
    {
        Schema::table('hmones_membership_themes', function($table)
        {
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('hmones_membership_themes', function($table)
        {
            $table->dropColumn('description');
            $table->dropColumn('icon');
        });
    }
}
