<?php namespace Hmones\Membership\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHmonesMembershipRounds extends Migration
{
    public function up()
    {
        Schema::create('hmones_membership_rounds', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->integer('year')->unsigned()->index();
            $table->text('comment')->nullable();
            $table->dateTime('start')->index();
            $table->dateTime('end')->index();
            $table->boolean('active')->default(0)->index();
            $table->integer('total_draft')->unsigned()->default(0);
            $table->integer('total_submit')->unsigned()->default(0);
            $table->integer('total_accept')->unsigned()->default(0);
            $table->integer('total_reject')->unsigned()->default(0);
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hmones_membership_rounds');
    }
}
