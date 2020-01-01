<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('users', UserController::class);
    $router->resource('userteam', UserTeamController::class);
    $router->resource('visit', VisitController::class);
    $router->resource('cal', CalController::class);
    $router->resource('notice', NoticeController::class);

    // $router->resource('dy-users', Dy\UserController::class);
    $router->resource('dy/tx', Dy\TxController::class);
    $router->resource('dy/news', Dy\NewsController::class);
    $router->resource('dy/config', Dy\ConfigController::class);
    $router->resource('dy/code', Dy\CodeController::class);
    $router->resource('dy/user', Dy\UserController::class);
    $router->resource('dy/task', Dy\TaskController::class);
    $router->resource('dy/tasklist', Dy\TasklistController::class);

    $router->get('Visit/VisitChart', 'VisitController@VisitChart');//图形
    $router->get('Visit/GetVisitChartData', 'VisitController@GetVisitChartData');//图形
    //
});

