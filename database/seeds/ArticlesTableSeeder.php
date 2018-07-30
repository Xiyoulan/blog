<?php

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

class ArticlesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获得分类id数组
        $category_ids = Category::all()->pluck('id')->toArray();
        //获得所有用户id数组
        // $user_ids =User::all()->pluck('id')->toArray();
        $faker = app(\Faker\Generator::class);
        //page_imgage
        $page_image = asset('img/1.jpg');
        $articles = factory(Article::class)->times(50)->make()->each(function($article, $index) use ($faker, $category_ids, $page_image) {
            $article->user_id = 1;
            $article->category_id = $faker->randomElement($category_ids);
            $article->page_image = $page_image;
        });
        Article::insert($articles->toArray());
    }

}
