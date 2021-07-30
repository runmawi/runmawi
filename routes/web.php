<?php

use Illuminate\Support\Facades\Route;

Route::get('/moderator', 'ModeratorsUserController@index');
Route::post('/moderatoruser/create', 'ModeratorsUserController@store');


Route::post('/register1', 'HomeController@PostcreateStep1');
Route::get('/verify-request', 'HomeController@VerifyRequest');
Route::get('verify/{activation_code}', 'SignupController@Verify');
Route::get('/category/{cid}', 'ChannelController@channelVideos');
Route::get('/category/videos/{vid}', 'ChannelController@play_videos');
Route::get('/language/{language}', 'ChannelController@LanguageVideo');
Route::post('/saveSubscription', 'PaymentController@saveSubscription');


Route::get('/updatecard', 'PaymentController@UpdateCard');
Route::get('/my-refferals', 'PaymentController@MyRefferal');
Route::get('/nexmo', 'HomeController@nexmo')->name('nexmo');
Route::post('/nexmo', 'HomeController@verify')->name('nexmo');

Route::get('/auth/redirect/{provider}', 'GoogleLoginController@redirect');
Route::get('/callback/{provider}', 'GoogleLoginController@callback');

Route::group(['middleware' => ['restrictIp']], function() {

    Route::get('/stripe/billings-details', 'PaymentController@ViewStripe');
    Route::get('locale/{locale}', function ($locale){
        Session::put('locale', $locale);
        return redirect()->back();
    });
//custom login route 

    Route::get('/mobileLogin', 'HomeController@mobileLogin');
    Route::post('/stripesubscription', 'HomeController@stripes');
    Route::post('ckeditor/image_upload', 'AdminPageController@upload')->name('upload');
    Route::get('image/index', 'ImageController@index');

    Route::post('image/upload', 'ImageController@upload');
    Route::get('/', 'HomeController@FirstLanging');

    Route::get('/home', 'HomeController@index')->name('home');

    /*TV-shows*/
    Route::get('tv-shows', 'TvshowsController@index');
    Route::get('episode/{id}', 'TvshowsController@play_episode');
    Route::get('play_series/{id}', 'TvshowsController@play_series');


    Route::post('/sendOtp', 'HomeController@SendOTP');
    Route::post('/verifyOtp', 'HomeController@verifyOtp');  
    Route::post('/directVerify', 'SignupController@directVerify');
    Route::get('/signup', 'SignupController@createStep1')->name('signup');

    Route::get('/registerUser', 'SignupController@SaveAsRegisterUser');
    Route::get('/register2', 'SignupController@createStep2');
    Route::post('/paywithpaypal', 'SignupController@PayWithPapal');
    Route::get('/signupverify', 'HomeController@SignUpVerify');
    Route::post('/register2', 'SignupController@PostcreateStep2');
    Route::get('/register3', 'SignupController@createStep3');

    Route::post('/register3', 'SignupController@PostcreateStep3');
    Route::post('/submitpaypal', 'SignupController@submitpaypal');
    Route::post('/subscribepaypal', 'SignupController@subscribepaypal');

    Route::post('/remove-image', 'SignupController@removeImage');
    Route::post('/store', 'SignupController@store');
    Route::get('/data', 'SignupController@index');
    Route::get('stripe1', 'PaymentController@stripe');
    Route::post('stripe', 'PaymentController@stripePost')->name('stripe.post');
    Route::post('searchResult', 'HomeController@searchResult');
    Route::get('search','HomeController@search');
    Route::get('showPayperview', 'WatchLaterController@showPayperview');
    Route::post('watchlater', 'WatchLaterController@watchlater');
    Route::post('ppvWatchlater', 'WatchLaterController@ppvWatchlater');
    Route::get('/promotions', 'HomeController@promotions');
    Route::get('/page/{slug}', 'PagesController@index');
    Route::get('/paypal/billings-details', 'HomeController@ViewPaypal');
    Route::get('/paypal/transaction-details', 'HomeController@ViewTrasaction');
    Route::get('/stripe/transaction-details', 'HomeController@ViewStripeTrasaction');
    Route::get('/paypal/cancel-subscription', 'HomeController@CancelPaypal');
    Route::post('/stripe-subscription', 'HomeController@StripeSubscription');
    Route::post('/paypal_subscription', 'HomeController@PaypalSubscription');  
//Route::post('/registerSubmit', 'StripeController@PostcreddateStep1');    
});

