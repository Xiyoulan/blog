<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
        ], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('users', 'UserController', [
        'names' => [
            'create' => 'admin.users.create',
            'store' => 'admin.users.create',
            'index' => 'admin.users.index',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]
    ]);
    $router->resource('articles', 'ArticleController', [
        'names' => [
            'create' => 'admin.articles.create',
            'store' => 'admin.articles.create',
            'index' => 'admin.articles.index',
            'show' => 'admin.articles.show',
            'edit' => 'admin.articles.edit',
            'update' => 'admin.articles.update',
            'destroy' => 'admin.articles.destroy',
        ],
    ]);
    $router->post('articles/{article}/restore', 'ArticleController@restore')->name('admin.article.restore');
    $router->resource('replies', 'ReplyController', [
        'names' => [
            'index' => 'admin.replies.index',
            'show' => 'admin.replies.show',
            'destroy' => 'admin.replies.destroy',
        ],
        'only' => [
            'index',
            'show',
            'destroy'
        ]
    ]);
    $router->post('replies/{reply}/restore', 'ReplyController@restore')->name('admin.replies.restore');
});
