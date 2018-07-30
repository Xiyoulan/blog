<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatars = [
            asset("img/cat1.jpg"),
            asset("img/cat2.jpg"),
            asset("img/cat3.jpg"),
            asset("img/cat4.jpg"),
        ];
        $faker = app(\Faker\Generator::class);
        $users = factory(User::class)->times(10)->make()->each(function($user, $index) use($avatars, $faker) {
            $user->avatar = $faker->randomElement($avatars);
        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        // 插入到数据库中
        User::insert($user_array);
        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'Xiyoulan';
        $user->email = 'xiyoulan1012@qq.com';
        $user->phone = '18825071530';
        $user->save();
    }

}
