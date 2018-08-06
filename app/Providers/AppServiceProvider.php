<?php

namespace App\Providers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use App\Models\Reply;
use App\Observers\UserObserver;
use App\Observers\ArticleObserver;
use App\Observers\ReplyObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh');
        //注册观察者
        User::observe(UserObserver::class);
        Reply::observe(ReplyObserver::class);
        Article::observe(ArticleObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
