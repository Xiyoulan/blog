<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsToUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('notification_count')->unsigned()->default(0)->after('is_activated');
            $table->integer('reply_count')->unsigned()->default(0)->after('notification_count');
            $table->integer('article_count')->unsigned()->default(0)->after('reply_count');
            $table->integer('follower_count')->unsigned()->default(0)->after('article_count');
            $table->integer('following_count')->unsigned()->default(0)->after('follower_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('notification_count');
            $table->dropColumn('reply_count');
            $table->dropColumn('article_count');
            $table->dropColumn('follower_count');
            $table->dropColumn('following_count');
        });
    }

}
