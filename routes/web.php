<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => '\App\Http\Controllers'], function () {

    Route::get('/', 'AuthController@login')->name('login');
    Route::post('/', 'AuthController@doLogin')->name('do-login');

});

Route::group(['middleware' => 'auth:web'], function () {

    Route::get('/admin/', '\App\Http\Controllers\Admin\AdminController@home')->name('home');
    Route::view('/admin/history', 'admin.history')->name('history');
    Route::post('/admin/logout', '\App\Http\Controllers\AuthController@logout')->name('logout');

    Route::post('/admin/recent-ops-ajax', '\App\Http\Controllers\Admin\AdminController@recentOpsAjax')->name('recent-ops-ajax');
    Route::get('/admin/history-ajax', '\App\Http\Controllers\Admin\AdminController@historyAjax')->name('history-ajax');

});
