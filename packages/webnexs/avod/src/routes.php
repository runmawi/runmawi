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
		Route::get('/paymentgateway/{plan_id}', 'Webnexs\Avod\AuthController@paymentgateway'); 
		Route::get('/billing_details', 'Webnexs\Avod\AuthController@billing_details'); 
		Route::get('logout', 'Webnexs\Avod\AuthController@logout');
		Route::get('forget-password', 'Webnexs\Avod\AuthController@showForgetPasswordForm')->name('forget.password.get');
		Route::post('forget-password', 'Webnexs\Avod\AuthController@submitForgetPasswordForm')->name('forget.password.post'); 
		Route::get('reset-password/{token}', 'Webnexs\Avod\AuthController@showResetPasswordForm')->name('reset.password.get');
		Route::post('reset-password', 'Webnexs\Avod\AuthController@submitResetPasswordForm')->name('reset.password.post');

	});
});