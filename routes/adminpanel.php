<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'adminpanel'
], function () {

Route::get('/videos', 'Api\AdminVideosController@index');

});