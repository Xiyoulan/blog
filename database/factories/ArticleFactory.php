<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    // 随机取一个月以内的时间
    $published_at = $faker->dateTimeThisMonth();
    $updated_at = $faker->dateTimeThisMonth($published_at);
    // 传参为生成最大时间不超过，创建时间永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $faker->sentence(mt_rand(3, 10)),
        'content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'content_html' => $faker->text(),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
        'published_at' => $published_at,
    ];
});
