<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesMembershipQuestions extends Migration
{
    public function up()
    {
        Schema::create('hmones_membership_questions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->text('question');
            $table->integer('type')->unsigned()->index('type');
            $table->integer('order')->unsigned()->default(0)->index('order');
            $table->bigInteger('theme_id')->nullable()->unsigned()->index('theme_id');
            $table->boolean('other_active')->default(0);
            $table->string('other_text')->nullable();
            $table->bigInteger('cond_option_id')->nullable()->unsigned();
            $table->text('add_script')->nullable();
            $table->text('add_css')->nullable();
            $table->timestamp('created_at')->nullable()->index('created_at');
            $table->timestamp('updated_at')->nullable()->index('updated_at');
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_membership_questions');
    }
}
