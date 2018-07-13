<?php
    /**
     * Created by PhpStorm.
     * User: tengjufeng
     * Date: 2018/7/11
     * Time: 上午11:29
     */

    use Illuminate\Support\Facades\Route;


    Route::group(['prefix' => config('admin.admin_uri')], function () {
        //登录页面
        Route::any('/login', '\App\Admin\Base\Controllers\LoginController@login')->name('login');
        Route::get('/logout', '\App\Admin\Base\Controllers\LoginController@logout');

        //通过gourd 里的admin
        Route::group(['middleware' => 'auth:admin'], function () {
            //首页
            Route::get('/', '\App\Admin\Base\Controllers\IndexController@index');
        });

        //权限管理模块
        Route::group(['middleware' => 'auth:admin'], function () {
            //系统管理模块
            Route::group(['middleware' => 'can:system'], function () {
                //    Route::group(['middleware'=>'auth:admin'],function (){
                //管理人员模块
                Route::get('managers', '\App\Admin\Base\Controllers\ManagerController@managers');
                //添加管理人员
                Route::any('managers/add', '\App\Admin\Base\Controllers\ManagerController@add');
                //编辑管理人员
                Route::any('managers/{manager}/edit', '\App\Admin\Base\Controllers\ManagerController@edit');
                //删除管理人员
                Route::get('managers/{manager}/delete', '\App\Admin\Base\Controllers\ManagerController@delete');

                /*******角色相关**********/
                //角色列表页
                Route::get('/roles', '\App\Admin\Base\Controllers\RolesController@roles');
                //角色创建页面
                Route::post('/roles/add', '\App\Admin\Base\Controllers\RolesController@add');
                //角色和用户的关联页面
                Route::any('/managers/{manager}/role', '\App\Admin\Base\Controllers\ManagerController@role');
                //角色和权限的关联页面
                Route::any('/roles/{role}/permission', '\App\Admin\Base\Controllers\RolesController@permission');
                //删除角色
                Route::get('/roles/{role}/delete', '\App\Admin\Base\Controllers\RolesController@delete');
                /********权限模块**********/
                //权限列表页
                Route::get('permissions', '\App\Admin\Base\Controllers\PermissionController@permissions');
                //增加权限列表页
                Route::any('permissions/add', '\App\Admin\Base\Controllers\PermissionController@add');
                Route::any('permissions/{permission}/menu', '\App\Admin\Base\Controllers\PermissionController@menu');
                //删除权限
                Route::get('permissions/{permission}/delete', '\App\Admin\Base\Controllers\PermissionController@delete');

                /********菜单**********/
                Route::get('menus', '\App\Admin\Base\Controllers\MenuController@menus');
                Route::post('menus/add', '\App\Admin\Base\Controllers\MenuController@add');
                Route::get('menus/{menu}/delete', '\App\Admin\Base\Controllers\MenuController@delete');

                //addroute

            });
            include_once 'banbenku/banbenku.php';
        });

    });