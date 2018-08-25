<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Link;
use App\Models\tag;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('commons._aside', function ($view) {
            $recommended_articles =Link::getRecommendedCached();
            $view_articles=Link::getViewCached();
            $hot_tags=Tag::getHotTags();
            $view->with(compact('recommended_articles','view_articles','hot_tags'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

}
