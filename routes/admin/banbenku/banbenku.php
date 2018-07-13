<?php
    /**
     * Created by PhpStorm.
     * User: tengjufeng
     * Date: 2018/7/13
     * Time: 下午5:52
     */
    use Illuminate\Support\Facades\Route;

    Route::group(['middleware' => 'can:banbenku'], function () {
        //Route::group(['middleware'=>'auth:admin'],function (){
        //管理人员模块
        Route::get('banbenkus', '\App\Admin\Banbenku\BanbenController@banbenkus');
    });