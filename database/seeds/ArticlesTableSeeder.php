<?php

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
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
         $user_ids =User::all()->pluck('id')->toArray();
        $faker = app(\Faker\Generator::class);
        //page_imgage
        $page_images = [
            asset('img/1.jpg'),
            asset('img/2.jpg'),
            asset('img/3.jpg'),
        ];
        $articles = factory(Article::class)->times(100)->make()->each(function($article,$index) use ($faker, $category_ids, $user_ids,$page_images) {
            $article->user_id = $faker->randomElement($user_ids);
            $article->category_id = $faker->randomElement($category_ids);
            $article->page_image =  $faker->randomElement($page_images);
        });
        Article::insert($articles->toArray());
        foreach (User::all() as $user){
            $article_count =$user->articles()->count();
            $user->article_count = $article_count;
            $user->save();
        }
    }

}
