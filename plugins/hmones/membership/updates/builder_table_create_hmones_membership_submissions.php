<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesMembershipSubmissions extends Migration
{
    public function up()
    {
        Schema::create('hmones_membership_submissions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('round_id')->nullable()->unsigned()->index('round_id');
            $table->bigInteger('user_id')->nullable()->unsigned()->index('user_id');
            $table->integer('status')->unsigned()->default(0)->index('status');
            $table->timestamp('created_at')->nullable()->index('created_at');
            $table->timestamp('updated_at')->nullable()->index('updated_at');
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_membership_submissions');
    }
}
