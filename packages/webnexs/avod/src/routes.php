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
		Route::get('/upload_ads', 'Webnexs\Avod\AuthController@upload_ads')->name('upload_ads'); 
		Route::post('/store_ads', 'Webnexs\Avod\AuthController@store_ads'); 
		Route::get('/paymentgateway/{plan_id}', 'Webnexs\Avod\AuthController@paymentgateway'); 
		Route::get('/billing_details', 'Webnexs\Avod\AuthController@billing_details'); 
		Route::get('/featured_ad_history', 'Webnexs\Avod\AuthController@featured_ad_history'); 
		Route::get('logout', 'Webnexs\Avod\AuthController@logout')->name('ads_logout');
		Route::get('forget-password', 'Webnexs\Avod\AuthController@showForgetPasswordForm')->name('forget.password.get');
		Route::post('forget-password', 'Webnexs\Avod\AuthController@submitForgetPasswordForm')->name('forget.password.post'); 
		Route::get('reset-password/{token}', 'Webnexs\Avod\AuthController@showResetPasswordForm')->name('reset.password.get');
		Route::post('reset-password', 'Webnexs\Avod\AuthController@submitResetPasswordForm')->name('reset.password.post');
		Route::get('featured_ads', 'Webnexs\Avod\AuthController@FeaturedAds')->name('featured_ads');
		Route::get('upload_featured_ad', 'Webnexs\Avod\AuthController@UploadFeaturedAd')->name('upload_featured_ad');
		Route::post('/storefeatured_ad', 'Webnexs\Avod\AuthController@storefeatured_ad'); 
		Route::post('/buyfeaturedad_stripe', 'Webnexs\Avod\AuthController@buyfeaturedad_stripe')->name('buyfeaturedad_stripe'); 
		Route::post('/buyrz_ad', 'Webnexs\Avod\AuthController@buyrz_ad')->name('buyrz_ad'); 
		Route::get('ads_campaign', 'Webnexs\Avod\AuthController@ads_campaign')->name('ads_campaign');
		Route::post('/buyrz_adcampaign', 'Webnexs\Avod\AuthController@buyrz_adcampaign')->name('buyrz_adcampaign'); 
		Route::post('/buycampaign_stripe', 'Webnexs\Avod\AuthController@buycampaign_stripe')->name('buycampaign_stripe'); 
		
		Route::get('/Ads_Scheduled', 'Webnexs\Avod\AuthController@Ads_Scheduled')->name('Ads_Scheduled');
		Route::post('AdsScheduleStore', 'Webnexs\Avod\AuthController@AdsScheduleStore')->name('AdsScheduleStore'); 
		Route::get('Ads-Events', 'Webnexs\Avod\AuthController@AdsEvents')->name('AdsEvents'); 

		Route::get('/ads-list', 'Webnexs\Avod\AuthController@ads_list')->name('ads-list'); 
		Route::get('Ads-videos', 'Webnexs\Avod\AuthController@Ads-videos'); 
		Route::get('Ads-edit/{Ads_id}', 'Webnexs\Avod\AuthController@Ads_edit')->name('Ads_edit'); 
		Route::PATCH('Ads-update/{Ads_id}', 'Webnexs\Avod\AuthController@Ads_update')->name('Ads_update'); 
		Route::get('Ads-delete/{Ads_id}', 'Webnexs\Avod\AuthController@Ads_delete')->name('Ads_delete');

		Route::get('/Cost-Per-View-Analysis', 'Webnexs\Avod\AuthController@Cost_Per_View_Analysis')->name('Advertisement.Cost_Per_View_Analysis'); 
		Route::get('/Cost-Per-Click-Analysis', 'Webnexs\Avod\AuthController@Cost_Per_Click_Analysis')->name('Advertisement.Cost_Per_Click_Analysis'); 
		Route::get('/Specific-Ads-Cost-Per-Click-Analysis/{Ads_id}', 'Webnexs\Avod\AuthController@Specific_Ads_Cost_Per_Click_Analysis')->name('Advertisement.Specific_Ads_Cost_Per_Click_Analysis'); 
		Route::get('/Specific-Ads-Cost-Per-View-Analysis/{Ads_id}', 'Webnexs\Avod\AuthController@Specific_Ads_Cost_Per_View_Analysis')->name('Advertisement.Specific_Ads_Cost_Per_View_Analysis'); 

		// Payment Setting

		Route::get('/payment', 'Webnexs\Avod\PaymentController@Payment_details')->name('Advertisement.Payment_details'); 
		Route::get('/transaction-details', 'Webnexs\Avod\PaymentController@transaction_details')->name('Advertisement.transaction_details'); 

		// Stripe Payment Setting

		Route::post('Stripe_authorization_url', 'Webnexs\Avod\StripePaymentController@Stripe_authorization_url')->name('Advertisement.Stripe_authorization_url');
		Route::get('Stripe_payment_success', 'Webnexs\Avod\StripePaymentController@Stripe_payment_success')->name('Advertisement.Stripe_payment_success');

	});
});