Route::get('serieslist', array('uses' => 'ChannelController@series', 'as' => 'series') );
Route::get('series/category/{id}', 'ChannelController@series_genre' );

Route::get('watchlaters', 'WatchLaterController@show_watchlaters');
Route::get('myprofile', 'AdminUsersController@myprofile');
Route::get('refferal', 'AdminUsersController@refferal');
Route::post('/profile/update', 'AdminUsersController@profileUpdate');   
Route::get('/latest-videos', 'HomeController@LatestVideos');
Route::get('/language/{lanid}/{language}', 'HomeController@LanguageVideo');
Route::post('mywishlist', 'WishlistController@mywishlist');
Route::post('ppvWishlist', 'WishlistController@ppvWishlist');
Route::get('mywishlists', 'WishlistController@show_mywishlists');
Route::get('cancelSubscription', 'PaymentController@CancelSubscription');
Route::get('renew', 'PaymentController@RenewSubscription');
Route::post('upgradeSubscription', 'PaymentController@UpgradeSubscription');
Route::post('upgrade-stripe-plan', 'PaymentController@UpgradeStripe');
Route::post('upgrade-paypal-plan', 'PaymentController@UpgradePaypalPage');
Route::post('upgradePaypal', 'PaymentController@upgradePaypal');
Route::post('becomePaypal', 'PaymentController@BecomePaypal');
Route::get('upgrade-subscription', 'PaymentController@Upgrade');
Route::get('becomesubscriber', 'PaymentController@BecomeSubscriber');
Route::get('transactiondetails','PaymentController@TransactionDetails');

Route::get('/upgrading', 'PaymentController@upgrading');

