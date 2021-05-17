<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('');
            $table->string('active_token');
            $table->smallInteger('is_active')->default(0);
            $table->integer('answer_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->integer('ask_count')->default(0);
            $table->integer('collection_count')->default(0);
            $table->integer('following_count')->default(0);
            $table->integer('follower_count')->default(0);
            $table->json('setting')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
