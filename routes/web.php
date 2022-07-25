<?php


use Illuminate\Support\Facades\Route;
use App\Http\Middleware\cpp;
use App\Http\Middleware\Channel;
use Carbon\Carbon as Carbon;


Route::group(['prefix' => '/admin/filemanager', 'middleware' => ['web', 'auth']], function (){
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
    
Route::get('/moderator', 'ModeratorsUserController@index');
Route::post('/moderatoruser/create', 'ModeratorsUserController@store');
Route::post('/Dashboard_Revenue', 'ModeratorsUserController@Dashboard_Revenue');
Route::post('/upgadeSubscription', 'PaymentController@UpgadeSubscription');
Route::get('/admin/plan_purchase/{plan_slug}', 'AdminDashboardController@PlanPurchase');
Route::get('/admin/flicknexs', 'AdminDashboardController@AdminFlicknexs');
Route::get('/admin/upgrade/{plan_slug}', 'AdminDashboardController@AdminFlicknexsMonthly');
Route::get('/admin/yearly/upgrade/{plan_slug}', 'AdminDashboardController@AdminFlicknexsYearly');


Route::get('/contact-us/', 'ContactController@index');
Route::post('/contact-us/store/', 'ContactController@Store');
Route::get('admin/contact-us/', 'ContactController@ViewRequest');

Route::get('add-to-log', 'HomeController@myTestAddToLog');
Route::get('admin/logActivity', 'HomeController@logActivity');


// Route::get('/admin/filemanager', 'FileManagerController@index');

//////////// User analytics
Route::post('/admin/exportCsv', 'AdminUsersController@exportCsv');
Route::post('/admin/start_date_url', 'AdminUsersController@StartDateRecord');
Route::post('/admin/end_date_url', 'AdminUsersController@StartEndDateRecord');
Route::post('/admin/list_users_url', 'AdminUsersController@ListUsers');



//////////// User Revenue analytics
Route::get('/admin/users/revenue', 'AdminUsersController@UserRevenue');
Route::get('/admin/users/PayPerview_Revenue', 'AdminUsersController@PayPerviewRevenue');

Route::post('/admin/User_exportCsv', 'AdminUsersController@RevenueExportCsv');

Route::post('/admin/subscriber_start_date_url', 'AdminUsersController@SubscriberRevenueStartDateRecord');
Route::post('/admin/subscriber_end_date_url', 'AdminUsersController@SubscriberRevenueStartEndDateRecord');
Route::post('/admin/UserSubscriber_exportCsv', 'AdminUsersController@UserSubscriberExportCsv');



Route::post('/admin/payperview_start_date_url', 'AdminUsersController@PayPerviewRevenueStartDateRecord');
Route::post('/admin/payperview_end_date_url', 'AdminUsersController@PayPerviewRevenueStartEndDateRecord');
Route::post('/admin/payperview_exportCsv', 'AdminUsersController@PayPerviewRevenueExportCsv');


////// CPP revenue

Route::get('admin/cpp/analytics', 'ModeratorsUserController@Analytics');
Route::get('admin/cpp/revenue', 'ModeratorsUserController@Revenue');
Route::post('/admin/cpp_startdate_revenue', 'ModeratorsUserController@CPPStartDateRevenue');
Route::post('/admin/cpp_enddate_revenue', 'ModeratorsUserController@CPPEndDateRevenue');
Route::post('/admin/cpp_exportCsv', 'ModeratorsUserController@CPPExportCsv');




////// CPP Video Analytics

Route::get('admin/cpp/video-analytics', 'ModeratorsUserController@VideoAnalytics');
Route::post('/admin/cpp_video_startdate_analytics', 'ModeratorsUserController@CPPVideoStartDateAnalytics');
Route::post('/admin/cpp_video_enddate_analytics', 'ModeratorsUserController@CPPVideoEndDateAnalytics');
Route::post('/admin/cpp_video_exportCsv', 'ModeratorsUserController@CPPVideoExportCsv');


Route::post('/admin/cpp_startdate_analytics', 'ModeratorsUserController@CPPStartDateAnalytic');
Route::post('/admin/cpp_enddate_analytics', 'ModeratorsUserController@CPPEndDateAnalytic');
Route::post('/admin/cpp_analytics_exportCsv', 'ModeratorsUserController@CPPAnalyticExportCsv');
Route::post('/admin/cpp_analytics_barchart', 'ModeratorsUserController@CPPAnalyticBarchart');




Route::post('/register1', 'HomeController@PostcreateStep1');
Route::get('/verify-request', 'HomeController@VerifyRequest');
Route::get('verify/{activation_code}', 'SignupController@Verify');
Route::get('/category/{cid}', 'ChannelController@channelVideos');
Route::get('/category/videos/{vid}', 'ChannelController@play_videos');
Route::get('/category/videos/embed/{vid}', 'ChannelController@Embed_play_videos');
Route::get('/language/{language}', 'ChannelController@LanguageVideo');
Route::post('/saveSubscription', 'PaymentController@saveSubscription');
Route::get('/category/wishlist/{slug}', 'ChannelController@Watchlist');
Route::post('favorite', 'ThemeAudioController@add_favorite');
Route::post('albumfavorite', 'ThemeAudioController@albumfavorite');
Route::get('/live/category/{cid}', 'LiveStreamController@channelVideos');


Route::get('/updatecard', 'PaymentController@UpdateCard');
Route::get('/my-refferals', 'PaymentController@MyRefferal');
Route::get('/nexmo', 'HomeController@nexmo')->name('nexmo');
Route::post('/nexmo', 'HomeController@verify')->name('nexmo');

Route::get('/auth/redirect/{provider}', 'GoogleLoginController@redirect');
Route::get('/callback/{provider}', 'GoogleLoginController@callback');

Route::group(['middleware' => ['restrictIp']], function() {

Route::get('/stripe/billings-details', 'PaymentController@BecomeSubscriber');
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

    Route::get('choose-profile', 'HomeController@Multipleprofile');
    Route::get('subuser/{id}', 'HomeController@subuser')->name('subuser');
    Route::get('kidsMode', 'HomeController@kidsMode')->name('kidsMode');
    Route::get('FamilyMode', 'HomeController@FamilyMode')->name('FamilyMode');
    Route::get('kidsModeOff', 'HomeController@kidsModeOff')->name('kidsModeOff');
    Route::get('FamilyModeOff', 'HomeController@FamilyModeOff')->name('FamilyModeOff');
    Route::post('theme-mode', 'HomeController@ThemeModeSave');

    // Reels 

    Route::get('/reels', 'AdminReelsVideo@index');


    Route::get('/home', 'HomeController@index')->name('home');

    /*TV-shows */ 
    Route::get('tv-shows', 'TvshowsController@index');
    Route::get('episode/{series_name}/{episode_name}', 'TvshowsController@play_episode');
    Route::get('episode/{episode_name}', 'TvshowsController@PlayEpisode');
    // Route::get('episode/{series_name}/{episode_name}/{id}', 'TvshowsController@play_episode');

    Route::get('play_series/{name}/', 'TvshowsController@play_series');
    // Route::get('play_series/{name}/{id}', 'TvshowsController@play_series');


    /* Audio Pages */
    Route::get('audios', 'ThemeAudioController@audios');
    //Route::get('audios/category/{slug}', 'ThemeAudioController@category' );
    Route::get('artist/{slug}', 'ThemeAudioController@artist' );

    Route::post('artist/following', 'ThemeAudioController@ArtistFollow' );
    //Route::get('audios/tag/{tag}', 'ThemeAudioController@tag' );
    //Route::get('audio/{slug}/{name}', 'ThemeAudioController@index');
    Route::get('audio/{slug}', 'ThemeAudioController@index');
    //Route::get('audios_category/{audio_id}', 'ThemeAudioController@categoryaudios');
    Route::get('album/{album_slug}', 'ThemeAudioController@album');

        
    Route::post('/sendOtp', 'HomeController@SendOTP');
    Route::post('/verifyOtp', 'HomeController@verifyOtp');  
    Route::post('/directVerify', 'SignupController@directVerify');
    Route::get('/signup', 'SignupController@createStep1')->name('signup');
    Route::post('/SignupMobile_val', 'SignupController@SignupMobile_val')->name('SignupMobile_val');

    

    Route::get('/registerUser', 'SignupController@SaveAsRegisterUser');
    Route::get('/register2', 'SignupController@createStep2');
    Route::post('/paywithpaypal', 'SignupController@PayWithPapal');
    Route::get('/signupverify', 'HomeController@SignUpVerify');
    // Route::post('/cardstep', 'SignupController@PostcardcreateStep2');
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
    Route::get('purchased-media', 'WatchLaterController@showPayperview');
    Route::post('addwatchlater', 'WatchLaterController@watchlater');
    Route::post('ppvWatchlater', 'WatchLaterController@ppvWatchlater');
    Route::get('/promotions', 'HomeController@promotions');
    Route::get('/page/{slug}', 'PagesController@index');
    Route::get('/paypal/billings-details', 'HomeController@ViewPaypal');
    Route::get('/paypal/transaction-details', 'HomeController@ViewTrasaction');
    Route::get('/stripe/transaction-details', 'HomeController@ViewStripeTrasaction');
    Route::get('/paypal/cancel-subscription', 'HomeController@CancelPaypal');
    Route::post('/subscribe-now', 'HomeController@StripeSubscription');

    Route::post('/paypal_subscription', 'HomeController@PaypalSubscription');  
//Route::post('/registerSubmit', 'StripeController@PostcreddateStep1');   

// Episode watchlater and wishlist

    Route::get('episode_watchlist', 'WatchLaterController@episode_watchlist');
    Route::get('episode_watchlist_remove', 'WatchLaterController@episode_watchlist_remove');

    Route::get('episode_wishlist', 'WishlistController@episode_wishlist');
    Route::get('episode_wishlist_remove', 'WishlistController@episode_wishlist_remove');

// Become subscriber - single page
    Route::get('become_subscriber', 'PaymentController@become_subscriber');

});


Route::get('serieslist', array('uses' => 'ChannelController@series', 'as' => 'series') );
Route::get('series/category/{id}', 'ChannelController@series_genre' );
Route::get('watchlater', 'WatchLaterController@show_watchlaters');
Route::get('myprofile', 'AdminUsersController@myprofile');
Route::get('refferal', 'AdminUsersController@refferal');
Route::post('/profile/update', 'AdminUsersController@profileUpdate');   
Route::get('/latest-videos', 'HomeController@LatestVideos');
Route::get('/language/{lanid}/{language}', 'HomeController@LanguageVideo');
Route::get('featured-videos', 'HomeController@Featured_videos');
Route::post('mywishlist', 'WishlistController@mywishlist');
Route::post('ppvWishlist', 'WishlistController@ppvWishlist');
Route::get('mywishlists', 'WishlistController@show_mywishlists');
Route::get('cancelSubscription', 'PaymentController@CancelSubscription');
Route::get('renew', 'PaymentController@RenewSubscription');
// Route::post('upgradeSubscription', 'PaymentController@UpgradeSubscription');
// Route::post('Upgrade_Subscription', 'PaymentController@Upgrade_Subscription');
// Route::post('upgrade-stripe-plan', 'PaymentController@UpgradeStripe');
// Route::post('upgrade-paypal-plan', 'PaymentController@UpgradePaypalPage');
// Route::post('upgradePaypal', 'PaymentController@upgradePaypal');
// Route::post('becomePaypal', 'PaymentController@BecomePaypal');
// Route::get('upgrade-subscription', 'PaymentController@Upgrade');
Route::post('upgradeSubscription', 'PaymentController@UpgradeSubscription');
Route::post('upgrade-stripe-plan', 'PaymentController@UpgradeStripe');
Route::post('upgrade-paypal-plan', 'PaymentController@UpgradePaypalPage');
Route::post('upgradePaypal', 'PaymentController@upgradePaypal');
Route::post('becomePaypal', 'PaymentController@BecomePaypal');
Route::get('upgrade-subscription', 'PaymentController@Upgrade');


Route::get('upgrade-subscription_plan', 'PaymentController@Upgrade_Plan');
Route::get('becomesubscriber', 'PaymentController@BecomeSubscriber');
Route::get('transactiondetails','PaymentController@TransactionDetails');

Route::get('/upgrading', 'PaymentController@upgrading');

Route::get('/channels', 'ChannelController@index');
Route::get('/ppvVideos', 'ChannelController@ppvVideos');
Route::get('/live', 'LiveStreamController@Index');
// Route::get('/live/{play}/{id}', 'LiveStreamController@Play');
Route::get('/live/{id}', 'LiveStreamController@Play');

Route::post('purchase-live', 'PaymentController@StoreLive')->name('stripe.store'); 
Route::post('purchase-video', 'PaymentController@purchaseVideo');
Route::post('purchase-videocount', 'AdminVideosController@purchaseVideocount');
Route::post('player_analytics_create', 'AdminPlayerAnalyticsController@PlayerAnalyticsCreate');
Route::post('player_analytics_store', 'AdminPlayerAnalyticsController@PlayerAnalyticsStore');
Route::post('purchase-episode', 'PaymentController@purchaseEpisode');
Route::post('purchase-series', 'PaymentController@purchaseSeries');
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
Route::post('LiveWishlist', 'WishlistController@LiveWishlist');
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
    Route::get('/mobile_app/Splash_destroy/{id}', 'AdminUsersController@Splash_destroy')->name('Splash_destroy');
    Route::get('/mobile_app/Splash_edit/{id}', 'AdminUsersController@Splash_edit')->name('Splash_edit');
    Route::post('/mobile_app/Splash_update/{id}', 'AdminUsersController@Splash_update')->name('Splash_update');
    Route::get('/users', 'AdminUsersController@index');
    Route::get('/user/create', 'AdminUsersController@create');
    Route::post('/user/store', 'AdminUsersController@store');
    Route::get('/user/edit/{id}', 'AdminUsersController@edit');
    Route::post('/user/update', array('before' => 'demo', 'uses' => 'AdminUsersController@update'));
    Route::get('/user/delete/{id}', array('before' => 'demo', 'uses' => 'AdminUsersController@destroy'));
    Route::post('/export', 'AdminUsersController@export');
    Route::get('/user/view/{id}',  'AdminUsersController@view');
    Route::post('/profile/update', 'AdminUsersController@myprofileupdate');
    Route::post('/profileupdate', 'AdminUsersController@ProfileImage');
    Route::post('/profilePreference', 'AdminUsersController@profilePreference');

    Route::get('/settings', 'AdminSettingsController@index');
    Route::post('/settings/save_settings', 'AdminSettingsController@save_settings');
    Route::post('/settings/script_settings', 'AdminSettingsController@script_settings');


    Route::get('/home-settings', 'Admin\HomeSettingsController@index');
    Route::post('/home-settings/save', 'Admin\HomeSettingsController@save_settings');
    Route::post('/mobile-home-settings/save', 'Admin\HomeSettingsController@mobilesave_settings');


    Route::get('/order-home-settings', 'Admin\HomeSettingsController@Orderindex');
    Route::get('/order-home-settings/order_save', 'Admin\HomeSettingsController@Ordersave_settings');
    Route::get('/order_homepage/order_save', 'Admin\HomeSettingsController@Ordersave_settings');
    Route::get('/order_homepage/edit/{id}', 'Admin\HomeSettingsController@OrderEdit_settings');
    Route::get('/order_homepage/delete/{id}', 'Admin\HomeSettingsController@OrderDelete_settings');
    Route::post('/order_homepage/update', 'Admin\HomeSettingsController@OrderUpdate_settings');
    Route::post('/order_homepage/update_setting', 'Admin\HomeSettingsController@OrderUpdate');






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


    Route::get('/get_processed_percentage/{id}', 'AdminVideosController@get_processed_percentage');

    /* manage videos */

// Admin Video Functionality
    Route::post('/category_order', 'AdminVideoCategoriesController@category_order');
    Route::get('/videos', 'AdminVideosController@index');
    Route::get('/videos/categories', 'AdminVideoCategoriesController@index');
    Route::get('/videos/edit/{id}', 'AdminVideosController@edit'); 
    Route::get('/videos/editvideo/{id}', 'AdminVideosController@editvideo'); 
    Route::post('/videos/update', array('before' => 'demo', 'uses' => 'AdminVideosController@update'));
    Route::get('/videos/delete/{id}', array('before' => 'demo', 'uses' => 'AdminVideosController@destroy'));
    Route::get('/videos/create', 'AdminVideosController@create');
    Route::post('/videos/fileupdate', array('before' => 'demo', 'uses' => 'AdminVideosController@fileupdate'));
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

    Route::get('/subscription-plans', 'AdminPlansController@subscriptionindex');
    Route::post('/subscription-plans/store','AdminPlansController@subscriptionstore');
    Route::get('/subscription-plans/edit/{id}', 'AdminPlansController@subscriptionedit');
    Route::get('/subscription-plans/delete/{id}', 'AdminPlansController@subscriptiondelete');
    Route::post('/subscription-plans/update', 'AdminPlansController@subscriptionupdate');



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
    Route::post('menu/update-order','AdminMenuController@updateOrder'); 
    Route::get('/menu/delete/{id}', array('before' => 'demo', 'uses' => 'AdminMenuController@destroy'));

    /* theme settings*/

    Route::get('/theme_settings_form', 'AdminThemeSettingsController@theme_settings_form');
    Route::get('/theme_settings', 'AdminThemeSettingsController@theme_settings');

    Route::post('/theme_settings', array('before' => 'demo', 'uses' => 'AdminThemeSettingsController@update_theme_settings'));

    Route::post('/theme_settings/save','AdminThemeSettingsController@SaveTheme');


    Route::get('/linking_settings', 'AdminSettingsController@LinkingIndex');
    Route::post('/linking/store', 'AdminSettingsController@LinkingSave');

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

    /* Master List */
    Route::get('/Masterlist', 'AdminDashboardController@Masterlist'); 
    Route::get('/ActiveSlider', 'AdminDashboardController@ActiveSlider'); 
    Route::post('/ActiveSlider_update', 'AdminDashboardController@ActiveSlider_update'); 

    // Active and De-Active slider Video
    Route::post('/video_slider_update', 'AdminVideosController@video_slider_update'); 
    Route::post('/video_slug_validate', 'AdminVideosController@video_slug_validate'); 

    // slider for live stream in index
    Route::post('/livevideo_slider_update', 'AdminLiveStreamController@livevideo_slider_update');
    
    // slider - series & Episode
    Route::post('/series_slider_update', 'AdminSeriesController@series_slider_update'); 
    Route::post('/episode_slider_update', 'AdminSeriesController@episode_slider_update'); 


    /* Thumbnail Setting */
    Route::get('/ThumbnailSetting', 'AdminSettingsController@ThumbnailSetting')->name('ThumbnailSetting'); 
    Route::post('/ThumbnailSetting_Store', 'AdminSettingsController@ThumbnailSetting_Store'); 

    // Footer Link
    Route::get('/footer_menu', 'AdminSettingsController@footer_link')->name('footer_link'); 
    Route::post('/footer_link_store', 'AdminSettingsController@footer_link_store'); 
    Route::post('/footer_order_update', 'AdminSettingsController@footer_order_update'); 
    Route::get('/footer_delete/{id}', 'AdminSettingsController@footer_delete'); 
    Route::get('/footer_menu_edit/{id}', 'AdminSettingsController@footer_edit'); 
    Route::post('/footer_update', 'AdminSettingsController@footer_update'); 


    //Select video delete
    Route::get('/VideoBulk_delete', 'AdminVideosController@VideoBulk_delete')->name('VideoBulk_delete'); 

    // Multi-user Limit
    Route::get('/MultiUser-limit', 'AdminSettingsController@multiuser_limit')->name('multiuser_limit'); 
    Route::post('/Multi_limit_store', 'AdminSettingsController@Multi_limit_store')->name('Multi_limit_store'); 

    // Theme Integration 
    Route::get('ThemeIntegration', 'ThemeIntegrationController@index')->name('ThemeIntegration');

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
    Route::get('/artist_slug_validation','AdminArtistsController@artist_slug_validation');
    Route::post('/audios/audioupdate', array('before' => 'demo', 'uses' => 'AdminAudioController@audioupdate'));

//Admin Audio Albums
        Route::get('/audios/albums', 'AdminAudioCategoriesController@albumIndex');
        Route::post('/audios/albums/store', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@storeAlbum'));
        Route::post('/audios/albums/order', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@orderAlbum'));
        Route::get('/audios/albums/edit/{id}', 'AdminAudioCategoriesController@editAlbum');
        Route::post('/audios/albums/update', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@updateAlbum'));
        Route::get('/audios/albums/delete/{id}', array('before' => 'demo', 'uses' => 'AdminAudioCategoriesController@destroyAlbum'));

    Route::get('/series-list', 'AdminSeriesController@index');
    Route::get('/series/create', 'AdminSeriesController@create');
    Route::post('/series/store', 'AdminSeriesController@store');
    Route::get('/series/edit/{id}', 'AdminSeriesController@edit');
    Route::post('/series/update', 'AdminSeriesController@update');
    Route::get('/series/delete/{id}', 'AdminSeriesController@destroy');
    Route::get('/titlevalidation', 'AdminSeriesController@TitleValidation');
    Route::post('/episode_order', 'AdminSeriesController@episode_order');

// Admin Series Genre
    Route::get('/Series/Genre', 'AdminSeriesGenreController@index');
    Route::Post('/Series_genre_store', 'AdminSeriesGenreController@Series_genre_store');
    Route::get('/Series_genre/edit/{id}', 'AdminSeriesGenreController@Series_genre_edit');
    Route::post('/Series_genre/update', 'AdminSeriesGenreController@Series_genre_update');
    Route::get('/Series_genre/delete/{id}', 'AdminSeriesGenreController@Series_genre_delete');
    Route::Post('/Series_genre_order', 'AdminSeriesGenreController@Series_genre_order');
    
    
//Admin Series Season Manage
    // Route::get('/season/create/{id}', 'AdminSeriesController@create_season');
    Route::post('/season/create/', 'AdminSeriesController@create_season');
    Route::get('/season/edit/{series_id}/{season_id}', 'AdminSeriesController@manage_season');
    Route::get('/season/edit/{season_id}', 'AdminSeriesController@Edit_season');
    Route::post('/season/update', 'AdminSeriesController@Update_season');
    Route::get('/season/delete/{id}', 'AdminSeriesController@destroy_season');

    Route::post('/episode/create', 'AdminSeriesController@create_episode');
    Route::get('/episode/delete/{id}', 'AdminSeriesController@destroy_episode');
    Route::get('/episode/edit/{id}', 'AdminSeriesController@edit_episode');
    Route::post('/episode/update', 'AdminSeriesController@update_episode');
    Route::post('/episode_upload',  'AdminSeriesController@EpisodeUpload');
    Route::get('/players', 'AdminSettingsController@playerui_index');
    Route::get('/players/settings', 'AdminSettingsController@playerui_settings');   
    Route::post('/players/store', 'AdminSettingsController@storeplayerui');
    
// Age Restrict    
    Route::get('/age/index', 'AdminAgeController@index');
    Route::post('/age/store', 'AdminAgeController@store');
    Route::get('/age/edit/{id}', 'AdminAgeController@edit');
    Route::post('/age/update', 'AdminAgeController@update');
    Route::get('/age/delete/{id}', 'AdminAgeController@destroy');
    Route::get('/restrict', 'HomeController@Restrict');
    Route::post('/age/destory/{id}', 'AdminAgeController@delete');
    Route::get('/videos/delete_age_edit/{id}', 'AdminAgeController@editvideo');
    Route::post('/videos/updatevideo/', 'AdminAgeController@updatevideo');


// In app purchase
    Route::get('/inapp-purchase', 'AdminInappPurchaseController@index')->name('inapp_purchase');
    Route::post('/inapp-purchase_store', 'AdminInappPurchaseController@store')->name('inapp_purchase_store');
    Route::get('/inapp-purchase_edit/{id}', 'AdminInappPurchaseController@edit')->name('inapp_purchase_edit');
    Route::post('/inapp-purchase_update', 'AdminInappPurchaseController@update')->name('inapp_purchase_update');
    Route::get('/inapp-purchase_delete/{id}', 'AdminInappPurchaseController@delete')->name('inapp_purchase_delete');

     /*  Email Setting  */

    Route::get('/email_settings', 'AdminEmailSettingsController@index');
    Route::post('/email_settings/save', 'AdminEmailSettingsController@store');
    Route::post('/Testing_EmailSettting', 'AdminEmailSettingsController@Testing_EmailSettting'); 

  
     /*Ads Management starts*/
    Route::get('/advertisers', 'AdminAdvertiserController@advertisers');
    Route::get('/advertiser/edit/{id}', 'AdminAdvertiserController@advertisersEdit');
    Route::get('/advertiser/delete/{id}', 'AdminAdvertiserController@advertisersDelete');
    Route::post('/advertiser/update', 'AdminAdvertiserController@advertisersUpdate');

    Route::get('/ads_categories', 'AdminAdvertiserController@ads_categories');
    Route::get('/ads_list', 'AdminAdvertiserController@ads_list');
    Route::get('/advertisement/edit/{id}', 'AdminAdvertiserController@ads_Edit');
    Route::get('/advertisement/delete/{id}', 'AdminAdvertiserController@ads_Delete');
    Route::post('/advertisement/update', 'AdminAdvertiserController@ads_Update');

    Route::get('/ads_plans', 'AdminAdvertiserController@ads_plans');   
    Route::get('/ads_revenue', 'AdminAdvertiserController@ads_revenue');   
    Route::get('/calendar-event', 'AdminAdvertiserController@calendarEvent');
    Route::post('/calendar-crud-ajax', 'AdminAdvertiserController@calendarEventsAjax');
    Route::get('/ad_campaign', 'AdminAdvertiserController@adCampaign');
    Route::post('/ad_campaign_ajax', 'AdminAdvertiserController@adCampaignAjax');
    Route::get('/adscategoryedit/{id}', 'AdminAdvertiserController@adscategoryedit');    
    Route::get('/ads_category_delete/{id}', 'AdminAdvertiserController@ads_category_delete');    
    Route::post('/add_ads_category', 'AdminAdvertiserController@add_ads_category');    
    Route::post('/edit_ads_category', 'AdminAdvertiserController@edit_ads_category');
    Route::get('/adsplanedit/{id}', 'AdminAdvertiserController@adsplanedit');    
    Route::get('/ads_plan_delete/{id}', 'AdminAdvertiserController@ads_plan_delete');    
    Route::post('/add_ads_plan', 'AdminAdvertiserController@add_ads_plan');    
    Route::post('/edit_ads_plan', 'AdminAdvertiserController@edit_ads_plan');    
    Route::post('/save_ads_status', 'AdminAdvertiserController@save_ads_status');  
    Route::post('/save_advertiser_status', 'AdminAdvertiserController@save_advertiser_status'); 
    Route::get('/list_total_cpc', 'AdminAdvertiserController@list_total_cpc'); 
    Route::get('/list_total_cpv', 'AdminAdvertiserController@list_total_cpv'); 
    Route::get('/Ads-TimeSlot', 'AdminAdvertiserController@AdsTimeSlot'); 
    Route::post('/AdsTimeSlot_Save', 'AdminAdvertiserController@AdsTimeSlot_Save'); 
    Route::post('/ads_viewcount', 'AdminAdvertiserController@ads_viewcount'); 
    Route::post('/ads_viewcount_mid', 'AdminAdvertiserController@ads_viewcount_mid'); 
    Route::post('/ads_viewcount_Post', 'AdminAdvertiserController@ads_viewcount_Post'); 



    /*Ads Management ends*/

    /*Video Uploads */

    Route::post('/m3u8url',  'AdminVideosController@m3u8url');
    Route::post('/embededcode',  'AdminVideosController@Embededcode');
    Route::post('/mp4url',  'AdminVideosController@Mp4url');
    Route::post('/uploadFile',  'AdminVideosController@uploadFile');
    Route::post('/uploadEditVideo',  'AdminVideosController@uploadEditVideo');


    Route::post('/Updatem3u8url',  'AdminVideosController@Updatem3u8url');
    Route::post('/UpdateEmbededcode',  'AdminVideosController@UpdateEmbededcode');
    Route::post('/Updatemp4url',  'AdminVideosController@Updatemp4url');

    /*Audio Uploads */
    
    Route::post('/uploadAudio',  'AdminAudioController@uploadAudio');
    Route::post('/Audiofile',  'AdminAudioController@Audiofile');

    /*Moderators*/

    Route::get('/moderator', 'ModeratorsUserController@index');
    Route::post('/moderatoruser/create', 'ModeratorsUserController@store');
    Route::get('/moderator/role', 'ModeratorsUserController@RolesPermission');
    Route::post('/rolepermission/create', 'ModeratorsUserController@RolesPermissionStore');
    Route::get('/moderator/Allview', 'ModeratorsUserController@AllRoleView');
    Route::get('/moderator/commission', 'ModeratorsUserController@Commission');
    Route::post('/add/commission', 'ModeratorsUserController@AddCommission');
    Route::get('/moderatorsrole/edit/{id}', 'ModeratorsUserController@RoleEdit');
    Route::get('/moderatorsrole/delete/{id}', 'ModeratorsUserController@RoleDelete');
    Route::post('/moderatorsrole/update', 'ModeratorsUserController@RoleUpdate');


    // ExecuteShell Command For Maintanace sytsem  

    // Route::get('/execute-shell', 'HomeController@ExecuteShell');




// Email Template
Route::get('/email_template', 'AdminEmailTemplateController@index');
Route::get('/template/view/{id}', 'AdminEmailTemplateController@View');
Route::get('/template/edit/{id}', 'AdminEmailTemplateController@Edit');
Route::post('/template/update', 'AdminEmailTemplateController@Update');
Route::get('/template_search', 'AdminEmailTemplateController@Template_search');


//payment management
Route::get('/payment/total_revenue', 'AdminPaymentManagementController@index');
Route::get('/payment/subscription', 'AdminPaymentManagementController@SubscriptionIndex');
Route::get('/payment/PayPerView', 'AdminPaymentManagementController@PayPerViewIndex');
Route::post('payment/', 'AdminPaymentManagementController@Update');
Route::get('/subscription/view/{id}', 'AdminPaymentManagementController@SubscriptionView');
Route::get('/ppvpayment/view/{id}', 'AdminPaymentManagementController@PayPerView');
Route::get('/subscription_search', 'AdminPaymentManagementController@Subscription_search');
Route::get('/PayPerView_search', 'AdminPaymentManagementController@PayPerView_search');
Route::post('/Paymentfailed', 'SignupController@PaymentFailed');

// Revenue Settings  

Route::get('/revenue_settings/index', 'AdminRevenueSettings@Index');
Route::post('/revenue_settings/store', 'AdminRevenueSettings@Store');
Route::get('/revenue_settings/edit/{id}', 'AdminRevenueSettings@Edit');
Route::get('/revenue_settings/delete/{id}', 'AdminRevenueSettings@Delete');
Route::post('/revenue_settings/update', 'AdminRevenueSettings@Update');



// APP Settings  


Route::get('/app_settings/index', 'AdminAppSettings@Index');
Route::post('/app_settings/store', 'AdminAppSettings@Store');
Route::get('/app_settings/edit/{id}', 'AdminAppSettings@Edit');
Route::get('/app_settings/delete/{id}', 'AdminAppSettings@Delete');
Route::post('/app_settings/update', 'AdminAppSettings@Update');

// RTMP Settings  
Route::post('/rtmp_setting/update', 'AdminAppSettings@rtmpUpdate');
Route::get('/rtmp_setting/rtmp_remove', 'AdminAppSettings@rtmp_remove');


Route::get('/allmoderator', 'ModeratorsUserController@view');
Route::get('/moderatorsuser/edit/{id}', 'ModeratorsUserController@edit');
Route::get('/moderatorsuser/delete/{id}', 'ModeratorsUserController@delete');
Route::post('/moderatoruser/update', 'ModeratorsUserController@update');
Route::get('/live_search', 'AdminVideosController@live_search');


Route::get('/devices', 'AdminPlansController@DevicesIndex');
Route::post('/devices/store', 'AdminPlansController@DevicesStore');
Route::get('/devices/edit/{id}', 'AdminPlansController@DevicesEdit');
Route::get('/devices/delete/{id}', 'AdminPlansController@DevicesDelete');
Route::post('/devices/update', 'AdminPlansController@DevicesUpdate');

Route::get('/analytics/revenue', 'AdminUsersController@AnalyticsRevenue');
Route::get('/analytics/ViewsRegion', 'AdminUsersController@ViewsRegion');
Route::get('/analytics/RevenueRegion', 'AdminUsersController@RevenueRegion');
Route::get('/regionvideos', 'AdminUsersController@RegionVideos');

Route::get('/analytics/PlayerVideoAnalytics', 'AdminPlayerAnalyticsController@PlayerVideoAnalytics');
Route::post('/analytics/playervideos_start_date_url', 'AdminPlayerAnalyticsController@PlayerVideosStartDateRecord');
Route::post('/analytics/playervideos_end_date_url', 'AdminPlayerAnalyticsController@PlayerVideosEndDateRecord');
// Route::post('/admin/subscriber_end_date_url', 'AdminUsersController@SubscriberRevenueStartEndDateRecord');

Route::get('/analytics/RegionVideoAnalytics', 'AdminPlayerAnalyticsController@RegionVideoAnalytics');


Route::get('/analytics/PlayerUserAnalytics', 'AdminPlayerAnalyticsController@PlayerUserAnalytics');
Route::post('/analytics/playerusers_start_date_url', 'AdminPlayerAnalyticsController@PlayerUsersStartDateRecord');
Route::post('/analytics/playerusers_end_date_url', 'AdminPlayerAnalyticsController@PlayerUsersEndDateRecord');

Route::get('/analytics/VideoAllCountry', 'AdminPlayerAnalyticsController@RegionVideoAllCountry');
Route::get('/analytics/VideoAllCity', 'AdminPlayerAnalyticsController@RegionVideoAllCity');
Route::get('/analytics/Videostate', 'AdminPlayerAnalyticsController@RegionVideoState');
Route::get('/analytics/Videocity', 'AdminPlayerAnalyticsController@RegionVideoCity');
Route::post('/analytics/getState', 'AdminPlayerAnalyticsController@RegionGetState');
Route::post('/analytics/RegionGetCity', 'AdminPlayerAnalyticsController@RegionGetCity');

Route::get('/currency_settings', 'AdminCurrencySettings@IndexCurrencySettings');
Route::post('/currency/store', 'AdminCurrencySettings@StoreCurrencySettings');
Route::post('/currency/update', 'AdminCurrencySettings@UpdateCurrencySettings');
Route::get('/currency/edit/{id}', 'AdminCurrencySettings@EditCurrencySettings');
Route::get('/currency/delete/{id}', 'AdminCurrencySettings@DeleteCurrencySettings');
Route::get('/Allregionvideos', 'AdminUsersController@AllRegionVideos');

// Geofencing
Route::get('/Geofencing', 'GeofencingController@index');
Route::get('/Geofencing/create', 'GeofencingController@create');
Route::post('/Geofencing/store', 'GeofencingController@store');
       
Route::get('/Planstate', 'AdminUsersController@PlanState');
Route::get('/Plancity', 'AdminUsersController@PlanCity');
Route::post('/getState', 'AdminUsersController@GetState');
Route::post('/getCity', 'AdminUsersController@GetCity');
Route::get('/cppusers_videodata', 'AdminVideosController@CPPVideos');
Route::get('/CPPVideosIndex',  'AdminVideosController@CPPVideosIndex');
Route::get('/CPPVideosApproval/{id}',  'AdminVideosController@CPPVideosApproval');
Route::get('/CPPVideosReject/{id}',  'AdminVideosController@CPPVideosReject');
Route::get('/PlanAllCountry', 'AdminUsersController@PlanAllCountry');
Route::get('/PlanAllCity', 'AdminUsersController@PlanAllCity');
Route::get('/CPPLiveVideosIndex',  'AdminLiveStreamController@CPPLiveVideosIndex');
Route::get('/CPPLiveVideosApproval/{id}',  'AdminLiveStreamController@CPPLiveVideosApproval');
Route::get('/CPPLiveVideosReject/{id}',  'AdminLiveStreamController@CPPLiveVideosReject');

});
Route::get('admin/cpp/pendingusers',  'ModeratorsUserController@PendingUsers');

Route::get('admin/CPPModeratorsApproval/{id}',  'ModeratorsUserController@CPPModeratorsApproval');
Route::get('admin/CPPModeratorsReject/{id}',  'ModeratorsUserController@CPPModeratorsReject');

Route::get('device/logout/verify/{userIp}/{id}', 'AdminUsersController@VerifyDevice');
Route::get('device/delete/{id}', 'AdminUsersController@logoutDevice');

Route::get('device/login/verify/{ip}/{id}/{device_name}', 'AdminUsersController@ApporeDevice');
Route::get('device/accept/{user_ip}/{device_name}/{id}', 'AdminUsersController@AcceptDevice');
// Route::get('device/reject/{user_ip}/{device_name}/{id}', 'AdminUsersController@RejectDevice');

Route::get('device/reject/{user_ip}/{device_name}', 'AdminUsersController@RejectDevice');



Route::get('reset-password/{token}', 'Auth\ResetPasswordController@getPassword');
Route::get('/blocked', 'HomeController@Restrict');
Route::post('reset-password', 'Auth\ResetPasswordController@updatePassword');
Route::post('continue-watching', 'HomeController@StoreWatching');
Route::post('/like-video', 'HomeController@LikeVideo');
Route::post('/dislike-video', 'HomeController@DisLikeVideo');

Route::get('/auth/redirect/{provider}', 'GoogleLoginController@redirect');
Route::get('/callback/{provider}', 'GoogleLoginController@callback');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/Plancountry', 'AdminUsersController@PlanCountry');


Route::get('cpp/signup/',  'ModeratorsLoginController@index')->name('CPPRegister');
Route::get('/cpp',  'ModeratorsLoginController@Signin')->name('CPPSignin');
// Route::post('cpp/home',  'ModeratorsLoginController@Login')->name('CPPLogin');
Route::get('cpp/login',  'ModeratorsLoginController@Signin')->name('CPPSignin');
// Route::post('cpp/home',  'ModeratorsLoginController@Login')->name('CPPLogin');
Route::post('cpp/moderatoruser/store',  'ModeratorsLoginController@Store')->name('CPPLogin');
Route::get('/cpp/verify-request', 'ModeratorsLoginController@VerifyRequest');
Route::get('/cpp/verify/{activation_code}', 'ModeratorsLoginController@Verify');

Route::get('/emailvalidation', 'SignupController@EmailValidation');
Route::get('/usernamevalidation', 'SignupController@UsernameValidation');


// Paypal Controllers
Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
// route for post request
// Route::post('paypal', array('as' => 'paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
// route for check status responce
Route::get('paypal', array('as' => 'status','uses' => 'PaypalController@getPaymentStatus',));
Route::get('/subscribe/paypal', 'paypalcontroller@paypalredirect')->name('paypal.redirect');
Route::get('/subscribe/paypal/return', 'paypalcontroller@paypalreturn')->name('paypal.return');
// Route::get('create_paypal_plan', 'PaypalController@create_plan');
Route::get('admin/payment_test', 'AdminPaymentManagementController@PaymentIndex');

Route::post('cpp/home',  'ModeratorsLoginController@Login')->name('CPPLogin');


/**       CPP Middlware       */
Route::group(['prefix' => 'cpp','middleware' => ['cpp']], function() {
// Route::middleware(['prefix' => 'cpp' ,cpp::class])->group(function(){
// Route::get('/Homeone',  'ModeratorsLoginController@Home');


Route::get('video-analytics', 'CPPAnalyticsController@IndexVideoAnalytics');
Route::post('video_startdate_analytics', 'CPPAnalyticsController@VideoStartDateAnalytics');
Route::post('video_enddate_analytics', 'CPPAnalyticsController@VideoEndDateAnalytics');
Route::post('video_exportCsv', 'CPPAnalyticsController@VideoExportCsv');

Route::get('/dashboard', 'ModeratorsLoginController@IndexDashboard');
Route::get('/logout', 'ModeratorsLoginController@logout');
//  CPP Video Management
Route::get('/videos', 'CPPAdminVideosController@CPPindex');
Route::get('/videos/edit/{id}', 'CPPAdminVideosController@CPPedit');
Route::get('/videos/delete/{id}', array('before' => 'demo', 'uses' => 'CPPAdminVideosController@CPPdestroy'));
Route::get('/videos/create', 'CPPAdminVideosController@CPPcreate');
Route::post('/videos/fileupdate', array('before' => 'demo', 'uses' => 'CPPAdminVideosController@CPPfileupdate'));
Route::post('/videos/store', array('before' => 'demo', 'uses' => 'CPPAdminVideosController@CPPstore'));
Route::post('/videos/update', array('before' => 'demo', 'uses' => 'CPPAdminVideosController@Cppupdate'));

Route::get('/cppusers_videodata', 'CPPAdminVideosController@CPPVideo');
Route::get('/CPPlive_search', 'CPPAdminVideosController@CPPlive_search');
Route::post('/m3u8url',  'CPPAdminVideosController@CPPm3u8url');
Route::post('/embededcode',  'CPPAdminVideosController@CPPEmbededcode');
Route::post('/mp4url',  'CPPAdminVideosController@CPPMp4url');
Route::post('/uploadFile',  'CPPAdminVideosController@CPPuploadFile');

// CPP Video Categories 

Route::post('/videos/categories/store', array('before' => 'demo', 'uses' => 'CPPAdminVideoCategoriesController@CPPstore'));
Route::post('/videos/categories/order', array('before' => 'demo', 'uses' => 'CPPAdminVideoCategoriesController@CPPorder'));
Route::get('/videos/categories/edit/{id}', 'CPPAdminVideoCategoriesController@CPPedit');
Route::post('/videos/categories/update','CPPAdminVideoCategoriesController@CPPupdate');
Route::get('/videos/categories/delete/{id}', array('before' => 'demo', 'uses' => 'CPPAdminVideoCategoriesController@CPPdestroy'));
Route::post('/category_order', 'CPPAdminVideoCategoriesController@CPPcategory_order');
Route::get('/videos/categories', 'CPPAdminVideoCategoriesController@CPPindex');


// CPP Audios Categories 

Route::get('/audios', 'CPPAdminAudioController@CPPindex');
Route::get('/audios/edit/{id}', 'CPPAdminAudioController@CPPedit');
Route::post('/audios/update', array('before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPupdate'));
Route::get('/audios/delete/{id}', array('before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPdestroy'));
Route::get('/audios/create', 'CPPAdminAudioController@CPPcreate');
Route::post('/audios/store', array('before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPstore'));
Route::post('/uploadAudio',  'CPPAdminAudioController@CPPuploadAudio');
Route::post('/Audiofile',  'CPPAdminAudioController@CPPAudiofile');
Route::post('/audios/audioupdate', array('before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPaudioupdate'));


//CPP Audio Categories
Route::get('/audios/categories', 'CPPAdminAudioCategoriesController@CPPindex');
Route::post('/audios/categories/store', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPstore'));
Route::post('/audios/categories/order', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPorder'));
Route::get('/audios/categories/edit/{id}', 'CPPAdminAudioCategoriesController@CPPedit');
Route::post('/audios/categories/update', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPupdate'));
Route::get('/audios/categories/delete/{id}', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPdestroy'));


//Artist Routes
Route::get('/artists', 'CPPAdminArtistsController@CPPindex');
Route::get('/artists/create', 'CPPAdminArtistsController@CPPcreate');
Route::post('/artists/store',  'CPPAdminArtistsController@CPPstore');
Route::get('/artists/edit/{id}', 'CPPAdminArtistsController@CPPedit');
Route::post('/cpp/artists/update', 'CPPAdminArtistsController@CPPupdate');
Route::get('/artists/delete/{id}','CPPAdminArtistsController@CPPdestroy');
Route::post('/audios/audioupdate', array('before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPaudioupdate'));

//Admin Audio Albums
    Route::get('/audios/albums', 'CPPAdminAudioCategoriesController@CPPalbumIndex');
    Route::post('/audios/albums/store', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPstoreAlbum'));
    Route::post('/audios/albums/order', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPorderAlbum'));
    Route::get('/audios/albums/edit/{id}', 'CPPAdminAudioCategoriesController@CPPeditAlbum');
    Route::post('/audios/albums/update', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPupdateAlbum'));
    Route::get('/audios/albums/delete/{id}', array('before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPdestroyAlbum'));

// CPP Page 

    Route::get('/pages', 'CPPAdminPageController@CPPindex');
    Route::get('/pages/create', 'CPPAdminPageController@CPPcreate');
    Route::post('/pages/store', 'CPPAdminPageController@CPPstore');
    Route::get('/pages/edit/{id}', 'CPPAdminPageController@CPPedit');
    Route::post('/pages/update', 'CPPAdminPageController@CPPupdate');
    Route::get('/pages/delete/{id}','CPPAdminPageController@CPPdestroy');

// CPP Livestream 

    Route::get('/livestream', 'CPPAdminLiveStreamController@CPPindex');
    Route::get('/livestream/edit/{id}', 'CPPAdminLiveStreamController@CPPedit');
    Route::post('/livestream/update','CPPAdminLiveStreamController@CPPupdate');
    Route::get('/livestream/delete/{id}', array('before' => 'demo', 'uses' => 'CPPAdminLiveStreamController@CPPdestroy'));
    Route::get('/livestream/create', 'CPPAdminLiveStreamController@CPPcreate');

    Route::post('/livestream/store', array('before' => 'demo', 'uses' => 'CPPAdminLiveStreamController@CPPstore'));

// CPP Livestream Categories

    Route::get('/livestream/categories', array('before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPindex'));
    Route::post('/livestream/categories/store', array('before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPstore'));
    Route::post('/livestream/categories/order', array('before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPorder'));
    Route::get('/livestream/categories/edit/{id}', 'CPPAdminLiveCategoriesController@CPPedit');
    Route::post('/livestream/categories/update','CPPAdminLiveCategoriesController@CPPupdate');
    Route::get('/livestream/categories/delete/{id}', array('before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPdestroy'));

});




Route::get('/channel',  'ChannelLoginController@index');
Route::get('/channel/login',  'ChannelLoginController@index');
Route::get('/channel/register',  'ChannelLoginController@register');
Route::post('channel/store',  'ChannelLoginController@Store');
Route::get('/channel/verify-request', 'ChannelLoginController@VerifyRequest');
Route::get('/channel/verify/{activation_code}', 'ChannelLoginController@Verify');
Route::get('/channel/emailvalidation', 'SignupController@EmailValidation');
Route::get('/channel/home',  'ChannelLoginController@Login');

Route::group(['prefix' => 'channel','middleware' => ['channel']], function() {
    
    Route::get('/logout',  'ChannelLoginController@Logout');

});



/*  Old CPP Rotues    */








//categories_audio
Route::get('categories_audio',function(){
    $response=DB::table('audio_categories')->where('parent_id', '=', 0)->get();
    return response()->json($response,200);
});
//audios_list
Route::get('audios_list',function(){
    $response=DB::table('audio')->get();
    return response()->json($response,200);
});
//audio_albums
Route::get('audio_albums',function(){
    $response=DB::table('audio_albums')->get();
    return response()->json($response,200);
});
//audio_categories
Route::get('audio_categories',function(){
    $response=DB::table('audio_categories')->get();
    return response()->json($response,200);
});
//artists_index
Route::get('artists_index',function(){
    $response=DB::table('artists')->orderBy('created_at', 'DESC')->paginate(9);
    return response()->json($response,200);
});
//Role
Route::get('user_roles',function(){
    $response=DB::table('roles')->get();
    return response()->json($response,200);
});
//site_themes
Route::get('site_themes',function(){
    $response=DB::table('site_themes')->first();
    return response()->json($response,200);
});
//system_settings
Route::get('system_settings',function(){
    $response=DB::table('system_settings')->first();
    return response()->json($response,200);
});
//home_settings
Route::get('home_settings',function(){
    $response=DB::table('home_settings')->first();
    return response()->json($response,200);
});
//payment_settings
Route::get('payment_settings',function(){
    $response=DB::table('payment_settings')->first();
    return response()->json($response,200);
});
//mobile_settings
Route::get('mobile_settings',function(){
    $response=DB::table('mobile_apps')->get();
    return response()->json($response,200);
});
//mobileslider
Route::get('mobileslider',function(){
    $response=DB::table('mobile_sliders')->get();
    return response()->json($response,200);
});
//paypalplans
Route::get('paypalplans',function(){
    $response=DB::table('paypal_plans')->get();
    return response()->json($response,200);
});
//coupons
Route::get('coupons',function(){
    $response=DB::table('coupons')->get();
    return response()->json($response,200);
});
//plans
Route::get('plans',function(){
    $response=DB::table('plans')->get();
    return response()->json($response,200);
});
//livestream
Route::get('livestream_categories',function(){
    $response=DB::table('live_categories')->where('parent_id', '=', 0)->get();
    return response()->json($response,200);
});
//livestream
Route::get('livestream',function(){
    $response=DB::table('live_streams')->orderBy('created_at', 'DESC')->paginate(9);
    return response()->json($response,200);
});
//livestream
Route::get('live_categories',function(){
    $response=DB::table('live_categories')->get();
    return response()->json($response,200);
});
//series
Route::get('series',function(){
    $response=DB::table('series')->orderBy('created_at', 'DESC')->paginate(9);
    return response()->json($response,200);
});
//pages
Route::get('pages',function(){
    $response=DB::table('pages')->orderBy('created_at', 'DESC')->paginate(10);
    return response()->json($response,200);
});
//categories
Route::get('categories',function(){
    $response=DB::table('video_categories')->where('parent_id', '=', 0)->get();
    return response()->json($response,200);
});
//video_categories
Route::get('video_categories',function(){
    $response=DB::table('video_categories')->get();
    return response()->json($response,200);
});
//Videos
Route::get('videos',function(){
    $response=DB::table('videos')->orderBy('created_at', 'DESC')->paginate(9);
    return response()->json($response,200);
});
//Videos_index
Route::get('videos_index',function(){
    $response=DB::table('videos')->get();
    return response()->json($response,200);
});
//video_categories
Route::get('video_categories',function(){
    $response=DB::table('video_categories')->get();
    return response()->json($response,200);
});
//video_subtitle
Route::get('video_subtitle',function(){
    $response=DB::table('videos_subtitles')->get();
    return response()->json($response,200);
});
//languages
Route::get('languages',function(){
    $response=DB::table('video_languages')->get();
    return response()->json($response,200);
});
//languages
Route::get('alllanguages',function(){
    $response=DB::table('languages')->get();
    return response()->json($response,200);
});

//subtitles
Route::get('subtitles',function(){
    $response=DB::table('subtitles')->get();
    return response()->json($response,200);
});
//artists
Route::get('artists',function(){
    $response=DB::table('artists')->get();
    return response()->json($response,200);
});
//Menu
Route::get('menu',function(){
    $response=DB::table('menus')->get();
    return response()->json($response,200);
});
    // users
Route::get('users',function(){
    $response=DB::table('users')->get();
    return response()->json($response,200);
});

//Country
Route::get('country',function(){
    $response=DB::table('countries')->get();
    return response()->json($response,200);
});
//Palyer UI
Route::get('playerui_index',function(){
    $response=DB::table('playerui')->first();
    return response()->json($response,200);
});
//Slider
Route::get('allCategories',function(){
    $response=DB::table('sliders')->get();
    return response()->json($response,200);
});
// Moderator 

Route::get('moderatorsrole',function(){
    $response=DB::table('moderators_roles')->get();
    return response()->json($response,200);
});
// Moderator 
Route::get('moderatorspermission',function(){
    $response=DB::table('moderators_permissions')->get();
    return response()->json($response,200);
});
// moderatorsuser 
Route::get('moderatorsuser',function(){
    $response=DB::table('moderators_users')->get();
    return response()->json($response,200);
});
// ADMIN DASHBOARD
Route::get('settings',function(){
    $response=DB::table('settings')->first();
    return response()->json($response,200);
});
// total_subscription 
Route::get('total_subscription',function(){
    $response=DB::table('subscriptions')->where('stripe_status','=','active')->count();
    return response()->json($response,200);
});
// total_videos 
Route::get('total_videos',function(){
    $response=DB::table('videos')->where('active','=',1)->count();
    return response()->json($response,200);
});
// ppvvideo 
Route::get('ppvvideo',function(){
    // $response = PpvVideo::where('active','=',1)->count();
    $response=DB::table('ppv_videos')->where('active','=',1)->count();
    return response()->json($response,200);
});
// total_recent_subscription 

Route::get('total_recent_subscription',function(){
    $response=DB::table('subscriptions')->orderBy('created_at', 'DESC')->whereDate('created_at', '>', \Carbon\Carbon::now()->today())->count();
    return response()->json($response,200);
});
// top_rated_videos 
Route::get('top_rated_videos',function(){
    $response=DB::table('videos')->where("rating",">",7)->get();
    return response()->json($response,200);
});
// recent_views 
Route::get('recent_views',function(){
    $response=DB::table('recent_views')->get();
    return response()->json($response,200);
});
// permission 
Route::get('permission',function(){
    $response=DB::table('moderators_permissions')->get();
    return response()->json($response,200);
});
Route::get('age_categorie',function(){
    $response=DB::table('age_categories')->get();
    return response()->json($response,200);
});
// Test 
Route::post('test', 'ModeratorsUserController@test');
// video_store 
Route::post('video_store', 'ModeratorsUserController@video_store');
// menu_store 
Route::post('menu_store', 'ModeratorsUserController@menu_store');
// county 
Route::post('county', 'ModeratorsUserController@county');
// slider_store 
Route::post('slider_store', 'ModeratorsUserController@slider_store');
// all_video_store 
Route::post('all_video_store', 'ModeratorsUserController@all_video_store');
// playerui_setting 
Route::post('playerui_setting', 'ModeratorsUserController@playerui_setting');
// plans 
Route::post('plans', 'ModeratorsUserController@plans');
// paypalplans 
Route::post('paypalplans', 'ModeratorsUserController@paypalplans');
// coupons 
Route::post('coupons', 'ModeratorsUserController@coupons');
// all_video_store 
Route::post('all_video_store', 'ModeratorsUserController@all_video_store');
// payment_setting 
Route::post('payment_setting', 'ModeratorsUserController@payment_setting');
// systemsettings 
Route::post('systemsettings', 'ModeratorsUserController@systemsettings');
// homesettings 
Route::post('homesettings', 'ModeratorsUserController@homesettings');
// mobileappupdate 
Route::post('mobileappupdate', 'ModeratorsUserController@mobileappupdate');
// slider 
Route::post('slider', 'ModeratorsUserController@slider');
// theme_settings 
Route::post('theme_settings', 'ModeratorsUserController@theme_settings');
// site_setting 
Route::post('site_setting', 'ModeratorsUserController@site_setting');
// pages 
Route::post('pages', 'ModeratorsUserController@pages');
// livestream 
Route::post('livestream', 'ModeratorsUserController@livestream');
// livestream_categories 
Route::post('livestream_categories', 'ModeratorsUserController@livestream_categories');
// user_store 
Route::post('user_store', 'ModeratorsUserController@user_store');
// user_role 
Route::post('user_role', 'ModeratorsUserController@user_role');
// languagestrans 
Route::post('languagestrans', 'ModeratorsUserController@languagestrans');
// video_languages 
Route::post('video_languages', 'ModeratorsUserController@video_languages');
// artists 
Route::post('artists', 'ModeratorsUserController@artists');
// audios_categories 
Route::post('audios_categories', 'ModeratorsUserController@audios_categories');
// audios_album 
Route::post('audios_album', 'ModeratorsUserController@audios_album');
// audios 
Route::post('audios', 'ModeratorsUserController@audios');
Route::get('/moderator', 'ModeratorsUserController@index');
Route::post('/moderatoruser/create', 'ModeratorsUserController@store');
// edit_video 
Route::post('edit_video', 'ModeratorsUserController@edit_video');
// update_video 
Route::post('update_video', 'ModeratorsUserController@update_video');
// destroy_video 
Route::post('destroy_video', 'ModeratorsUserController@destroy_video');
// edit_video_category 
Route::post('edit_video_category', 'ModeratorsUserController@edit_video_category');
// update_video_store 
Route::post('update_video_store', 'ModeratorsUserController@update_video_store');
// destroy_video_category 
Route::post('destroy_video_category', 'ModeratorsUserController@destroy_video_category');
// series_store 
Route::post('series_store', 'ModeratorsUserController@series_store');
// edit_series 
Route::post('edit_series', 'ModeratorsUserController@edit_series');
// update_series 
Route::post('update_series', 'ModeratorsUserController@update_series');
// destory_series 
Route::post('destory_series', 'ModeratorsUserController@destory_series');
// edit_audio 
Route::post('edit_audio', 'ModeratorsUserController@edit_audio');
// update_audio 
Route::post('update_audio', 'ModeratorsUserController@update_audio');
// destory_audio 
Route::post('destory_audio', 'ModeratorsUserController@destory_audio');
// edit_audio_categories 
Route::post('edit_audio_categories', 'ModeratorsUserController@edit_audio_categories');
// destroy_audio_categories 
Route::post('destroy_audio_categories', 'ModeratorsUserController@destroy_audio_categories');
// destroy_artist_categories 
Route::post('destroy_artist_categories', 'ModeratorsUserController@destroy_artist_categories');
// edit_artist_categories 
Route::post('edit_artist_categories', 'ModeratorsUserController@edit_artist_categories');
// update_artist_categories 
Route::post('update_artist_categories', 'ModeratorsUserController@update_artist_categories');
// editAlbum 
Route::post('editAlbum', 'ModeratorsUserController@editAlbum');
// destroyAlbum 
Route::post('destroyAlbum', 'ModeratorsUserController@destroyAlbum');
// MobileSliderEdit 
Route::post('MobileSliderEdit', 'ModeratorsUserController@MobileSliderEdit');
// MobileSliderUpdate 
Route::post('MobileSliderUpdate', 'ModeratorsUserController@MobileSliderUpdate');
// MobileSliderDelete 
Route::post('MobileSliderDelete', 'ModeratorsUserController@MobileSliderDelete');
// page_edit 
Route::post('page_edit', 'ModeratorsUserController@page_edit');
// page_update 
Route::post('page_update', 'ModeratorsUserController@page_update');
// page_destory 
Route::post('page_destory', 'ModeratorsUserController@page_destory');
// plans_edit 
Route::post('plans_edit', 'ModeratorsUserController@plans_edit');
// plans_update 
Route::post('plans_update', 'ModeratorsUserController@plans_update');
// plans_destory 
Route::post('plans_destory', 'ModeratorsUserController@plans_destory');
// PaypalEdit 
Route::post('PaypalEdit', 'ModeratorsUserController@PaypalEdit');
// PaypalUpdate 
Route::post('PaypalUpdate', 'ModeratorsUserController@PaypalUpdate');
// PaypalDelete 
Route::post('PaypalDelete', 'ModeratorsUserController@PaypalDelete');
// editcoupons
Route::post('editcoupons', 'ModeratorsUserController@editcoupons');
// updatecoupons 
Route::post('updatecoupons', 'ModeratorsUserController@updatecoupons');
// deletecoupons 
Route::post('deletecoupons', 'ModeratorsUserController@deletecoupons');
// deletecountry 
Route::post('deletecountry', 'ModeratorsUserController@deletecountry');
// SliderEdit 
Route::post('SliderEdit', 'ModeratorsUserController@SliderEdit');
// SliderUpdate 
Route::post('SliderUpdate', 'ModeratorsUserController@SliderUpdate');
// SliderDelete 
Route::post('SliderDelete', 'ModeratorsUserController@SliderDelete');
// menu_edit 
Route::post('menu_edit', 'ModeratorsUserController@menu_edit');
// menu_update 
Route::post('menu_update', 'ModeratorsUserController@menu_update');
// menu_destroy 
Route::post('menu_destroy', 'ModeratorsUserController@menu_destroy');
// LanguageEdit 
Route::post('LanguageEdit', 'ModeratorsUserController@LanguageEdit');
// LanguageUpdate 
Route::post('LanguageUpdate', 'ModeratorsUserController@LanguageUpdate');
// LanguageDelete 
Route::post('LanguageDelete', 'ModeratorsUserController@LanguageDelete');
// LanguageTransEdit 
Route::post('LanguageTransEdit', 'ModeratorsUserController@LanguageTransEdit');
// LanguageTransUpdate 
Route::post('LanguageTransUpdate', 'ModeratorsUserController@LanguageTransUpdate');
// LanguageTransDelete 
Route::post('LanguageTransDelete', 'ModeratorsUserController@LanguageTransDelete');
// user_edit 
Route::post('user_edit', 'ModeratorsUserController@user_edit');
// user_update 
Route::post('user_update', 'ModeratorsUserController@user_update');
// user_delete 
Route::post('user_delete', 'ModeratorsUserController@user_delete');
// userroles_edit 
Route::post('userroles_edit', 'ModeratorsUserController@userroles_edit');
// userroles_update 
Route::post('userroles_update', 'ModeratorsUserController@userroles_update');
// userroles_destroy 
Route::post('userroles_destroy', 'ModeratorsUserController@userroles_destroy');
// livestream_edit 
Route::post('livestream_edit', 'ModeratorsUserController@livestream_edit');
// livestream_update 
Route::post('livestream_update', 'ModeratorsUserController@livestream_update');
// livestreamcategory_edit 
Route::post('livestreamcategory_edit', 'ModeratorsUserController@livestreamcategory_edit');
// livestreamcategory_update 
Route::post('livestreamcategory_update', 'ModeratorsUserController@livestreamcategory_update');
// livestreamcategory_destroy 
Route::post('livestreamcategory_destroy', 'ModeratorsUserController@livestreamcategory_destroy');
Route::post('Fileupload', 'ModeratorsUserController@Fileupload');
Route::post('updatefile', 'ModeratorsUserController@updatefile');
Route::post('mp4url_data', 'ModeratorsUserController@mp4url_data');
Route::post('m3u8url_data', 'ModeratorsUserController@m3u8url_data');
Route::post('Embed_Data', 'ModeratorsUserController@Embed_Data');
Route::post('Audioupload', 'ModeratorsUserController@Audioupload');
Route::post('fileAudio', 'ModeratorsUserController@fileAudio');

// Multi Profile

Route::PATCH('/Profile-details/{id}', 'MultiprofileController@profile_details')->name('profile_details');
Route::get('/profile_delete/{id}', 'MultiprofileController@profile_delete')->name('profile_delete');
Route::get('/profileDetails_edit/{id}', 'MultiprofileController@profileDetails_edit')->name('profileDetails_edit');

Route::resources([
    'Choose-profile' => MultiprofileController::class,
]);

// welcome-screen
Route::post('/welcome-screen', 'WelcomeScreenController@Screen_store')->name('welcome-screen');
Route::get('/welcome-screen/destroy/{id}', 'WelcomeScreenController@destroy')->name('welcomescreen_destroy');
Route::get('/welcome-screen/edit/{id}', 'WelcomeScreenController@edit')->name('welcomescreen_edit');
Route::post('/welcome-screen/update/{id}', 'WelcomeScreenController@update')->name('welcomescreen_update');

// Choose Profile Screen
Route::get('admin/ChooseProfileScreen', 'WelcomeScreenController@ChooseProfileScreen')->name('ChooseProfileScreen');
Route::post('admin/ChooseProfileScreen_store', 'WelcomeScreenController@ChooseProfileScreen_store')->name('ChooseProfileScreen_store');

Route::get('Movie-Description', 'HomeController@Movie_description');

    //    Theme Integration
Route::post('admin/ThemeIntegration/create', 'ThemeIntegrationController@create')->name('ThemeIntegration/create');
Route::get('admin/ThemeIntegration/set_theme', 'ThemeIntegrationController@set_theme')->name('ThemeIntegration/set_theme');
Route::post('admin/ThemeIntegration/uniquevalidation', 'ThemeIntegrationController@uniquevalidation')->name('ThemeIntegration/uniquevalidation');

// Cache clear
Route::get('admin/clear_cache', 'ClearCacheController@index')->name('clear_cache');
Route::post('admin/clear_caches', 'ClearCacheController@clear_caches')->name('clear_caches');
Route::post('admin/clear_view_cache', 'ClearCacheController@clear_view_cache')->name('clear_view_cache');

// ENV APP DEBUG
  Route::get('admin/Env_index', 'ClearCacheController@Env_index'); 
  Route::Post('admin/Env_AppDebug', 'ClearCacheController@Env_AppDebug'); 

    // Reels
Route::get('/Reals_videos/videos/{slug}', 'ChannelController@Reals_videos');


    // Cast & crew
Route::get('/Artist/{slug}', 'ChannelController@artist_videos');

  // category List
Route::get('categoryList', 'ChannelController@categoryList')->name('categoryList');
Route::get('Movie-list', 'ChannelController@MovieList')->name('MovieList');
Route::get('Live-list', 'ChannelController@liveList')->name('liveList');
Route::get('Series-list', 'ChannelController@Series_List')->name('SeriesList');
Route::get('Series/Genre/{id}', 'ChannelController@Series_genre_list')->name('Series_genre_list');
Route::get('artist-list', 'ChannelController@artist_list')->name('artist_list');

    // Filter 
Route::get('categoryfilter', 'ChannelController@categoryfilter')->name('categoryfilter');


    // Razorpay 
Route::group(['middleware' => ['RazorpayMiddleware']], function() {
Route::get('Razorpay', 'RazorpayController@Razorpay');
Route::get('/RazorpayIntegration/{PlanId}', 'RazorpayController@RazorpayIntegration')->name('RazorpayIntegration');
Route::post('/RazorpayCompleted', 'RazorpayController@RazorpayCompleted')->name('RazorpayCompleted');
Route::get('/RazorpayUpgrade', 'RazorpayController@RazorpayUpgrade')->name('RazorpayUpgrade');
Route::get('/RazorpayCancelSubscriptions', 'RazorpayController@RazorpayCancelSubscriptions')->name('RazorpayCancelSubscriptions');
Route::get('/RazorpaySubscriptionStore', 'RazorpayController@RazorpaySubscriptionStore')->name('RazorpaySubscriptionStore');
Route::get('/RazorpaySubscriptionUpdate/{planId}', 'RazorpayController@RazorpaySubscriptionUpdate')->name('RazorpaySubscriptionUpdate');

Route::get('/RazorpayVideoRent/{video_id}/{amount}', 'RazorpayController@RazorpayVideoRent')->name('RazorpayVideoRent');
Route::POST('/RazorpayVideoRent_Payment', 'RazorpayController@RazorpayVideoRent_Payment')->name('RazorpayVideoRent_Payment');

Route::get('/RazorpayLiveRent/{live_id}/{amount}', 'RazorpayController@RazorpayLiveRent')->name('RazorpayLiveRent');
Route::POST('/RazorpayLiveRent_Payment', 'RazorpayController@RazorpayLiveRent_Payment')->name('RazorpayLiveRent_Payment');
});



