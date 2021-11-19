<?php
Route::group(['middleware' => ['web']], function () {
	Route::auth();
	Route::prefix('advertiser')->group(function(){
		Route::get('login', 'Webnexs\Avod\AuthController@index');
		Route::post('post-login', 'Webnexs\Avod\AuthController@postLogin'); 
		Route::get('register', 'Webnexs\Avod\AuthController@register');
		Route::post('post-register', 'Webnexs\Avod\AuthController@postRegister'); 
		Route::get('/', 'Webnexs\Avod\AuthController@dashboard'); 
		Route::post('/buyplan', 'Webnexs\Avod\AuthController@buyplan')->name('buyplan'); 
		Route::post('/buyplanrazorpay', 'Webnexs\Avod\AuthController@buyplanrazorpay')->name('buyplanrazorpay'); 
		Route::get('/plan_history', 'Webnexs\Avod\AuthController@plan_history'); 
		Route::get('/upload_ads', 'Webnexs\Avod\AuthController@upload_ads'); 
		Route::get('/ads-list', 'Webnexs\Avod\AuthController@ads_list'); 
		Route::post('/store_ads', 'Webnexs\Avod\AuthController@store_ads'); 
		Route::post('/paymentgateway', 'Webnexs\Avod\AuthController@paymentgateway'); 
		Route::get('logout', 'Webnexs\Avod\AuthController@logout');

	});
});