Route::get('/channels', 'ChannelController@index');
Route::get('/ppvVideos', 'ChannelController@ppvVideos');
Route::get('/live', 'LiveStreamController@Index');
Route::get('/live/play/{id}', 'LiveStreamController@Play');
Route::post('purchase-live', 'PaymentController@StoreLive')->name('stripe.store'); 
Route::post('purchase-video', 'PaymentController@purchaseVideo');
Route::get('/ppvVideos/play_videos/{vid}', 'ChannelController@PlayPpv');
Route::get('/logout', 'AdminUsersController@logout');
Route::post('/stripe-payment', 'PaymentController@store')->name('stripe.store');
Route::post('/rentpaypal', 'PaymentController@RentPaypal');
// Route::get('stripe', 'PaymentController@index');
Route::get('myppv', 'ChannelController@Myppv');
Route::get('stripe', 'SignupController@index');
Route::post('stripe', 'SignupController@store');
Route::get('form', 'SignupController@form');
Route::get('/roles', 'PermissionController@Permission');
Route::post('mywishlist', 'WishlistController@mywishlist');
Route::get('mywishlists', 'WishlistController@show_mywishlists');
Route::get('wishlist_video/{id}', 'WishlistController@wishlist_video');
Route::get('file-upload', 'FileUploadController@index');
Route::post('file-upload/upload', 'FileUploadController@fileStore')->name('upload');
Route::group(['prefix' => 'admin','middleware' => ['auth', 'admin','restrictIp']], function() {
//,'restrictIp'
//        Route::get('/', function () {
//            return view('admin.dashboard');
//        });

    Route::get('/', 'AdminDashboardController@index');
    Route::get('/mobileapp', 'AdminUsersController@mobileapp');
    Route::post('/mobile_app/store', 'AdminUsersController@mobileappupdate');
    Route::get('/users', 'AdminUsersController@index');
    Route::get('/user/create', 'AdminUsersController@create');
    Route::post('/user/store', 'AdminUsersController@store');
    Route::get('/user/edit/{id}', 'AdminUsersController@edit');
    Route::post('/user/update', array('before' => 'demo', 'uses' => 'AdminUsersController@update'));
    Route::get('/user/delete/{id}', array('before' => 'demo', 'uses' => 'AdminUsersController@destroy'));

    Route::get('/settings', 'AdminSettingsController@index');
    Route::post('/settings/save_settings', 'AdminSettingsController@save_settings');

    Route::get('/home-settings', 'Admin\HomeSettingsController@index');
    Route::post('/home-settings/save', 'Admin\HomeSettingsController@save_settings');

    Route::get('/sliders', 'AdminThemeSettingsController@SliderIndex');
    Route::post('/sliders/store','AdminThemeSettingsController@SliderStore');
    Route::get('/sliders/edit/{id}', 'AdminThemeSettingsController@SliderEdit');
    Route::get('/sliders/delete/{id}', 'AdminThemeSettingsController@SliderDelete');
    Route::post('/sliders/update', 'AdminThemeSettingsController@SliderUpdate'); 
    Route::post('/slider_order', 'AdminThemeSettingsController@slider_order'); 

    Route::post('/mobile/sliders/store','AdminThemeSettingsController@MobileSliderStore');
    Route::get('/mobile/sliders/edit/{id}', 'AdminThemeSettingsController@MobileSliderEdit');
    Route::get('/mobile/sliders/delete/{id}', 'AdminThemeSettingsController@MobileSliderDelete');
    Route::post('/mobile/sliders/update', 'AdminThemeSettingsController@MobileSliderUpdate');  

    Route::get('/admin-languages', 'AdminThemeSettingsController@LanguageIndex');
    Route::post('/languages/store','AdminThemeSettingsController@LanguageStore');
    Route::get('/languages/edit/{id}', 'AdminThemeSettingsController@LanguageEdit');
    Route::get('/languages/delete/{id}', 'AdminThemeSettingsController@LanguageDelete');
    Route::post('/languages/update', 'AdminThemeSettingsController@LanguageUpdate'); 

    Route::get('/admin-languages-transulates', 'AdminThemeSettingsController@LanguageTransIndex');

    Route::post('/languagestrans/store','AdminThemeSettingsController@LanguageTransStore');
    Route::get('/languagestrans/edit/{id}', 'AdminThemeSettingsController@LanguageTransEdit');
    Route::get('/languagestrans/delete/{id}', 'AdminThemeSettingsController@LanguageTransDelete');
    Route::post('/languagestrans/update', 'AdminThemeSettingsController@LanguageTransUpdate');  


    Route::get('/countries', 'AdminManageCountries@Index');
    Route::post('/countries/store','AdminManageCountries@Store');
    Route::get('/countries/edit/{id}', 'AdminManageCountries@Edit');
    Route::get('/countries/delete/{id}', 'AdminManageCountries@Delete');
    Route::post('/countries/update', 'AdminManageCountries@Update');

    Route::get('/player', 'Adminplayer@Index');

    /* manage videos */

// Admin Video Functionality
    Route::post('/category_order', 'AdminVideoCategoriesController@category_order');
    Route::get('/videos', 'AdminVideosController@index');
    Route::get('/videos/categories', 'AdminVideoCategoriesController@index');
    Route::get('/videos/edit/{id}', 'AdminVideosController@edit');
    Route::post('/videos/update', array('before' => 'demo', 'uses' => 'AdminVideosController@update'));
    Route::get('/videos/delete/{id}', array('before' => 'demo', 'uses' => 'AdminVideosController@destroy'));
    Route::get('/videos/create', 'AdminVideosController@create');
    Route::post('/videos/store', array('before' => 'demo', 'uses' => 'AdminVideosController@store'));
    Route::post('/videos/categories/store', array('before' => 'demo', 'uses' => 'AdminVideoCategoriesController@store'));
    Route::post('/videos/categories/order', array('before' => 'demo', 'uses' => 'AdminVideoCategoriesController@order'));
    Route::get('/videos/categories/edit/{id}', 'AdminVideoCategoriesController@edit');
    Route::post('/videos/categories/update','AdminVideoCategoriesController@update');
    Route::get('/videos/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminVideoCategoriesController@destroy'));

// Admin PPV Functionality
    Route::get('/ppv', 'AdminPpvController@index');
    Route::get('/ppv/edit/{id}', 'AdminPpvController@edit');
    Route::post('/ppv/update','AdminPpvController@update');
    Route::get('/ppv/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPpvController@destroy'));
    Route::get('/ppv/create', 'AdminPpvController@create');
    Route::post('/ppv/store', array('before' => 'demo', 'uses' => 'AdminPpvController@store'));


