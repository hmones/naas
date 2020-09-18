<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateProfileFieldsInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->renameColumn('role','membership_type');
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->renameColumn('membership_type','role');
        });
    }
}
