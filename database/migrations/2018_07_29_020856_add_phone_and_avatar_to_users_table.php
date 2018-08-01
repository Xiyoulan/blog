<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneAndAvatarToUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique()->after('name');
            $table->string('avatar')->nullable()->after('email');
            $table->string('email')->nullable()->change();
            $table->string('name')->unique()->change();
            $table->string('introduction')->nullable()->after('avatar');
            $table->boolean('is_activated')->default(0)->after('remember_token');
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
            $table->dropColumn('phone');
            $table->dropColumn('avatar');
            $table->string('email')->nullable(false)->change();
            $table->dropUnique('users_name_unique');
            $table->dropColumn('introduction');
            $table->dropColumn('is_activated');
        });
    }

}
