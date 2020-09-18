<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesMembershipResponses extends Migration
{
    public function up()
    {
        Schema::create('hmones_membership_responses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('submission_id')->unsigned()->index('submission_id');
            $table->bigInteger('theme_id')->unsigned()->index('theme_id');
            $table->bigInteger('question_id')->unsigned()->index('question_id');
            $table->text('text')->nullable();
            $table->bigInteger('option_id')->nullable()->index('option_id');
            $table->text('options_id')->nullable();
            $table->text('text_other')->nullable();
            $table->timestamp('created_at')->nullable()->index('created_at');
            $table->timestamp('updated_at')->nullable()->index('updated_at');
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_membership_responses');
    }
}
