<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityStreamsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('feedable_type');
            $table->string('feedable_id')->unsigned();
            $table->unique(['feedable_id', 'feedable_type']);
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('actor_type');
            $table->string('actor_id');
            $table->string('verb');
            $table->string('object');
            $table->string('target');
            $table->string('target_type')->nullable();
            $table->string('target_id')->nullable();
            $table->timestamps();
        });

        Schema::create('feed_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('activity_id');
            $table->bigInteger('feed_id');
            $table->unique(['feed_id', 'activity_id']);
            $table->timestamps();

            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->onDelete('cascade');

            $table->foreign('feed_id')
                ->references('id')
                ->on('feeds')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('feed_activities');
    }
}