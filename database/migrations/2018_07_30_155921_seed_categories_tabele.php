<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesTabele extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
                [
                'name' => '分享',
                'description' => '分享创造、分享发现',
            ],
                [
                'name' => '资源',
                'description' => '发现宝藏,资源共享',
            ],
                [
                'name' => '问答',
                'description' => '互帮互助,共同成长',
            ],
                [
                'name' => '闲情',
                'description' => '闲情趣事、自娱自乐',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }

}
