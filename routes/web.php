<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Support\GValue;


function commonRoute($type, $module, $controller, $action = 'index'){
    $controller = 'App\Http\Controllers\\' . ucfirst($module) . '\\' . ucfirst($controller) . 'Controller';
    $instance = App::make($controller);
    GValue::$ajax = 'ajax' === $type ? true : false;
    GValue::$controller = $controller;
    GValue::$action = $action;
    App::call([$instance, 'init']);
    if(!method_exists($instance, $action)){
        abort(404);
    }
    return App::call([$instance, $action]);
}

Route::group(['prefix' => 'ajax'], function(){
    Route::get('/{module}/{controller}/{action?}', function($module, $controller, $action = 'index'){
        return commonRoute('ajax', $module, $controller, 'get' . ucfirst($action));
    });
    Route::post('/{module}/{controller}/{action?}', function($module, $controller, $action = 'index'){
        return commonRoute('ajax', $module, $controller, 'post'.ucfirst($action));
    });
});

Route::group(['prefix' => 'page'], function(){
    Route::get('/{module}/{controller}/{action?}', function($module, $controller, $action = 'index'){
        return commonRoute('page', $module, $controller, 'get' . ucfirst($action));
    });
    Route::post('/{module}/{controller}/{action?}', function($module, $controller, $action = 'index'){
        return commonRoute('page', $module, $controller, 'post'.ucfirst($action));
    });
});



Route::get('testgetmenu', 'Auth\UserController@getMenu');