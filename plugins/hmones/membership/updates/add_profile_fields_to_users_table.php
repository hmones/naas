<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->boolean('old_member')->default(0)->index('old_member');
            $table->smallInteger('role')->unsigned()->default(0)->index('role');
            $table->string('email_org')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropDown([
                'old_member',
                'role',
                'email_org',
                'website',
                'facebook',
                'twitter',
                'instagram',
                'youtube',
            ]);
        });
    }
}
