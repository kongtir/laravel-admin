<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin name
    |--------------------------------------------------------------------------
    |
    | This value is the name of laravel-admin, This setting is displayed on the
    | login page.
    |登陆页面的大标题，显示在登陆页面
    */
    'name' => 'Laravel-admin',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin logo
    |--------------------------------------------------------------------------
    |管理页面的logo设置，如果要设置为图片，可以设置为img标签
    | The logo of all admin pages. You can also set it as an image by using a
    | `img` tag, eg '<img src="http://logo-url" alt="Admin logo">'.
    |
    */
    'logo' => '<b>Laravel</b> admin',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin mini logo
    |--------------------------------------------------------------------------
    |当左侧边栏收起时显示的小logo，也可以设置为html标签
    | The logo of all admin pages when the sidebar menu is collapsed. You can
    | also set it as an image by using a `img` tag, eg
    | '<img src="http://logo-url" alt="Admin logo">'.
    |
    */
    'logo-mini' => '<b>La</b>',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin route settings
    |--------------------------------------------------------------------------
    |后台路由配置，应用在`app/Admin/routes.php`里面
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    |
    */
    'route' => [

        'prefix' => 'admin',

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin install directory
    |--------------------------------------------------------------------------
    |后台的安装目录，如果在运行`admin:install`之前修改它，那么后台目录将会是这个配置的目录
    | The installation directory of the controller and routing configuration
    | files of the administration page. The default is `app/Admin`, which must
    | be set before running `artisan admin::install` to take effect.
    |
    */
    'directory' => app_path('Admin'),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin html title
    |--------------------------------------------------------------------------
    |所有页面的<title>标签内容
    | Html title for all pages.
    |
    */
    'title' => 'Admin',

    /*
    |--------------------------------------------------------------------------
    | Access via `https`
    |--------------------------------------------------------------------------
    |后台是否使用https
    | If your page is going to be accessed via https, set it to `true`.
    |
    */
    'https' => env('ADMIN_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin auth setting
    |--------------------------------------------------------------------------
    |
    | Authentication settings for all admin pages. Include an authentication
    | guard and a user provider setting of authentication driver.
    |
    | You can specify a controller for `login` `logout` and other auth routes.
    |后台用户使用的用户认证配置
    */
    'auth' => [

        'controller' => App\Admin\Controllers\AuthController::class,

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
    |--------------------------------------------------------------------------
    | Laravel-admin upload setting
    |--------------------------------------------------------------------------
    |
    | File system configuration for form upload files and images, including
    | disk and upload path.
    | 在Form表单中的image和file类型的默认上传磁盘和目录设置，其中disk的配置会使用在
    | config/filesystem.php里面配置的一项disk
    */
    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk' => 'admin', //原内容


        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for laravel-admin builtin model & tables.
    | 安装laravel-admin之后，默认会在数据库中新建下面9张表，包括用户、菜单、角色、权限、
    | 日志和它们之间的关系表，下面的配置是标的名字和对应的模型
    |
    | 其中的`connection`配置为下面几个模型所使用的数据库连接，对应`config/database.php`
    | 中的connections里面设置的connection,
    |
    | 如果你想修改数据库里面这几个表的名字，可以在运行`admin:install`之前修改它们
    | 如果install之后想修改，那么可以手动在数据库中修改，然后再修改下面几项的值
    |
    | 如果你需要在表里面增加字段，可以自定义模型，然后替换掉下面的模型设置即可，控制器的修改
    | 也可以通过覆盖路由的方式、覆盖掉内置的路由配置
    */
    'database' => [

        // Database connection for following tables.
        'connection' => '',

        // User tables and model.
        'users_table' => 'admin_users',
        'users_model' => Encore\Admin\Auth\Database\Administrator::class,

        // Role table and model.
        'roles_table' => 'admin_roles',
        'roles_model' => Encore\Admin\Auth\Database\Role::class,

        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,

        // Menu table and model.
        'menu_table' => 'admin_menu',
        'menu_model' => Encore\Admin\Auth\Database\Menu::class,

        // Pivot table for table above.
        'operation_log_table'    => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table'       => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table'        => 'admin_role_menu',
    ],

    /*
    |--------------------------------------------------------------------------
    | User operation log setting
    |--------------------------------------------------------------------------
    |操作日志记录的配置
    | By setting this option to open or close operation log in laravel-admin.
    |
    */
    'operation_log' => [
        //是否开启日志记录、默认打开
        'enable' => true,

        /* 允许记录请求日志的HTTP方法
         * Only logging allowed methods in the list
         */
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        /*
         * Routes that will not log to database.
         *
         * All method to path like: admin/auth/logs
         * or specific method to path like: get:admin/auth/logs.
         * 不需要被记录日志的url路径
         */
        'except' => [
            'admin/auth/logs*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin map field provider
    |--------------------------------------------------------------------------
    | model-form中map组件所使用的地图配置，支持三个地图服务商: "tencent", "google", "yandex".
    | Supported: "tencent", "google", "yandex".
    |
    */
    'map_provider' => 'tencent',

    /*
    |--------------------------------------------------------------------------
    | Application Skin
    |--------------------------------------------------------------------------
    |
    | This value is the skin of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    | |皮肤设置，参考https://adminlte.io/docs/2.4/layout设置
    |
    | 支持的设置为:
    | Supported:
    |    "skin-blue", "skin-blue-light", "skin-yellow", "skin-yellow-light",
    |    "skin-green", "skin-green-light", "skin-purple", "skin-purple-light",
    |    "skin-red", "skin-red-light", "skin-black", "skin-black-light".
    |
    */
    'skin' => 'skin-black',

    /*
    |--------------------------------------------------------------------------
    | Application layout
    |--------------------------------------------------------------------------
    |
    | This value is the layout of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    |布局设置，参考https://adminlte.io/docs/2.4/layout
    |
    | 支持的设置为:
    | Supported: "fixed", "layout-boxed", "layout-top-nav", "sidebar-collapse",
    | "sidebar-mini".
    |
    */
    'layout' => ['sidebar-mini', 'sidebar-collapse'],

    /*
    |--------------------------------------------------------------------------
    | Login page background image
    |--------------------------------------------------------------------------
    |   登录页面的背景图设置
    | This value is used to set the background image of login page.
    |
    */
    'login_background_image' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1552663441889&di=d0fe9013f6c22c3f5694c5d7014ddb42&imgtype=0&src=http%3A%2F%2Fc.hiphotos.baidu.com%2Fimage%2Fpic%2Fitem%2Fa6efce1b9d16fdfa0dde2cc3ba8f8c5494ee7b69.jpg',

    /*
    |--------------------------------------------------------------------------
    | Show version at footer
    |--------------------------------------------------------------------------
    |是否在页面的右下角显示当前laravel-admin的版本
    | Whether to display the version number of laravel-admim at the footer of
    | each page
    |
    */
    'show_version' => true,

    /*
    |--------------------------------------------------------------------------
    | Show environment at footer
    |--------------------------------------------------------------------------
    |是否在页面的右下角显示当前的环境
    | Whether to display the environment at the footer of each page
    |
    */
    'show_environment' => true,

    /*
    |--------------------------------------------------------------------------
    | Menu bind to permission
    |--------------------------------------------------------------------------
    |菜单是否绑定权限
    | whether enable menu bind to a permission
    */
    'menu_bind_permission' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable default breadcrumb
    |--------------------------------------------------------------------------
    |是否开启页面的面包屑导航
    | Whether enable default breadcrumb for every page content.
    */
    'enable_default_breadcrumb' => true,

    /*
    |--------------------------------------------------------------------------
    | Extension Directory
    |--------------------------------------------------------------------------
    |如果你要运行`php artisan admin:extend`命令来开发扩展，需要配置这一项，来存放你的扩展文件
    | When you use command `php artisan admin:extend` to generate extensions,
    | the extension files will be generated in this directory.
    */
    'extension_dir' => app_path('Admin/Extensions'),

    /*
    |--------------------------------------------------------------------------
    | Settings for extensions.
    |--------------------------------------------------------------------------
    |每一个laravel-admin扩展对应的配置，都写在这下面，扩展可以参考 https://github.com/laravel-admin-extensions
    |
    | You can find all available extensions here
    | https://github.com/laravel-admin-extensions.
    |
    */
    'extensions' => [

        'chartjs' => [

            // Set to `false` if you want to disable this extension
            'enable' => false,
        ],'iframe-tabs' => [
            //后台多标签页面扩展,注意部分刷新文字没有翻译
            // Set to `false` if you want to disable this extension
            'enable' => false,
            // Default page controller
            'home_action' => App\Admin\Controllers\HomeController::class . '@index',//edit here
            // Default page uir after user login success
            'home_uri' => '/admin/dashboard',
            // Default page tab-title
            'home_title' => 'Home',
            // Default page tab-title icon
            'home_icon' => 'fa-home',
            // wheath show icon befor titles for all tab
            'use_icon' => true,
            // layer.js path , if you do not user laravel-admin-ext\cropper , set another one
            'layer_path' => '/vendor/laravel-admin-ext/cropper/layer/layer.js',
            //href links do not open in tab .
            'pass_urls' => ['/admin/auth/logout', '/admin/auth/lock'],
        ],
    ],
    //如果是从低版本更新到v1.7.3及以上的版本，还可以继续使用之前自定义的操作类，
    //但是如果要使用新版本的行操作，可以在config/admin.php添加配置全局开启：
    'grid_action_class' => \Encore\Admin\Grid\Displayers\DropdownActions::class,


];