// Admin PPV Functionality
    Route::get('/livestream', 'AdminLiveStreamController@index');
    Route::get('/livestream/edit/{id}', 'AdminLiveStreamController@edit');
    Route::post('/livestream/update','AdminLiveStreamController@update');
    Route::get('/livestream/delete/{id}', array('before' => 'demo', 'uses' => 'AdminLiveStreamController@destroy'));
    Route::get('/livestream/create', 'AdminLiveStreamController@create');
    Route::post('/livestream/store', array('before' => 'demo', 'uses' => 'AdminLiveStreamController@store'));




    Route::get('/ppv/categories', array('before' => 'demo', 'uses' => 'AdminPpvCategoriesController@index'));
    Route::post('/ppv/categories/store', array('before' => 'demo', 'uses' => 'AdminPpvCategoriesController@store'));
    Route::post('/ppv/categories/order', array('before' => 'demo', 'uses' => 'AdminPpvCategoriesController@order'));
    Route::get('/ppv/categories/edit/{id}', 'AdminPpvCategoriesController@edit');
    Route::post('/ppv/categories/update','AdminPpvCategoriesController@update');
    Route::get('/ppv/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPpvCategoriesController@destroy'));


    Route::get('/livestream/categories', array('before' => 'demo', 'uses' => 'AdminLiveCategoriesController@index'));
    Route::post('/livestream/categories/store', array('before' => 'demo', 'uses' => 'AdminLiveCategoriesController@store'));
    Route::post('/livestream/categories/order', array('before' => 'demo', 'uses' => 'AdminLiveCategoriesController@order'));
    Route::get('/livestream/categories/edit/{id}', 'AdminLiveCategoriesController@edit');
    Route::post('/livestream/categories/update','AdminLiveCategoriesController@update');
    Route::get('/livestream/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminLiveCategoriesController@destroy'));


    Route::get('/plans', 'AdminPlansController@index');
    Route::post('/plans/store','AdminPlansController@store');
    Route::get('/plans/edit/{id}', 'AdminPlansController@edit');
    Route::get('/plans/delete/{id}', 'AdminPlansController@delete');
    Route::post('/plans/update', 'AdminPlansController@update');


    Route::get('/paypalplans', 'AdminPlansController@PaypalIndex');
    Route::post('/paypalplans/store','AdminPlansController@PaypalStore');
    Route::get('/paypalplans/edit/{id}', 'AdminPlansController@PaypalEdit');
    Route::get('/paypalplans/delete/{id}', 'AdminPlansController@PaypalDelete');
    Route::post('/paypalplans/update', 'AdminPlansController@PaypalUpdate');

    Route::get('/coupons', 'AdminCouponManagement@index');
    Route::post('/coupons/store','AdminCouponManagement@store');
    Route::get('/coupons/edit/{id}', 'AdminCouponManagement@edit');
    Route::get('/coupons/delete/{id}', 'AdminCouponManagement@delete');
    Route::post('/coupons/update', 'AdminCouponManagement@update');


    Route::get('/pages', 'AdminPageController@index');
    Route::get('/pages/create', 'AdminPageController@create');
    Route::post('/pages/store', 'AdminPageController@store');
    Route::get('/pages/edit/{id}', 'AdminPageController@edit');
    Route::post('/pages/update', 'AdminPageController@update');
    Route::get('/pages/delete/{id}','AdminPageController@destroy');


    Route::get('/menu', 'AdminMenuController@index');
    Route::post('/menu/store', array('before' => 'demo', 'uses' => 'AdminMenuController@store'));
    Route::get('/menu/edit/{id}', 'AdminMenuController@edit');
    Route::post('/menu/update', array('before' => 'demo', 'uses' => 'AdminMenuController@update'));
    Route::post('/menu/order', array('before' => 'demo', 'uses' => 'AdminMenuController@order'));
    Route::get('/menu/delete/{id}', array('before' => 'demo', 'uses' => 'AdminMenuController@destroy'));

    /* theme settings*/

    Route::get('/theme_settings_form', 'AdminThemeSettingsController@theme_settings_form');
    Route::get('/theme_settings', 'AdminThemeSettingsController@theme_settings');
    Route::post('/theme_settings', array('before' => 'demo', 'uses' => 'AdminThemeSettingsController@update_theme_settings'));

    Route::post('/theme_settings/save','AdminThemeSettingsController@SaveTheme');


    /* payment settings */
    Route::get('/payment_settings', 'AdminPaymentSettingsController@index');
    Route::post('/payment_settings', array('before' => 'demo', 'uses' => 'AdminPaymentSettingsController@save_payment_settings'));

    /* payment settings */
    Route::get('/system_settings', 'Admin\SystemSettingController@index');
    Route::post('/system_settings', 'Admin\SystemSettingController@save');


    /* User Roles */
    Route::get('/roles', 'UserRolesController@index');
    Route::get('/roles/edit/{id}', 'UserRolesController@edit');
    Route::get('/roles/delete/{id}', 'UserRolesController@destroy');
    Route::post('/roles/store', 'UserRolesController@store');
    Route::post('/roles/update', 'UserRolesController@update'); 


    Route::get('/languages', 'LanguageTranslationController@index')->name('languages');
    Route::post('/translations/update', 'LanguageTranslationController@transUpdate')->name('translation.update.json');
    Route::post('/translations/updateKey', 'LanguageTranslationController@transUpdateKey')->name('translation.update.json.key');
    Route::get('/translations/destroy/{key}', 'LanguageTranslationController@destroy')->name('translations.destroy');
    Route::post('/translations/create', 'LanguageTranslationController@store')->name('translations.create');
    Route::get('check-translation', function(){
        \App::setLocale('fr');

        dd(__('website'));
    });


    /* User Roles */
    Route::get('/permissions', 'AdminRolePermissionController@index');
    Route::get('/permissions/edit/{id}', 'AdminRolePermissionController@edit');
    Route::get('/permissions/delete/{id}', 'AdminRolePermissionController@destroy');
    Route::post('/permissions/store', 'AdminRolePermissionController@store');
    Route::post('/permissions/update', 'AdminRolePermissionController@update');

    Route::get('/audios', 'AdminAudioController@index');
    Route::get('/audios/edit/{id}', 'AdminAudioController@edit');
    Route::post('/audios/update', array('before' => 'demo', 'uses' => 'AdminAudioController@update'));
    Route::get('/audios/delete/{id}', array('before' => 'demo', 'uses' => 'AdminAudioController@destroy'));
    Route::get('/audios/create', 'AdminAudioController@create');
    Route::post('/audios/store', array('before' => 'demo', 'uses' => 'AdminAudioController@store'));



