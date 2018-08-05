<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{

    public function run()
    {
        //创建一千条回复,将回复随机分配话题和回复人
        //所有人的用户id
        $user_ids = User::all()->pluck('id')->toArray();
        //所有帖子的id
        $article_ids = Article::all()->pluck('id')->toArray();
        //实例化faker
        $faker = app(\Faker\Generator::class);
        $replys = factory(Reply::class)
                ->times(1000)
                ->make()
                ->each(function ($reply, $index)use($user_ids, $article_ids, $faker) {
            $reply->from = $faker->randomElement($user_ids);
            $reply->article_id = $faker->randomElement($article_ids);
            if ($index % 2 == 0) {
                $reply->to = $faker->randomElement($user_ids);
            } else {
                $reply->to = null;
            }
        });
        // 将数据集合转换为数组，并插入到数据库中
        Reply::insert($replys->toArray());
        $article = Article::find(1);
        $parent_ids = $article->replies()->pluck('id')->toArray();
        $replys2 = factory(Reply::class)
                ->times(100)
                ->make()
                ->each(function ($reply, $index)use($user_ids, $parent_ids, $faker) {
            $reply->from = $faker->randomElement($user_ids);
            $reply->article_id = 1;
            if ($index % 2 == 0) {
                $reply->to = $faker->randomElement($user_ids);
            } else {
                $reply->to = null;
            }
            $reply->parent_id = $faker->randomElement($parent_ids);
        });
        Reply::insert($replys2->toArray());
    }

}
