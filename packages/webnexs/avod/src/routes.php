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
		Route::get('/featured_ad_history', 'Webnexs\Avod\AuthController@featured_ad_history'); 
		Route::get('logout', 'Webnexs\Avod\AuthController@logout');
		Route::get('forget-password', 'Webnexs\Avod\AuthController@showForgetPasswordForm')->name('forget.password.get');
		Route::post('forget-password', 'Webnexs\Avod\AuthController@submitForgetPasswordForm')->name('forget.password.post'); 
		Route::get('reset-password/{token}', 'Webnexs\Avod\AuthController@showResetPasswordForm')->name('reset.password.get');
		Route::post('reset-password', 'Webnexs\Avod\AuthController@submitResetPasswordForm')->name('reset.password.post');
		Route::get('featured_ads', 'Webnexs\Avod\AuthController@FeaturedAds')->name('featured_ads');
		Route::get('upload_featured_ad', 'Webnexs\Avod\AuthController@UploadFeaturedAd')->name('upload_featured_ad');
		Route::post('/storefeatured_ad', 'Webnexs\Avod\AuthController@storefeatured_ad'); 
		Route::post('/buyfeaturedad_stripe', 'Webnexs\Avod\AuthController@buyfeaturedad_stripe')->name('buyfeaturedad_stripe'); 
		Route::post('/buyrz_ad', 'Webnexs\Avod\AuthController@buyrz_ad')->name('buyrz_ad'); 
		Route::get('/list_total_cpc', 'Webnexs\Avod\AuthController@list_total_cpc'); 
		Route::get('/list_total_cpv', 'Webnexs\Avod\AuthController@list_total_cpv'); 
		Route::get('ads_campaign', 'Webnexs\Avod\AuthController@ads_campaign')->name('ads_campaign');
		
		Route::post('/buyrz_adcampaign', 'Webnexs\Avod\AuthController@buyrz_adcampaign')->name('buyrz_adcampaign'); 
		Route::post('/buycampaign_stripe', 'Webnexs\Avod\AuthController@buycampaign_stripe')->name('buycampaign_stripe'); 
		
		Route::get('/AdsList', 'Webnexs\Avod\AuthController@AdsList')->name('AdsList'); 
	});
});