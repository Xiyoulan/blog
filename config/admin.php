<?php

return [

    /*
     * 站点标题
     * Laravel-admin name.
     */
    'name' => 'Xiyoulan-admin',

    /*
     * 页面顶部 Logo
     * Logo in admin panel header.
     */
    'logo' => '<b>Xiyoulan</b> admin',

    /*
     * 页面顶部小 Logo
     * Mini-logo in admin panel header.
     */
    'logo-mini' => '<b>Xyl</b>',

    /*
     * 路由配置
     * Route configuration.
     */
    'route' => [

        'prefix' => 'admin',

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],
    ],

    /*
     * Laravel-Admin 的安装目录
     * Laravel-admin install directory.
     */
    'directory' => app_path('Admin'),

    /*
     * Laravel-Admin 页面标题
     * Laravel-admin html title.
     */
    'title' => 'Xiyoulan管理后台',

    /*
     * 是否使用 https
     * Use `https`.
     */
    'secure' => false,

    /*
     *  Laravel-Admin 用户认证设置
     * Laravel-admin auth setting.
     */
    'auth' => [
        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => Encore\Admin\Auth\Database\Administrator::class,
            ],
        ],
    ],

    /*
     * Laravel-Admin 文件上传设置
     * Laravel-admin upload setting.
     */
    'upload' => [

        'disk' => 'public',

        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],

    /*
     * Laravel-Admin 数据库设置
     * Laravel-admin database setting.
     */
    'database' => [

        // 数据库连接名称，留空即可
        'connection' => '',

       // 管理员用户表及模型
        'users_table' => 'admin_users',
        'users_model' => Encore\Admin\Auth\Database\Administrator::class,

        // 角色表及模型
        'roles_table' => 'admin_roles',
        'roles_model' => Encore\Admin\Auth\Database\Role::class,

        // 权限表及模型
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,

         // 菜单表及模型
        'menu_table' => 'admin_menu',
        'menu_model' => Encore\Admin\Auth\Database\Menu::class,

        // 多对多关联中间表
        'operation_log_table'    => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table'       => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table'        => 'admin_role_menu',
    ],

    /*
     *  Laravel-Admin 操作日志设置
     * By setting this option to open or close operation log in laravel-admin.
     */
    'operation_log' => [

        'enable' => true,

        /*
         * Routes that will not log to database.
         * 不记操作日志的路由
         * All method to path like: admin/auth/logs
         * or specific method to path like: get:admin/auth/logs
         */
        'except' => [
            'admin/auth/logs*',
        ],
    ],

    /*
     * 页面风格
     * @see https://adminlte.io/docs/2.4/layout
     */
    'skin' => 'skin-blue-light',

    /*
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
     */
    'layout' => ['sidebar-mini', 'sidebar-collapse'],

    /*
     * Background image in login page
     */
    'login_background_image' => '',

    /*
     * 页面底部展示的版本.
     * Version displayed in footer.
     */
    'version' => '1.5.x-dev',

    /*
     * 扩展设置
     * Settings for extensions.
     */
    'extensions' => [

    ],
];