//Admin Audio Categories
    Route::get('/audios/categories', 'AdminAudioCategoriesController@index');
    Route::post('/audios/categories/store', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@store'));
    Route::post('/audios/categories/order', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@order'));
    Route::get('/audios/categories/edit/{id}', 'AdminAudioCategoriesController@edit');
    Route::post('/audios/categories/update', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@update'));
    Route::get('/audios/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@destroy'));

//Artist Routes
    Route::get('/artists', 'AdminArtistsController@index');
    Route::get('/artists/create', 'AdminArtistsController@create');
    Route::post('/artists/store',  'AdminArtistsController@store');
    Route::get('/artists/edit/{id}', 'AdminArtistsController@edit');
    Route::post('/artists/update', 'AdminArtistsController@update');
    Route::get('/artists/delete/{id}','AdminArtistsController@destroy');



    Route::get('/series-list', 'AdminSeriesController@index');
    Route::get('/series/create', 'AdminSeriesController@create');
    Route::post('/series/store', 'AdminSeriesController@store');
    Route::get('/series/edit/{id}', 'AdminSeriesController@edit');
    Route::post('/series/update', 'AdminSeriesController@update');
    Route::get('/series/delete/{id}', 'AdminSeriesController@destroy');

//Admin Series Season Manage
    Route::get('/season/create/{id}', 'AdminSeriesController@create_season');
    Route::get('/season/edit/{series_id}/{season_id}', 'AdminSeriesController@manage_season');
    Route::get('/season/delete/{id}', 'AdminSeriesController@destroy_season');

    Route::post('/episode/create', 'AdminSeriesController@create_episode');
    Route::get('/episode/delete/{id}', 'AdminSeriesController@destroy_episode');
    Route::get('/episode/edit/{id}', 'AdminSeriesController@edit_episode');
    Route::post('/episode/update', 'AdminSeriesController@update_episode');
    Route::get('/players', 'AdminSettingsController@playerui_index');
    Route::get('/players/settings', 'AdminSettingsController@playerui_settings');   
    Route::post('/players/store', 'AdminSettingsController@storeplayerui');

});



Route::get('reset-password/{token}', 'Auth\ResetPasswordController@getPassword');
Route::get('/blocked', 'HomeController@Restrict');
Route::post('reset-password', 'Auth\ResetPasswordController@updatePassword');
Route::post('continue-watching', 'HomeController@StoreWatching');
Route::post('/like-video', 'HomeController@LikeVideo');

Route::get('/auth/redirect/{provider}', 'GoogleLoginController@redirect');
Route::get('/callback/{provider}', 'GoogleLoginController@callback');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/moderator', 'ModeratorsUserController@index');
Route::post('/moderatoruser/create', 'ModeratorsUserController@store');
