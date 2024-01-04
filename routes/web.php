<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\cpp;
use App\Http\Middleware\Channel;
use Carbon\Carbon as Carbon;

// @$translate_language = App\Setting::pluck('translate_language')->first();
// \App::setLocale(@$translate_language);

Route::group(['prefix' => '/admin/filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
    
Route::get('/video-chat', function () {
    // fetch all users apart from the authenticated user
    $users = App\User::where('id', '<>', Auth::id())->get();
    return view('video-chat', ['users' => $users]);
});
// Route::get('video_chat', 'VideoChatController@index');
Route::get('mytv/quick-response/{tvcode}/{verifytoken}', 'HomeController@TvCodeQuickResponse');
Route::get('/BunnyCDNUpload', 'AdminDashboardController@BunnyCDNUpload');
Route::get('/BunnyCDNStream', 'AdminDashboardController@BunnyCDNStream');

Route::get('/paypal/create-payment', 'PayPalController@createPayment');
Route::get('/paypal/execute-payment', 'PayPalController@executePayment');
Route::post('paypal-ppv-video', 'PaymentController@paypalppvVideo');


$router->get('tv_code/devices' , 'HomeController@tv_code_devices');

Route::group(['middleware' => 'auth'], function(){
    Route::get('video_chat', 'VideoChatController@index');
    Route::post('auth/video_chat', 'VideoChatController@auth');
  });
//   Route::get('/MusicAudioPlayer', 'ThemeAudioController@MusicAudioPlayer')->name('MusicAudioPlayer');

  Route::get('MusicAudioPlayer/{slug}', 'ThemeAudioController@MusicAudioPlayer')->name('MusicAudioPlayer');
  Route::get('/convertExcelToJson', 'HomeController@uploadExcel');

// Endpoints to call or receive calls.
Route::post('/video/call-user', 'VideoChatController@callUser');
Route::post('/video/accept-call', 'VideoChatController@acceptCall');

Route::get('/cinet_pay/billings-details', 'PaymentController@cinet_pay');
Route::get('/admin/transcode-index', 'TranscodeController@index');
Route::get('/admin/addWatermark', 'TranscodeController@addWatermark');
Route::post('/audio_ppv', 'CinetPayController@audio_ppv')->name('audio_ppv');
Route::get('/admin/addSTorageWatermark', 'TranscodeController@addSTorageWatermark');
Route::get('/live_location', 'ChannelController@live_location');
Route::get('/admin/mergeMp4Files', 'TranscodeController@mergeMp4Files');
Route::get('/merge-m3u8-files', 'TranscodeController@mergeM3u8Files');
Route::get('/storagelimitone', 'AdminDashboardController@storagelimitone');
Route::get('/storagelimit', 'AdminDashboardController@storagelimit');
Route::get('/country_route_check', 'AdminDashboardController@testuserroute');

Route::get('/moderator', 'ModeratorsUserController@index');
Route::post('/moderatoruser/create', 'ModeratorsUserController@store');
Route::post('/Dashboard_Revenue', 'ModeratorsUserController@Dashboard_Revenue');
Route::post('/upgadeSubscription', 'PaymentController@UpgadeSubscription');
Route::get('/admin/plan_purchase/{plan_slug}', 'AdminDashboardController@PlanPurchase');
Route::get('/admin/flicknexs', 'AdminDashboardController@AdminFlicknexs');
Route::get('/admin/upgrade/{plan_slug}', 'AdminDashboardController@AdminFlicknexsMonthly');
Route::get('/admin/yearly/upgrade/{plan_slug}', 'AdminDashboardController@AdminFlicknexsYearly');

Route::get('/contact-us', 'ContactController@index');
Route::post('/contact-us/store/', 'ContactController@Store');
Route::get('admin/contact-us/', 'ContactController@ViewRequest');

Route::get('add-to-log', 'HomeController@myTestAddToLog');
Route::get('admin/logActivity', 'HomeController@logActivity');

Route::get('/scheduled-videos', 'HomeController@ScheduledVideo');
Route::post('/user/tv-code', 'AdminUsersController@TVCode');
Route::get('/user/tv-code/remove/{id}', 'AdminUsersController@RemoveTVCode');

Route::get('admin/combineM3U8toHLS/', 'AdminVideosController@combineM3U8');
Route::post('/user/DOB', 'AdminUsersController@DOB');
Route::get('/manage-devices', 'AdminUsersController@ManageDevices');
Route::get('/register-new-devices', 'AdminUsersController@RegisterNewDevice');
Route::get('/device/deregister/{id}', 'AdminUsersController@DeregisterDevice');
Route::post('/device/store-code', 'AdminUsersController@StoreNewDevice');

// Route::get('/admin/filemanager', 'FileManagerController@index');

// Endpoints Stations Audios.

Route::get('/create-station', 'MusicStationController@CreateStation');
Route::post('/station/store', 'MusicStationController@StoreStation');
Route::get('/music-station/{slug}', 'MusicStationController@PlayerMusicStation');
Route::get('/list-music-station', 'MusicStationController@MusicStation');
Route::get('/delete-station/{id}', 'MusicStationController@DeleteStation');
Route::get('/my-music-station', 'MusicStationController@MY_MusicStation');
Route::post('/auto-station/store', 'MusicStationController@AutoStoreStation');

// Endpoints Playlist Audios.

Route::get('/my-playlist', 'MyPlaylistController@MyPlaylist');
Route::get('/playlist/create', 'MyPlaylistController@CreatePlaylist');
Route::post('/playlist/store', 'MyPlaylistController@StorePlaylist');
Route::get('/playlist/{slug}', 'MyPlaylistController@Audio_Playlist');
Route::post('/add_audio_playlist', 'MyPlaylistController@Add_Audio_Playlist');
Route::get('/get_playlist/{slug}', 'MyPlaylistController@GetMY_Audio_Playlist');
Route::get('/playlist/play/{slug}', 'MyPlaylistController@Play_Playlist');
Route::get('/playlist/delete/{id}', 'MyPlaylistController@Delete_Playlist');

// Endpoints Playlist Audios.

Route::get('/video-playlist', 'VideoPlaylistController@MyVideoPlaylist');
Route::get('/video-playlist/{slug}', 'VideoPlaylistController@VideoPlaylist');
Route::get('video_playlist_play', 'VideoPlaylistController@video_playlist_play')->name('video_playlist_play');





// User analytics
Route::post('/admin/exportCsv', 'AdminUsersController@exportCsv');
Route::post('/admin/start_date_url', 'AdminUsersController@StartDateRecord');
Route::post('/admin/end_date_url', 'AdminUsersController@StartEndDateRecord');
Route::post('/admin/list_users_url', 'AdminUsersController@ListUsers');

// Import Excel Users
Route::get('/admin/import-users-view', 'AdminUsersController@import_users_view')->name('import_users_view');
Route::post('/admin/users-import', 'AdminUsersController@users_import')->name('users_import');

// User Revenue analytics
Route::get('/admin/users/revenue', 'AdminUsersController@UserRevenue');
Route::get('/admin/users/PayPerview_Revenue', 'AdminUsersController@PayPerviewRevenue');

Route::post('/admin/User_exportCsv', 'AdminUsersController@RevenueExportCsv');

Route::post('/admin/subscriber_start_date_url', 'AdminUsersController@SubscriberRevenueStartDateRecord');
Route::post('/admin/subscriber_end_date_url', 'AdminUsersController@SubscriberRevenueStartEndDateRecord');
Route::post('/admin/UserSubscriber_exportCsv', 'AdminUsersController@UserSubscriberExportCsv');

Route::post('/admin/payperview_start_date_url', 'AdminUsersController@PayPerviewRevenueStartDateRecord');
Route::post('/admin/payperview_end_date_url', 'AdminUsersController@PayPerviewRevenueStartEndDateRecord');
Route::post('/admin/payperview_exportCsv', 'AdminUsersController@PayPerviewRevenueExportCsv');

//  Video Purchased Analytics

Route::get('admin/video/purchased-analytics', 'AdminVideosController@PurchasedVideoAnalytics');
// Route::get('admin/video/purchased-analytics', 'AdminVideosController@purchased-analyticsRevenue');
Route::post('/admin/video/purchased-analytics_startdate_revenue', 'AdminVideosController@PurchasedVideoStartDateRevenue');
Route::post('/admin/video/purchased-analytics_enddate_revenue', 'AdminVideosController@PurchasedVideoEndDateRevenue');
Route::post('/admin/video/purchased-analytics_exportCsv', 'AdminVideosController@PurchasedVideoExportCsv');

// Live Purchased Analytics

Route::get('admin/live/purchased-analytics', 'AdminLiveStreamController@PurchasedLiveAnalytics');
Route::post('/admin/live/purchased-analytics_startdate_revenue', 'AdminLiveStreamController@PurchasedLiveStartDateRevenue');
Route::post('/admin/live/purchased-analytics_enddate_revenue', 'AdminLiveStreamController@PurchasedLiveEndDateRevenue');
Route::post('/admin/live/purchased-analytics_exportCsv', 'AdminLiveStreamController@PurchasedLiveExportCsv');

// CPP revenue

Route::get('admin/cpp/analytics', 'ModeratorsUserController@Analytics');
Route::get('admin/cpp/revenue', 'ModeratorsUserController@Revenue');
Route::post('/admin/cpp_startdate_revenue', 'ModeratorsUserController@CPPStartDateRevenue');
Route::post('/admin/cpp_enddate_revenue', 'ModeratorsUserController@CPPEndDateRevenue');
Route::post('/admin/cpp_exportCsv', 'ModeratorsUserController@CPPExportCsv');

//Subtitles Manage

Route::get('admin/subtitles', 'AdminSubtitlesController@index');
Route::get('admin/subtitles/create', 'AdminSubtitlesController@index');
Route::post('admin/subtitles/store', 'AdminSubtitlesController@store');
Route::get('admin/subtitles/edit/{id}', 'AdminSubtitlesController@edit');
Route::post('admin/subtitles/update', 'AdminSubtitlesController@update');
Route::get('admin/subtitles/delete/{id}', 'AdminSubtitlesController@destroy');

Route::post('admin/footer_menu_active', 'AdminSettingsController@footer_menu_active');

// CPP Video Analytics

Route::get('admin/cpp/video-analytics', 'ModeratorsUserController@VideoAnalytics');
Route::post('/admin/cpp_video_startdate_analytics', 'ModeratorsUserController@CPPVideoStartDateAnalytics');
Route::post('/admin/cpp_video_enddate_analytics', 'ModeratorsUserController@CPPVideoEndDateAnalytics');
Route::post('/admin/cpp_video_exportCsv', 'ModeratorsUserController@CPPVideoExportCsv');
Route::post('/admin/cpp_video_fliter', 'ModeratorsUserController@CPPVideoFilter');

Route::get('admin/livestream-analytics', 'CPPAnalyticsController@IndexLivestreamAnalytics');
Route::post('admin/livestream_startdate_analytics', 'CPPAnalyticsController@LivestreamStartDateAnalytics');
Route::post('admin/livestream_enddate_analytics', 'CPPAnalyticsController@LivestreamEndDateAnalytics');
Route::post('admin/livestream_exportCsv', 'CPPAnalyticsController@LivestreamExportCsv');

Route::post('/admin/cpp_startdate_analytics', 'ModeratorsUserController@CPPStartDateAnalytic');
Route::post('/admin/cpp_enddate_analytics', 'ModeratorsUserController@CPPEndDateAnalytic');
Route::post('/admin/cpp_analytics_exportCsv', 'ModeratorsUserController@CPPAnalyticExportCsv');
Route::post('/admin/cpp_analytics_barchart', 'ModeratorsUserController@CPPAnalyticBarchart');

Route::post('/schedule/videos', 'ChannelController@ScheduledVideos');
Route::get('/schedule/videos/embed/{slug}', 'ChannelController@EmbedScheduledVideos');
Route::get('/videos/category/{cid}', 'ChannelController@channelVideos');
Route::get('/movies/category/{cid}', 'ChannelController@channelVideos');

Route::post('/register1', 'HomeController@PostcreateStep1');
Route::get('/verify-request', 'HomeController@VerifyRequest');
Route::get('/verify-request-sent', 'HomeController@VerifyRequestNotsent');
Route::get('verify/{activation_code}', 'SignupController@Verify');
Route::post('/saveSubscription', 'PaymentController@saveSubscription');

// CheckAuthTheme5 & restrictIp Middleware
Route::group(['middleware' => ['restrictIp', 'CheckAuthTheme5']], function () {
    Route::get('datafree/category/videos/{vid}', 'ChannelController@play_videos');
    Route::get('/category/videos/embed/{vid}', 'ChannelController@Embed_play_videos');
    // Route::get('/language/{language}', 'ChannelController@LanguageVideo');
    Route::get('/category/wishlist/{slug}', 'ChannelController@Watchlist');
    Route::post('favorite', 'ThemeAudioController@add_favorite');
    Route::get('/live/category/{cid}', 'LiveStreamController@channelVideos');
    Route::get('/videos-categories/{category_slug}', 'ChannelController@Parent_video_categories')->name('Parent_video_categories');
    Route::get('/category/{cid}', 'ChannelController@channelVideos')->name('video_categories');
    Route::get('/category/videos/{vid}', 'ChannelController@play_videos')->name('play_videos');

    //theme 3 full Player
    Route::get('/category/videos/play/{vid}', 'ChannelController@fullplayer_videos')->name('fullplayer_videos');
});

Route::get('/updatecard', 'PaymentController@UpdateCard');
Route::get('/my-refferals', 'PaymentController@MyRefferal');
Route::get('/nexmo', 'HomeController@nexmo')->name('nexmo');
Route::post('/nexmo', 'HomeController@verify')->name('nexmo');

Route::get('/auth/redirect/{provider}', 'GoogleLoginController@redirect');
Route::get('/callback/{provider}', 'GoogleLoginController@callback');


// Landing page
Route::get('pages/{landing_page_slug}', 'LandingpageController@landing_page')->name('landing_page');

//  CMS Page
Route::get('/page/{slug}', 'PagesController@index');


// CheckAuthTheme5 & restrictIp Middleware
Route::group(['middleware' => ['restrictIp', 'CheckAuthTheme5']], function () {
    Route::get('/stripe/billings-details', 'PaymentController@BecomeSubscriber');
    Route::get('locale/{locale}', function ($locale) {
        Session::put('locale', $locale);
        return redirect()->back();
    });

    //custom login route
    Route::get('/mobileLogin', 'HomeController@mobileLogin');
    Route::post('/stripesubscription', 'HomeController@stripes');
    Route::post('ckeditor/image_upload', 'AdminPageController@upload')->name('upload');
    Route::get('image/index', 'ImageController@index');

    Route::post('image/upload', 'ImageController@upload');
    Route::get('/', 'HomeController@FirstLanging')->name('FirstLanging');

    Route::get('choose-profile', 'HomeController@Multipleprofile');
    Route::get('subuser/{id}', 'HomeController@subuser')->name('subuser');
    Route::get('kidsMode', 'HomeController@kidsMode')->name('kidsMode');
    Route::get('FamilyMode', 'HomeController@FamilyMode')->name('FamilyMode');
    Route::get('kidsModeOff', 'HomeController@kidsModeOff')->name('kidsModeOff');
    Route::get('FamilyModeOff', 'HomeController@FamilyModeOff')->name('FamilyModeOff');
    Route::post('theme-mode', 'HomeController@ThemeModeSave');
    Route::post('admin-theme-mode', 'HomeController@AdminThemeModeSave');
    Route::post('cpp-theme-mode', 'HomeController@CPPThemeModeSave');
    Route::post('channel-theme-mode', 'HomeController@ChannelThemeModeSave');
    Route::post('ads-theme-mode', 'HomeController@AdsThemeModeSave');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('change-profile', 'HomeController@Multipleprofile');

    // Reels
    Route::get('/reels', 'AdminReelsVideo@index');

    // TV-shows
    Route::get('tv-shows', 'TvshowsController@index')->name('series.tv-shows');

    Route::get('episode/{series_name}/{episode_name}', 'TvshowsController@play_episode')->name('play_episode');
    Route::get('network/episode/{series_name}/{episode_name}', 'TvshowsController@play_episode')->name('network_play_episode');

    Route::get('datafree/episode/{series_name}/{episode_name}', 'TvshowsController@play_episode')->name('play_episode');
    Route::get('episode/embed/{series_name}/{episode_name}', 'TvshowsController@Embedplay_episode');
    Route::get('episode/{episode_name}', 'TvshowsController@PlayEpisode');
    Route::get('play_series/{name}/', 'TvshowsController@play_series')->name('play_series');
    Route::get('datafree/play_series/{name}/', 'TvshowsController@play_series');

    // Route::get('play_series/{name}/{id}', 'TvshowsController@play_series');
    // Route::get('episode/{series_name}/{episode_name}/{id}', 'TvshowsController@play_episode');

    /* Audio Pages */
    Route::get('audios', 'ThemeAudioController@audios');
    //Route::get('audios/category/{slug}', 'ThemeAudioController@category' );
    Route::get('artist/{slug}', 'ThemeAudioController@artist')->name('artist');
    Route::get('artist/calendar-event-index/{slug}', 'ArtistEventCalendarController@index');
    Route::get('artist/calendar-event/', 'ArtistEventCalendarController@getEvents')->name('events.get');

    Route::post('artist/following', 'ThemeAudioController@ArtistFollow');
    Route::get('audio/{slug}', 'ThemeAudioController@index')->name('play_audios');
    Route::get('audio/related-playlist/{slug}', 'ThemeAudioController@Newplaylist')->name('newplaylist');
    Route::get('datafree/audio/{slug}', 'ThemeAudioController@index')->name('play_audios');
    Route::get('album/{album_slug}', 'ThemeAudioController@album');
    Route::get('/albums-list', 'ThemeAudioController@albums_list')->name('albums_list');
    Route::get('/Audios-list', 'ThemeAudioController@Audios_list')->name('Audios_list');
    //Route::get('audio/{slug}/{name}', 'ThemeAudioController@index');
    //Route::get('audios_category/{audio_id}', 'ThemeAudioController@categoryaudios');
    //Route::get('audios/tag/{tag}', 'ThemeAudioController@tag' );

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

    Route::post('/paypal-subscription', 'PaypalController@PayPalSubscription');

    Route::post('/submitpaypal', 'SignupController@submitpaypal');
    Route::post('/subscribepaypal', 'SignupController@subscribepaypal');
    Route::post('/upgradepaypalsubscription', 'PaymentController@upgradepaypalsubscription');

    Route::post('/remove-image', 'SignupController@removeImage');
    Route::post('/store', 'SignupController@store');
    Route::get('/data', 'SignupController@index');
    Route::get('stripe1', 'PaymentController@stripe');
    Route::post('stripe', 'PaymentController@stripePost')->name('stripe.post');

    Route::post('/getState', 'SignupController@GetState');
    Route::post('/getCity', 'SignupController@GetCity');
    // search
    Route::get('search', 'HomeController@search');
    Route::post('searchResult', 'HomeController@searchResult')->name('searchResult');
    Route::get('search-videos/{videos_search_value}', 'HomeController@searchResult_videos')->name('searchResult_videos');
    Route::get('search-livestream/{livestreams_search_value}', 'HomeController@searchResult_livestream')->name('searchResult_livestream');
    Route::get('search-series/{series_search_value}', 'HomeController@searchResult_series')->name('searchResult_series');
    Route::get('search-episode/{Episode_search_value}', 'HomeController@searchResult_episode')->name('searchResult_episode');
    Route::get('search-audios/{Audios_search_value}', 'HomeController@searchResult_audios')->name('searchResult_audios');

    Route::get('showPayperview', 'WatchLaterController@showPayperview');
    Route::post('watchlater', 'WatchLaterController@watchlater');
    Route::get('purchased-media', 'WatchLaterController@showPayperview');
    Route::post('addwatchlater', 'WatchLaterController@watchlater');
    Route::post('ppvWatchlater', 'WatchLaterController@ppvWatchlater');
    Route::get('/promotions', 'HomeController@promotions');

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

    Route::post('/like-episode', 'TvshowsController@LikeEpisode');
    Route::post('/remove_like-episode', 'TvshowsController@RemoveLikeEpisode');

    Route::post('/dislike-episode', 'TvshowsController@DisLikeEpisode');
    Route::post('/remove_dislike-episode', 'TvshowsController@RemoveDisLikeEpisode');

    Route::post('/like-audio', 'HomeController@LikeAudio');
    Route::post('/dislike-audio', 'HomeController@DisLikeAudio');

    // Become subscriber - single page
    Route::get('become_subscriber', 'PaymentController@become_subscriber')->name('become_subscriber');
    Route::get('retrieve_stripe_coupon', 'PaymentController@retrieve_stripe_coupon')->name('retrieve_stripe_coupon');
    Route::get('retrieve_stripe_invoice', 'PaymentController@retrieve_stripe_invoice')->name('retrieve_stripe_invoice');

    Route::get('serieslist', ['uses' => 'ChannelController@series', 'as' => 'series']);
    // Route::get('series/category/{id}', 'ChannelController@series_genre' );
    Route::get('watchlater', 'WatchLaterController@show_watchlaters');
    Route::get('myprofile', 'AdminUsersController@myprofile')->name('myprofile');
    Route::get('refferal', 'AdminUsersController@refferal');
    Route::post('/profile/update', 'AdminUsersController@profileUpdate');
    Route::get('/latest-videos', 'HomeController@LatestVideos')->name('latest-videos');
    Route::get('/language/{lanid}/{language}', 'HomeController@LanguageVideo');
    Route::get('/language/{slug}', 'HomeController@Language_Video');
    Route::get('/My-list', 'HomeController@My_list');
    Route::post('watchlater', 'WatchLaterController@watchlater');
    
    Route::get('featured-videos', 'HomeController@Featured_videos');
    Route::get('Recommended-videos', 'HomeController@Featured_videos');  // Only For Nemisha 

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

    Route::post('/profile/update_username', 'AdminUsersController@update_username');
    Route::post('/profile/update_userImage', 'AdminUsersController@update_userImage');
    Route::post('/profile/update_userEmail', 'AdminUsersController@update_userEmail');

    Route::get('upgrade-subscription_plan', 'PaymentController@Upgrade_Plan');
    Route::get('becomesubscriber', 'PaymentController@BecomeSubscriber')->name('payment_becomeSubscriber');
    Route::get('BecomeSubscriber_Plans', 'PaymentController@BecomeSubscriber_Plans')->name('BecomeSubscriber_Plans');
    Route::get('transactiondetails', 'PaymentController@TransactionDetails');

    Route::get('/upgrading', 'PaymentController@upgrading');

    Route::get('/channels', 'ChannelController@index');
    Route::get('/ppvVideos', 'ChannelController@ppvVideos');
    Route::get('/live', 'LiveStreamController@Index');
    // Route::get('/live/{play}/{id}', 'LiveStreamController@Play');

    Route::get('/live/{id}', 'LiveStreamController@Play')->name('LiveStream_play');
    Route::get('datafree/live/{id}', 'LiveStreamController@Play')->name('LiveStream_play');
    Route::get('/live/embed/{id}', 'LiveStreamController@EmbedLivePlay');

    Route::post('lifetime-subscription-payment', 'PaymentController@lifetime_subscription')->name('stripe.lifetime_subscription');

    Route::post('purchase-live', 'PaymentController@StoreLive')->name('stripe.store');
    Route::post('purchase-video', 'PaymentController@purchaseVideo');
    Route::post('/purchased-audio-check', 'PaymentController@purchased_audio_check')->name('purchased_audio_check');
    Route::post('purchase-audio', 'PaymentController@purchaseAudio');
    Route::post('purchase-videocount', 'AdminVideosController@purchaseVideocount');
    Route::post('player_analytics_create', 'AdminPlayerAnalyticsController@PlayerAnalyticsCreate');
    Route::post('player_analytics_store', 'AdminPlayerAnalyticsController@PlayerAnalyticsStore');
    Route::post('player_seektime_store', 'AdminPlayerAnalyticsController@PlayerSeekTimeStore');
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
    Route::post('/profileupdate', 'AdminUsersController@ProfileImage');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin', 'restrictIp']], function () {
    //,'restrictIp'
    //        Route::get('/', function () {
    //            return view('admin.dashboard');
    //        });

    Route::get('/', 'AdminDashboardController@index');
    Route::get('/mobileapp', 'AdminUsersController@mobileapp');
    Route::post('/translate_language', 'AdminDashboardController@TranslateLanguage');
    Route::post('/admin_translate_language', 'AdminDashboardController@AdminTranslateLanguage');

    // Channel Schedule
    Route::get('/channel/index', 'AdminEPGChannelController@index')->name('admin.Channel.index');
    Route::get('/channel/create', 'AdminEPGChannelController@create')->name('admin.Channel.create');
    Route::post('/channel/store', 'AdminEPGChannelController@store')->name('admin.Channel.store');
    Route::get('/channel/edit/{id}', 'AdminEPGChannelController@edit')->name('admin.Channel.edit');
    Route::post('/channel/update/{id}', 'AdminEPGChannelController@update')->name('admin.Channel.update');
    Route::get('/channel/destroy/{id}', 'AdminEPGChannelController@destroy')->name('admin.Channel.destroy');
    Route::get('/channel/validation', 'AdminEPGChannelController@slug_validation')->name('admin.Channel.slug_validation');

    // EPG Schedule
    Route::get('/egp/index', 'AdminEPGController@index')->name('admin.epg.index');
    Route::get('/epg/generate', 'AdminEPGController@generate')->name('admin.epg.generate');
    
    // Splash Screen
    Route::post('/mobile_app/store', 'AdminUsersController@mobileappupdate');
    Route::get('/mobile_app/Splash_destroy/{source}/{id}', 'AdminUsersController@Splash_destroy')->name('Splash_destroy');
    Route::get('/mobile_app/Splash_edit/{source}/{id}', 'AdminUsersController@Splash_edit')->name('Splash_edit');
    Route::post('/mobile_app/Splash_update/{source}/{id}', 'AdminUsersController@Splash_update')->name('Splash_update');

    Route::get('/users', 'AdminUsersController@index')->name('users');
    Route::get('/user/create', 'AdminUsersController@create');
    Route::post('/user/store', 'AdminUsersController@store');
    Route::get('/user/edit/{id}', 'AdminUsersController@edit');
    Route::post('/user/update', ['before' => 'demo', 'uses' => 'AdminUsersController@update']);
    Route::get('/user/delete/{id}', ['before' => 'demo', 'uses' => 'AdminUsersController@destroy']);
    Route::post('/export', 'AdminUsersController@export');
    Route::get('/user/view/{id}', 'AdminUsersController@view');
    Route::post('/profile/update', 'AdminUsersController@myprofileupdate');
    Route::post('/profileupdate', 'AdminUsersController@ProfileImage');
    Route::post('/profilePreference', 'AdminUsersController@profilePreference');
    Route::get('/email_exitsvalidation', 'AdminUsersController@email_exitsvalidation')->name('email_exitsvalidation');
    Route::get('/mobilenumber_exitsvalidation', 'AdminUsersController@mobilenumber_exitsvalidation')->name('mobilenumber_exitsvalidation');
    Route::get('/password_validation', 'AdminUsersController@password_validation')->name('password_validation');

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

    Route::get('/signup', 'AdminSignupMenuController@index')->name('signupindex');
    Route::post('/Signupmenu_Store', 'AdminSignupMenuController@store')->name('store');

    Route::get('/sliders', 'AdminThemeSettingsController@SliderIndex');
    Route::post('/sliders/store', 'AdminThemeSettingsController@SliderStore');
    Route::get('/sliders/edit/{id}', 'AdminThemeSettingsController@SliderEdit');
    Route::get('/sliders/delete/{id}', 'AdminThemeSettingsController@SliderDelete');
    Route::post('/sliders/update', 'AdminThemeSettingsController@SliderUpdate');
    Route::post('/slider_order', 'AdminThemeSettingsController@slider_order');

    Route::post('/mobile/sliders/store', 'AdminThemeSettingsController@MobileSliderStore');
    Route::get('/mobile/sliders/edit/{id}', 'AdminThemeSettingsController@MobileSliderEdit');
    Route::get('/mobile/sliders/delete/{id}', 'AdminThemeSettingsController@MobileSliderDelete');
    Route::post('/mobile/sliders/update', 'AdminThemeSettingsController@MobileSliderUpdate');

    Route::get('/admin-languages', 'AdminThemeSettingsController@LanguageIndex');
    Route::post('/languages/store', 'AdminThemeSettingsController@LanguageStore');
    Route::get('/languages/edit/{id}', 'AdminThemeSettingsController@LanguageEdit');
    Route::get('/languages/delete/{id}', 'AdminThemeSettingsController@LanguageDelete');
    Route::post('/languages/update', 'AdminThemeSettingsController@LanguageUpdate')->name('LanguageUpdate');

    Route::get('/admin-languages-transulates', 'AdminThemeSettingsController@LanguageTransIndex');

    Route::post('/languagestrans/store', 'AdminThemeSettingsController@LanguageTransStore');
    Route::get('/languagestrans/edit/{id}', 'AdminThemeSettingsController@LanguageTransEdit');
    Route::get('/languagestrans/delete/{id}', 'AdminThemeSettingsController@LanguageTransDelete');
    Route::post('/languagestrans/update', 'AdminThemeSettingsController@LanguageTransUpdate');

    Route::get('/countries', 'AdminManageCountries@Index');
    Route::post('/countries/store', 'AdminManageCountries@Store');
    Route::get('/countries/edit/{id}', 'AdminManageCountries@Edit');
    Route::get('/countries/delete/{id}', 'AdminManageCountries@Delete');
    Route::post('/countries/update', 'AdminManageCountries@Update');

    Route::get('/player', 'Adminplayer@Index');

    Route::get('/get_processed_percentage/{id}', 'AdminVideosController@get_processed_percentage');

    // Admin Series and Episode

    Route::get('/episode/filedelete/{id}', 'AdminSeriesController@filedelete');

    Route::get('/Testwatermark', 'Testwatermark@index');

    // Admin Video Playlist 

    Route::get('/videos/playlist', 'AdminVideoPlayListController@index');
    Route::get('/videos/playlist/edit/{id}', 'AdminVideoPlayListController@edit');
    Route::post('/videos/playlist/store', 'AdminVideoPlayListController@store');
    Route::post('/videos/playlist/update', 'AdminVideoPlayListController@update');
    Route::get('/videos/playlist/delete/{id}', 'AdminVideoPlayListController@destroy');

    // Admin Video Functionality
    Route::post('/category_order', 'AdminVideoCategoriesController@category_order');
    Route::get('/videos', 'AdminVideosController@index');
    Route::get('/videos/categories', 'AdminVideoCategoriesController@index');
    Route::get('/videos/edit/{id}', 'AdminVideosController@edit');
    Route::get('/videos/filedelete/{id}', 'AdminVideosController@filedelete');
    Route::get('/videos/editvideo/{id}', 'AdminVideosController@editvideo');
    Route::post('/videos/update', ['before' => 'demo', 'uses' => 'AdminVideosController@update']);
    Route::get('/videos/delete/{id}', ['before' => 'demo', 'uses' => 'AdminVideosController@destroy']);
    Route::get('/videos/create', 'AdminVideosController@create');
    Route::post('/videos/fileupdate', ['before' => 'demo', 'uses' => 'AdminVideosController@fileupdate']);
    Route::post('/videos/store', ['before' => 'demo', 'uses' => 'AdminVideosController@store']);
    Route::post('/videos/categories/store', ['before' => 'demo', 'uses' => 'AdminVideoCategoriesController@store']);
    Route::post('/videos/categories/order', ['before' => 'demo', 'uses' => 'AdminVideoCategoriesController@order']);
    Route::get('/videos/categories/edit/{id}', 'AdminVideoCategoriesController@edit');
    Route::post('/videos/categories/update', 'AdminVideoCategoriesController@update');
    Route::get('/videos/categories/delete/{id}', ['before' => 'demo', 'uses' => 'AdminVideoCategoriesController@destroy']);
    Route::get('/videos/aws_editvideo/{id}', 'AdminVideosController@AWSEditvideo');
    Route::get('/subtitle/delete/{id}', ['before' => 'demo', 'uses' => 'AdminVideosController@subtitledestroy']);
    Route::post('/videos/extractedimage', 'AdminVideosController@ExtractedImage');

    // Admin PPV Functionality
    Route::get('/ppv', 'AdminPpvController@index');
    Route::get('/ppv/edit/{id}', 'AdminPpvController@edit');
    Route::post('/ppv/update', 'AdminPpvController@update');
    Route::get('/ppv/delete/{id}', ['before' => 'demo', 'uses' => 'AdminPpvController@destroy']);
    Route::get('/ppv/create', 'AdminPpvController@create');
    Route::post('/ppv/store', ['before' => 'demo', 'uses' => 'AdminPpvController@store']);

    // Admin Choose Profile Screen
    Route::get('/ChooseProfileScreen', 'WelcomeScreenController@ChooseProfileScreen')->name('ChooseProfileScreen');
    Route::post('/ChooseProfileScreen_store', 'WelcomeScreenController@ChooseProfileScreen_store')->name('ChooseProfileScreen_store');

    //    Slider
    Route::get('/Slider/index', 'AdminSliderSettingController@index')->name('admin_slider_index');
    Route::get('/Slider/set_slider', 'AdminSliderSettingController@set_slider')->name('admin_slider_set');

    // Cache clear
    Route::get('/clear_cache', 'ClearCacheController@index')->name('clear_cache');
    Route::post('/clear_caches', 'ClearCacheController@clear_caches')->name('clear_caches');
    Route::post('/clear_view_cache', 'ClearCacheController@clear_view_cache')->name('clear_view_cache');

    // ENV APP DEBUG
    Route::get('/debug', 'ClearCacheController@Env_index')->name('env_index');
    Route::Post('/Env_AppDebug', 'ClearCacheController@Env_AppDebug')->name('env_appdebug');

    //  Bulk Delete
    Route::get('admin/Livestream_bulk_delete', 'AdminLiveStreamController@Livestream_bulk_delete')->name('Livestream_bulk_delete');
    Route::get('admin/Audios_bulk_delete', 'AdminAudioController@Audios_bulk_delete')->name('Audios_bulk_delete');

    // Admin PPV Functionality
    Route::get('/livestream', 'AdminLiveStreamController@index');
    Route::get('/livestream/edit/{id}', 'AdminLiveStreamController@edit');
    Route::post('/livestream/update', 'AdminLiveStreamController@update');
    Route::get('/livestream/delete/{id}', ['before' => 'demo', 'uses' => 'AdminLiveStreamController@destroy']);
    Route::get('/livestream/create', 'AdminLiveStreamController@create');
    Route::post('/livestream/store', ['before' => 'demo', 'uses' => 'AdminLiveStreamController@store']);

    // Restream - live

    Route::get('/youtube_start_restream_test', 'AdminLiveStreamController@youtube_start_restream_test')->name('youtube_start_restream_test');
    Route::post('/youtube_start_restream', 'AdminLiveStreamController@youtube_start_restream')->name('youtube_start_restream');
    Route::post('/fb_start_restream', 'AdminLiveStreamController@fb_start_restream')->name('fb_start_restream');
    Route::post('/twitter_start_restream', 'AdminLiveStreamController@twitter_start_restream')->name('twitter_start_restream');
    Route::post('/linkedin_start_restream', 'AdminLiveStreamController@linkedin_start_restream')->name('linkedin_start_restream');

    Route::post('/youtube_stop_restream', 'AdminLiveStreamController@youtube_stop_restream')->name('youtube_stop_restream');
    Route::post('/fb_stop_restream', 'AdminLiveStreamController@fb_stop_restream')->name('fb_stop_restream');
    Route::post('/twitter_stop_restream', 'AdminLiveStreamController@twitter_stop_restream')->name('twitter_stop_restream');
    Route::post('/linkedin_stop_restream', 'AdminLiveStreamController@linkedin_stop_restream')->name('linkedin_stop_restream');

    Route::get('/ppv/categories', ['before' => 'demo', 'uses' => 'AdminPpvCategoriesController@index']);
    Route::post('/ppv/categories/store', ['before' => 'demo', 'uses' => 'AdminPpvCategoriesController@store']);
    Route::post('/ppv/categories/order', ['before' => 'demo', 'uses' => 'AdminPpvCategoriesController@order']);
    Route::get('/ppv/categories/edit/{id}', 'AdminPpvCategoriesController@edit');
    Route::post('/ppv/categories/update', 'AdminPpvCategoriesController@update');
    Route::get('/ppv/categories/delete/{id}', ['before' => 'demo', 'uses' => 'AdminPpvCategoriesController@destroy']);

    Route::get('/livestream/categories', ['before' => 'demo', 'uses' => 'AdminLiveCategoriesController@index']);
    Route::post('/livestream/categories/store', ['before' => 'demo', 'uses' => 'AdminLiveCategoriesController@store']);
    Route::post('/livestream/categories/order', ['before' => 'demo', 'uses' => 'AdminLiveCategoriesController@order']);
    Route::get('/livestream/categories/edit/{id}', 'AdminLiveCategoriesController@edit');
    Route::post('/livestream/categories/update', 'AdminLiveCategoriesController@update');
    Route::get('/livestream/categories/delete/{id}', ['before' => 'demo', 'uses' => 'AdminLiveCategoriesController@destroy']);
    Route::post('/live_category_order', 'AdminLiveCategoriesController@live_category_order');

    Route::get('/plans', 'AdminPlansController@index');
    Route::post('/plans/store', 'AdminPlansController@store');
    Route::get('/plans/edit/{id}', 'AdminPlansController@edit');
    Route::get('/plans/delete/{id}', 'AdminPlansController@delete');
    Route::post('/plans/update', 'AdminPlansController@update');

    Route::get('/subscription-plans', 'AdminPlansController@subscriptionindex');
    Route::post('/subscription-plans/store', 'AdminPlansController@subscriptionstore');
    Route::get('/subscription-plans/edit/{id}', 'AdminPlansController@subscriptionedit');
    Route::get('/subscription-plans/delete/{id}', 'AdminPlansController@subscriptiondelete');
    Route::post('/subscription-plans/update', 'AdminPlansController@subscriptionupdate');
    
    // Multiple Subscription Plans
    Route::post('Update-Multiple-Subscription-Plans', 'AdminPlansController@Update_Multiple_Subscription_Plans')->name('Update_Multiple_Subscription_Plans');

    // Life-Time Subscription Plans
    Route::get('/Life-time-subscription', 'AdminLifeTimeSubscriptionController@index')->name('Life-time-subscription-index');
    Route::post('/Life-time-subscription-store', 'AdminLifeTimeSubscriptionController@update')->name('Life-time-subscription-update');

    Route::get('/paypalplans', 'AdminPlansController@PaypalIndex');
    Route::post('/paypalplans/store', 'AdminPlansController@PaypalStore');
    Route::get('/paypalplans/edit/{id}', 'AdminPlansController@PaypalEdit');
    Route::get('/paypalplans/delete/{id}', 'AdminPlansController@PaypalDelete');
    Route::post('/paypalplans/update', 'AdminPlansController@PaypalUpdate');

    Route::get('/coupons', 'AdminCouponManagement@index');
    Route::post('/coupons/store', 'AdminCouponManagement@store');
    Route::get('/coupons/edit/{id}', 'AdminCouponManagement@edit');
    Route::get('/coupons/delete/{id}', 'AdminCouponManagement@delete');
    Route::post('/coupons/update', 'AdminCouponManagement@update');

    Route::get('/pages', 'AdminPageController@index');
    Route::get('/pages/create', 'AdminPageController@create');
    Route::post('/pages/store', 'AdminPageController@store');
    Route::get('/pages/edit/{id}', 'AdminPageController@edit');
    Route::post('/pages/update', 'AdminPageController@update');
    Route::get('/pages/delete/{id}', 'AdminPageController@destroy');
    Route::post('/page_status_update', 'AdminPageController@page_status')->name('page_status_update');

    Route::get('/menu', 'AdminMenuController@index');
    Route::post('/menu/store', ['before' => 'demo', 'uses' => 'AdminMenuController@store']);
    Route::get('/menu/edit/{id}', 'AdminMenuController@edit');
    Route::post('/menu/update', ['before' => 'demo', 'uses' => 'AdminMenuController@update']);
    Route::post('/menu/order', ['before' => 'demo', 'uses' => 'AdminMenuController@order']);
    Route::post('menu/update-order', 'AdminMenuController@updateOrder');
    Route::get('/menu/delete/{id}', ['before' => 'demo', 'uses' => 'AdminMenuController@destroy']);

    /* theme settings*/

    Route::get('/theme_settings_form', 'AdminThemeSettingsController@theme_settings_form');
    Route::get('/theme_settings', 'AdminThemeSettingsController@theme_settings');

    Route::post('/theme_settings', ['before' => 'demo', 'uses' => 'AdminThemeSettingsController@update_theme_settings']);

    Route::post('/theme_settings/save', 'AdminThemeSettingsController@SaveTheme');

    Route::get('/linking_settings', 'AdminSettingsController@LinkingIndex');
    Route::post('/linking/store', 'AdminSettingsController@LinkingSave');

    /* payment settings */
    Route::get('/payment_settings', 'AdminPaymentSettingsController@index');
    Route::post('/payment_settings', ['before' => 'demo', 'uses' => 'AdminPaymentSettingsController@save_payment_settings']);

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

    // Ads category - videos
    Route::post('/pre-videos-ads', 'AdminVideosController@pre_videos_ads')->name('pre_videos_ads');
    Route::post('/mid-videos-ads', 'AdminVideosController@mid_videos_ads')->name('mid_videos_ads');
    Route::post('/post-videos-ads', 'AdminVideosController@post_videos_ads')->name('post_videos_ads');
    Route::post('/tag-url-ads', 'AdminVideosController@tag_url_ads')->name('tag_url_ads');

    // Ads position - Live stream
    Route::post('/live-ads-position', 'AdminLiveStreamController@live_ads_position')->name('live_ads_position');

    // Ads position - Episode
    Route::post('/episode-ads-position', 'AdminSeriesController@episode_ads_position')->name('episode_ads_position');

    // slider for live stream in index
    Route::post('/livevideo_slider_update', 'AdminLiveStreamController@livevideo_slider_update');

    // slider - series & Episode
    Route::post('/series_slider_update', 'AdminSeriesController@series_slider_update');
    Route::post('/episode_slider_update', 'AdminSeriesController@episode_slider_update');

    /* Thumbnail Setting */
    Route::get('/ThumbnailSetting', 'AdminSettingsController@ThumbnailSetting')->name('ThumbnailSetting');
    Route::post('/ThumbnailSetting_Store', 'AdminSettingsController@ThumbnailSetting_Store');

    /* Ck-editor  Image Upload Setting */
    Route::post('ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');

    Route::post('/settings/store_inapp', 'AdminSettingsController@Store_InApp');

    // Active  - Categories
    
        Route::post('/audio_category_active', 'AdminAudioCategoriesController@audio_category_active');
        Route::post('/livestream_category_active', 'AdminLiveCategoriesController@livestream_category_active');
        Route::post('/video_category_active', 'AdminVideoCategoriesController@video_category_active');
        Route::post('/series_category_active', 'AdminSeriesGenreController@series_category_active');
        Route::post('/menus_active', 'AdminMenuController@menus_active');

        
    // Admin Landing page

    Route::get('/landing-page/index', 'AdminLandingpageController@index')->name('landing_page_index');
    Route::get('/landing-page/create', 'AdminLandingpageController@create')->name('landing_page_create');
    Route::get('/landing-page/edit/{id}', 'AdminLandingpageController@edit')->name('landing_page_edit');
    Route::post('/landing-page/store', 'AdminLandingpageController@store')->name('landing_page_store');
    Route::post('/landing-page/update', 'AdminLandingpageController@update')->name('landing_page_update');
    Route::get('/landing-page/delete/{id}', 'AdminLandingpageController@delete')->name('landing_page_delete');
    Route::post('/landing-page/update_status', 'AdminLandingpageController@update_status')->name('landing_page_update_status');
    Route::get('/landing-page/preview/{landing_page_id}', 'AdminLandingpageController@preview')->name('landing_page_preview');

    // Footer Link
    Route::get('/footer_menu', 'AdminSettingsController@footer_link')->name('footer_link');
    Route::post('/footer_link_store', 'AdminSettingsController@footer_link_store');
    Route::post('/footer_order_update', 'AdminSettingsController@footer_order_update');
    Route::get('/footer_delete/{id}', 'AdminSettingsController@footer_delete');
    Route::get('/footer_menu_edit/{id}', 'AdminSettingsController@footer_edit');
    Route::post('/footer_update', 'AdminSettingsController@footer_update');

    // recaptcha
    Route::post('/captcha', 'AdminSettingsController@captcha')->name('captcha');

    // Restream

    Route::get('/Restream', 'AdminRestreamController@Restream_index')->name('Restream_index');
    Route::get('/Restream-create', 'AdminRestreamController@Restream_create')->name('Restream_create');
    Route::post('/Restream-obs-store', 'AdminRestreamController@Restream_obs_store')->name('Restream_obs_store');

    // Mobile Side Link
    Route::get('/mobile/side_menu', 'AdminMobileSideMenu@Side_link')->name('Side_link');
    Route::post('/mobile/side_link_store', 'AdminMobileSideMenu@Side_link_store');
    Route::post('/mobile/side_order_update', 'AdminMobileSideMenu@Side_order_update');
    Route::get('/mobile/side_delete/{id}', 'AdminMobileSideMenu@Side_delete');
    Route::get('/mobile/side_menu_edit/{id}', 'AdminMobileSideMenu@Side_edit');
    Route::post('/mobile/side_update', 'AdminMobileSideMenu@Side_update');

    //Select video delete
    Route::get('/VideoBulk_delete', 'AdminVideosController@VideoBulk_delete')->name('VideoBulk_delete');

    // Multi-user Limit
    Route::get('/MultiUser-limit', 'AdminMultiUserController@multiuser_limit')->name('multiuser_limit');
    Route::post('/Multi_limit_store', 'AdminMultiUserController@Multi_limit_store')->name('Multi_limit_store');

    // Theme Integration
    Route::get('ThemeIntegration', 'ThemeIntegrationController@index')->name('ThemeIntegration');

    // Compress Image
    Route::get('/compress-image-setting', 'AdminSettingsController@compress_image')->name('compress_image');
    Route::post('/compress-image-store', 'AdminSettingsController@compress_image_store')->name('compress_image_store');

    // Comment Section 
    Route::get('/comment-section-setting', 'AdminSettingsController@comment_section')->name('comment_section');
    Route::post('/comment-section-update', 'AdminSettingsController@comment_section_update')->name('comment_section_update');
    Route::post('/comment-status-update', 'AdminSettingsController@comment_status_update')->name('comments.status_update');

    //   Home Page Popup
    Route::get('/pop-up', 'AdminHomePopupController@index')->name('homepage_popup');
    Route::post('/pop-up-update', 'AdminHomePopupController@create')->name('homepage_popup_update');

    // Admin Live Event for artist
    Route::get('/live-event-artist', 'AdminLiveEventArtist@index')->name('live_event_artist');
    Route::get('/live-event-create', 'AdminLiveEventArtist@create')->name('live_event_create');
    Route::post('/live-event-store', 'AdminLiveEventArtist@store')->name('live_event_store');
    Route::get('/live-event-edit/{id}', 'AdminLiveEventArtist@edit')->name('live_event_edit');
    Route::post('/live-event-update/{id}', 'AdminLiveEventArtist@update')->name('live_event_update');
    Route::get('/live-event-destroy/{id}', 'AdminLiveEventArtist@destroy')->name('live_event_destroy');

    // Admin Channel Package
    Route::get('/channel-package-index', 'AdminChannelPackageController@index')->name('channel_package_index');
    Route::get('/channel-package-create', 'AdminChannelPackageController@create')->name('channel_package_create');
    Route::post('/channel-package-store', 'AdminChannelPackageController@store')->name('channel_package_store');
    Route::get('/channel-package-edit/{id}', 'AdminChannelPackageController@edit')->name('channel_package_edit');
    Route::post('/channel-package-update/{id}', 'AdminChannelPackageController@update')->name('channel_package_update');
    Route::get('/channel-package-delete/{id}', 'AdminChannelPackageController@delete')->name('channel_package_delete');

    Route::get('/languages', 'LanguageTranslationController@index')->name('languages');
    Route::post('/translations/update', 'LanguageTranslationController@transUpdate')->name('translation.update.json');
    Route::post('/translations/updateKey', 'LanguageTranslationController@transUpdateKey')->name('translation.update.json.key');
    Route::delete('/translations/destroy/{key}', 'LanguageTranslationController@destroy')->name('translations.destroy');
    Route::post('/translations/create', 'LanguageTranslationController@store')->name('translations.create');
    Route::get('check-translation', function () {
        \App::setLocale('it');

        echo(__('About US')); exit;
    });

    Route::get('/translate-languages-index', 'AdminTranslationLanguageController@index');
    Route::post('/translate-languages-store', 'AdminTranslationLanguageController@store');
    Route::post('/translate-languages-update', 'AdminTranslationLanguageController@update');
    Route::get('/translate-languages-edit/{id}', 'AdminTranslationLanguageController@edit');
    Route::get('/translate-languages-delete/{id}', 'AdminTranslationLanguageController@destroy');
   

    // Site Meta Settings
    Route::get('/site-meta-setting', 'AdminSiteMetaController@meta_setting')->name('meta_setting');
    Route::get('/site-meta-edit/{id}', 'AdminSiteMetaController@meta_setting_edit')->name('meta_setting_edit');
    Route::post('/site-meta-update', 'AdminSiteMetaController@meta_setting_update')->name('meta_setting_update');

    // Site Meta Settings
    Route::get('/user-logged-device', 'AdminAppSettings@LoggedUserDevices')->name('LoggedUserDevices');
    Route::get('/user-logged-device/delete/{id}', 'AdminAppSettings@LoggedUserDeviceDelete')->name('LoggedUserDeviceDelete');
    Route::get('/user-logged-device/delete/{id}', 'AdminAppSettings@LoggedUserDeviceDelete')->name('LoggedUserDeviceDelete');
    Route::get('/logged_device_Bulk_delete', 'AdminAppSettings@logged_device_Bulk_delete')->name('logged_device_Bulk_delete');

    /* User Roles */
    Route::get('/permissions', 'AdminRolePermissionController@index');
    Route::get('/permissions/edit/{id}', 'AdminRolePermissionController@edit');
    Route::get('/permissions/delete/{id}', 'AdminRolePermissionController@destroy');
    Route::post('/permissions/store', 'AdminRolePermissionController@store');
    Route::post('/permissions/update', 'AdminRolePermissionController@update');

    Route::get('/audios', 'AdminAudioController@index');
    Route::get('/audios/edit/{id}', 'AdminAudioController@edit');
    Route::post('/audios/update', ['before' => 'demo', 'uses' => 'AdminAudioController@update']);
    Route::get('/audios/delete/{id}', ['before' => 'demo', 'uses' => 'AdminAudioController@destroy']);
    Route::get('/audios/create', 'AdminAudioController@create');
    Route::post('/audios/store', ['before' => 'demo', 'uses' => 'AdminAudioController@store']);
    Route::post('/audios/lyricsFileValidation', 'AdminAudioController@lyricsFileValidation');

    //Admin Audio Categories
    Route::get('/audios/categories', 'AdminAudioCategoriesController@index');
    Route::post('/audios/categories/store', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@store']);
    Route::post('/audios/categories/order', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@order']);
    Route::get('/audios/categories/edit/{id}', 'AdminAudioCategoriesController@edit');
    Route::post('/audios/categories/update', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@update']);
    Route::get('/audios/categories/delete/{id}', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@destroy']);
    Route::post('/audio_category_order', 'AdminAudioCategoriesController@audio_category_order');

    //Artist Routes
    Route::get('/artists', 'AdminArtistsController@index');
    Route::get('/artists/create', 'AdminArtistsController@create');
    Route::post('/artists/store', 'AdminArtistsController@store');
    Route::get('/artists/edit/{id}', 'AdminArtistsController@edit');
    Route::post('/artists/update', 'AdminArtistsController@update');
    Route::get('/artists/delete/{id}', 'AdminArtistsController@destroy');
    Route::get('/artist_slug_validation', 'AdminArtistsController@artist_slug_validation');
    Route::post('/audios/audioupdate', ['before' => 'demo', 'uses' => 'AdminAudioController@audioupdate']);

    //Admin Audio Albums
    Route::get('/audios/albums', 'AdminAudioCategoriesController@albumIndex');
    Route::post('/audios/albums/store', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@storeAlbum']);
    Route::post('/audios/albums/order', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@orderAlbum']);
    Route::get('/audios/albums/edit/{id}', 'AdminAudioCategoriesController@editAlbum');
    Route::post('/audios/albums/update', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@updateAlbum']);
    Route::get('/audios/albums/delete/{id}', ['before' => 'demo', 'uses' => 'AdminAudioCategoriesController@destroyAlbum']);

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

    
    // Admin Network 
    Route::get('/Series/Network', 'AdminNetworkController@Network_index')->name('admin.Network_index');
    Route::Post('/Serie/Network-store', 'AdminNetworkController@Network_store')->name('admin.Network_store');
    Route::get('/Serie/Network-edit/{id}', 'AdminNetworkController@Network_edit')->name('admin.Network_edit');
    Route::PATCH('/Serie/Network-update/{id}', 'AdminNetworkController@Network_update')->name('admin.Network_update');
    Route::get('/Serie/Network-delete/{id}', 'AdminNetworkController@Network_delete')->name('admin.Network_delete');
    Route::Post('/Serie/Network/order', 'AdminNetworkController@Network_order')->name('admin.Network_order');

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
    Route::post('/episode_upload', 'AdminSeriesController@EpisodeUpload');
    Route::get('/episode/episode_edit/{id}', 'AdminSeriesController@EpisodeUploadEdit');
    Route::post('/EpisodeVideoUpload', 'AdminSeriesController@EpisodeVideoUpload');
    Route::get('/episode/subtitle/delete/{id}', ['before' => 'demo', 'uses' => 'AdminSeriesController@subtitledestroy']);

    Route::post('/AWSEpisodeUpload', 'AdminSeriesController@AWSEpisodeUpload');
    Route::get('/episode/AWSepisode_edit/{id}', 'AdminSeriesController@AWSEpisodeUploadEdit');
    Route::post('/AWSEpisodeVideoUpload', 'AdminSeriesController@AWSEpisodeVideoUpload');

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

    Route::get('/schedule/delete/{id}', 'AdminVideosController@ScheduledVideoDelete');

    /*  Channel Videos Setting  */

    Route::get('/video-scheduler', 'AdminChannelVideoController@ChannelVideoScheduler')->name('VideoScheduler');
    Route::get('/filter-scheduler', 'AdminChannelVideoController@FilterVideoScheduler')->name('FilterScheduler');
        
    /*  Videos Setting  */

    Route::get('/video-schedule', 'AdminVideosController@ScheduleVideo');
    Route::post('/video-schedule/store', 'AdminVideosController@ScheduleStore');
    Route::get('/video-schedule/edit/{id}', 'AdminVideosController@ScheduleEdit');
    Route::get('/video-schedule/delete/{id}', 'AdminVideosController@ScheduleDelete');
    Route::post('/video-schedule/update', 'AdminVideosController@ScheduleUpdate');

    Route::get('/manage/schedule/{id}', 'AdminVideosController@ManageSchedule');
    Route::post('/calendar/schedule', 'AdminVideosController@CalendarSchedule');
    Route::post('/schedule/uploadFile', 'AdminVideosController@ScheduleUploadFile');
    Route::get('/IndexScheduledVideos', 'AdminVideosController@IndexScheduledVideos');
    Route::post('/dragdropScheduledVideos', 'AdminVideosController@DragDropScheduledVideos');
    Route::post('/reschedule_oneday', 'AdminVideosController@ReScheduleOneDay');
    Route::post('/reschedule_week', 'AdminVideosController@ReScheduleWeek');
    Route::get('/ScheduleVideoBulk_delete', 'AdminVideosController@ScheduleVideoBulk_delete')->name('ScheduleVideoBulk_delete');

    Route::get('/video-event', 'AdminVideosController@calendarEvent');
    Route::post('/video-crud-ajax', 'AdminVideosController@calendarEventsAjax');

    /*  Email Setting  */

    Route::get('/email_settings', 'AdminEmailSettingsController@index')->name('email_settings');
    Route::post('/email_settings/save', 'AdminEmailSettingsController@store');
    Route::post('/Testing_EmailSettting', 'AdminEmailSettingsController@Testing_EmailSettting');
    Route::get('/email_logs', 'AdminEmailSettingsController@email_logs')->name('email_logs');
    Route::get('/email_template_testing', 'AdminEmailSettingsController@email_template_testing')->name('email_template_testing');

    /*  Storage Setting  */

    Route::get('/storage_settings', 'AdminStorageSettingsController@Index')->name('storage_settings');
    Route::post('/storage_settings/save', 'AdminStorageSettingsController@Store');

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

    Route::post('/m3u8url', 'AdminVideosController@m3u8url');
    Route::post('/embededcode', 'AdminVideosController@Embededcode');
    Route::post('/mp4url', 'AdminVideosController@Mp4url');
    Route::post('/uploadFile', 'AdminVideosController@uploadFile');
    Route::post('/uploadEditVideo', 'AdminVideosController@uploadEditVideo');
    Route::post('/AWSuploadEditVideo', 'AdminVideosController@AWSuploadEditVideo');
    Route::post('/upload_bunny_cdn_video', 'AdminVideosController@UploadBunnyCDNVideo');
    Route::post('/bunnycdn_videolibrary', 'AdminVideosController@BunnycdnVideolibrary');
    Route::post('/stream_bunny_cdn_video', 'AdminVideosController@StreamBunnyCdnVideo');

    Route::post('/AWSUploadFile', 'AdminVideosController@AWSUploadFile');

    Route::post('/Updatem3u8url', 'AdminVideosController@Updatem3u8url');
    Route::post('/UpdateEmbededcode', 'AdminVideosController@UpdateEmbededcode');
    Route::post('/Updatemp4url', 'AdminVideosController@Updatemp4url');

    /*Audio Uploads */

    Route::post('/uploadAudio', 'AdminAudioController@uploadAudio');
    Route::post('/Audiofile', 'AdminAudioController@Audiofile');
    Route::post('/AWSUploadAudio', 'AdminAudioController@AWSUploadAudio');
    Route::post('/AudioLivefile', 'AdminAudioController@AudioLivefile');

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
    Route::get('/moderator/payouts', 'ModeratorsUserController@Payouts');
    Route::get('/moderator/edit_payouts/{id}', 'ModeratorsUserController@EditPayouts');
    Route::get('/moderator/view_payouts/{id}', 'ModeratorsUserController@ViewPayouts');
    Route::post('/moderator/update_payouts', 'ModeratorsUserController@UpdatePayouts');

    // ExecuteShell Command For Maintanace sytsem

    // Route::get('/execute-shell', 'HomeController@ExecuteShell');

    // Channel Payouts

    Route::get('/channel/payouts', 'ChannelPayoutController@Payouts');
    Route::get('/channel/edit_payouts/{id}', 'ChannelPayoutController@EditPayouts');
    Route::get('/channel/view_payouts/{id}', 'ChannelPayoutController@ViewPayouts');
    Route::post('/channel/update_payouts', 'ChannelPayoutController@UpdatePayouts');

    // Video Move to partner
    Route::get('/assign_videos/partner', 'AdminVideosController@indexCPPPartner');
    Route::post('/move/cpp-partner', 'AdminVideosController@MoveCPPPartner');

    Route::get('/assign_videos/channel_partner', 'AdminVideosController@indexChannelPartner');
    Route::post('/move/channel-partner', 'AdminVideosController@MoveChannelPartner');

    // Series Move to partner

    Route::get('/assign_Series/partner', 'AdminSeriesController@indexCPPPartner');
    Route::post('/MoveSeries/cpp-partner', 'AdminSeriesController@MoveCPPPartner');

    Route::get('/assign_Series/channel_partner', 'AdminSeriesController@indexChannelPartner');
    Route::post('/MoveSeries/channel-partner', 'AdminSeriesController@MoveChannelPartner');

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
    Route::post('/analytics/RevenueRegionCSV', 'AdminUsersController@RevenueRegionCSV');

    Route::get('/analytics/PlayerVideoAnalytics', 'AdminPlayerAnalyticsController@PlayerVideoAnalytics');
    Route::post('/analytics/playervideos_start_date_url', 'AdminPlayerAnalyticsController@PlayerVideosStartDateRecord');
    Route::post('/analytics/playervideos_end_date_url', 'AdminPlayerAnalyticsController@PlayerVideosEndDateRecord');
    Route::post('/analytics/playervideos_export', 'AdminPlayerAnalyticsController@PlayerVideosExport');
    // Route::post('/admin/subscriber_end_date_url', 'AdminUsersController@SubscriberRevenueStartEndDateRecord');
    Route::post('/analytics/PlayerVideoDateAnalytics', 'AdminPlayerAnalyticsController@PlayerVideoDateAnalytics');

    Route::get('/analytics/RegionVideoAnalytics', 'AdminPlayerAnalyticsController@RegionVideoAnalytics');
    Route::post('/analytics/VideoRegionAnalyticsCSV', 'AdminPlayerAnalyticsController@VideoRegionAnalyticsCSV');

    Route::get('/analytics/PlayerUserAnalytics', 'AdminPlayerAnalyticsController@PlayerUserAnalytics');
    Route::post('/analytics/playerusers_start_date_url', 'AdminPlayerAnalyticsController@PlayerUsersStartDateRecord');
    Route::post('/analytics/playerusers_end_date_url', 'AdminPlayerAnalyticsController@PlayerUsersEndDateRecord');
    Route::post('/analytics/playerusers_export', 'AdminPlayerAnalyticsController@PlayerUsersExport');
    Route::post('/analytics/PlayerUserDateAnalytics', 'AdminPlayerAnalyticsController@PlayerUserDateAnalytics');

    Route::get('/analytics/PlayerSeekUserTimeAnalytics', 'AdminPlayerAnalyticsController@PlayerSeekTimeAnalytics');
    Route::post('/analytics/PlayerUserSeekTime_export', 'AdminPlayerAnalyticsController@PlayerSeekTimeExport');
    Route::post('/analytics/PlayerSeekUserTimeDateAnalytics', 'AdminPlayerAnalyticsController@PlayerSeekTimeDateAnalytics');

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
    Route::post('/VideoByRegionCSV', 'AdminUsersController@VideoByRegionCSV');
    Route::post('/enable_multi_currency', 'AdminCurrencySettings@enable_multi_currency');

    // Geofencing
    Route::get('/Geofencing', 'GeofencingController@index');
    Route::get('/Geofencing/create', 'GeofencingController@create');
    Route::post('/Geofencing/store', 'GeofencingController@store');

    // Seeding
    Route::get('/Seeding', 'AdminSeederController@index')->name('seeding-index');
    Route::post('/Seeding/run', 'AdminSeederController@unique_seeding')->name('seeding-run');
    Route::get('/Seeding/refresh', 'AdminSeederController@refresh_seeding')->name('seeding-refresh');

    Route::get('/Planstate', 'AdminUsersController@PlanState');
    Route::get('/Plancity', 'AdminUsersController@PlanCity');
    Route::post('/getState', 'AdminUsersController@GetState');
    Route::post('/getCity', 'AdminUsersController@GetCity');
    Route::get('/cppusers_videodata', 'AdminVideosController@CPPVideos');
    Route::get('/CPPVideosIndex', 'AdminVideosController@CPPVideosIndex');
    Route::get('/CPPVideosApproval/{id}', 'AdminVideosController@CPPVideosApproval');
    Route::get('/CPPVideosReject/{id}', 'AdminVideosController@CPPVideosReject');
    Route::get('/PlanAllCountry', 'AdminUsersController@PlanAllCountry');
    Route::get('/PlanAllCity', 'AdminUsersController@PlanAllCity');
    Route::get('/CPPLiveVideosIndex', 'AdminLiveStreamController@CPPLiveVideosIndex');
    Route::get('/CPPLiveVideosApproval/{id}', 'AdminLiveStreamController@CPPLiveVideosApproval');
    Route::get('/CPPLiveVideosReject/{id}', 'AdminLiveStreamController@CPPLiveVideosReject');

    Route::get('/ChannelVideosIndex', 'AdminVideosController@ChannelVideosIndex');
    Route::get('/ChannelVideosApproval/{id}', 'AdminVideosController@ChannelVideosApproval');
    Route::get('/ChannelVideosReject/{id}', 'AdminVideosController@ChannelVideosReject');

    Route::get('/ChannelLiveVideosIndex', 'AdminLiveStreamController@ChannelLiveVideosIndex');
    Route::get('/ChannelLiveVideosApproval/{id}', 'AdminLiveStreamController@ChannelLiveVideosApproval');
    Route::get('/ChannelLiveVideosReject/{id}', 'AdminLiveStreamController@ChannelLiveVideosReject');

    Route::get('/ChannelSeriesIndex', 'AdminSeriesController@ChannelSeriesIndex');
    Route::get('/ChannelSeriesApproval/{id}', 'AdminSeriesController@ChannelSeriesApproval');
    Route::get('/ChannelSeriesReject/{id}', 'AdminSeriesController@ChannelSeriesReject');

    Route::get('/CPPSeriesIndex', 'AdminSeriesController@CPPSeriesIndex');
    Route::get('/CPPSeriesApproval/{id}', 'AdminSeriesController@CPPSeriesApproval');
    Route::get('/CPPSeriesReject/{id}', 'AdminSeriesController@CPPSeriesReject');

    Route::get('/ChannelAudioIndex', 'AdminAudioController@ChannelAudioIndex');
    Route::get('/ChannelAudioApproval/{id}', 'AdminAudioController@ChannelAudioApproval');
    Route::get('/ChannelAudioReject/{id}', 'AdminAudioController@ChannelAudioReject');

    Route::get('/CPPAudioIndex', 'AdminAudioController@CPPAudioIndex');
    Route::get('/CPPAudioApproval/{id}', 'AdminAudioController@CPPAudioApproval');
    Route::get('/CPPAudioReject/{id}', 'AdminAudioController@CPPAudioReject');

    Route::get('/approval-live-event-artist', 'AdminLiveEventArtist@CPPLiveEventIndex')->name('approval_live_event_artist');
    Route::get('/live-event-artist-cpp-Approval/{id}', 'AdminLiveEventArtist@CPPLiveEventApproval')->name('CPP_Approval_live_event_artist');
    Route::get('/live-event-artist-cpp-Reject/{id}', 'AdminLiveEventArtist@CPPLiveEventReject')->name('CPP_Reject_live_event_artist');

    Route::get('/channel-approval-live-event-artist', 'AdminLiveEventArtist@ChannelLiveEventIndex')->name('channelapproval_live_event_artist');
    Route::get('/live-event-artist-channel-Approval/{id}', 'AdminLiveEventArtist@ChannelLiveEventtApproval')->name('Channel_Approval_live_event_artist');
    Route::get('/live-event-artist-channel-Reject/{id}', 'AdminLiveEventArtist@ChannelLiveEventReject')->name('CPP_Reject_live_event_artist');

    // Test Server Video Upload

    Route::get('/test/videoupload', 'AdminVideosController@TestServerUpload');
    Route::post('/test/server/videoupload/', 'AdminVideosController@TestServerFileUpload');

    // TV SETTINGS

    Route::get('/tv-settings/index', 'AdminTvSettingsController@index')->name('TV_Settings_Index');
    Route::get('/tv-settings/edit/{id}', 'AdminTvSettingsController@edit')->name('TV_Settings_Edit');
    Route::post('/tv-settings/update','AdminTvSettingsController@update')->name('TV_Settings_Update');
});

Route::get('admin/channel/pendingusers', 'ChannelLoginController@PendingUsers')->name('ChannelPendingUsers');
Route::get('admin/channel/view-channel-members', 'ChannelLoginController@ViewChannelMembers');
Route::get('admin/channel/commission', 'ChannelLoginController@Commission');
Route::post('admin/channel/add/commission', 'ChannelLoginController@AddCommission');
Route::get('admin/channel/user/delete/{id}', 'ChannelLoginController@destroy');
Route::get('admin/channel/user/create', 'ChannelLoginController@ChannelCreate');
Route::get('admin/channel/user/edit/{id}', 'ChannelLoginController@ChannelEdit');
Route::post('admin/channel/user/update', 'ChannelLoginController@ChannelUpdate');
Route::post('admin/channel/user/store', 'ChannelLoginController@ChannelStore');

Route::get('admin/ChannelUsersApproval/{id}', 'ChannelLoginController@ChannelUsersApproval');
Route::get('admin/ChannelUsersReject/{id}', 'ChannelLoginController@ChannelUsersReject');

Route::get('admin/cpp/pendingusers', 'ModeratorsUserController@PendingUsers')->name('CPP_PendingUsers');

Route::get('admin/CPPModeratorsApproval/{id}', 'ModeratorsUserController@CPPModeratorsApproval');
Route::get('admin/CPPModeratorsReject/{id}', 'ModeratorsUserController@CPPModeratorsReject');

Route::get('device/logout/verify/{userIp}/{id}', 'AdminUsersController@VerifyDevice');
Route::get('device/logout/{userIp}/{id}', 'AdminUsersController@DeviceLogout');
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

Route::get('cpp/signup/', 'ModeratorsLoginController@index')->name('CPPRegister');
Route::get('/cpp', 'ModeratorsLoginController@Signin')->name('CPPSignin');
// Route::post('cpp/home',  'ModeratorsLoginController@Login')->name('CPPLogin');
Route::get('cpp/login', 'ModeratorsLoginController@Signin')->name('CPPSignin');
// Route::post('cpp/home',  'ModeratorsLoginController@Login')->name('CPPLogin');
Route::post('cpp/moderatoruser/store', 'ModeratorsLoginController@Store')->name('CPPLogin');
Route::get('/cpp/verify-request', 'ModeratorsLoginController@VerifyRequest');
Route::get('/cpp/verify/{activation_code}', 'ModeratorsLoginController@Verify');

Route::get('/emailvalidation', 'SignupController@EmailValidation');
Route::get('/usernamevalidation', 'SignupController@UsernameValidation');

// Paypal Controllers
Route::get('paywithpaypal', ['as' => 'paywithpaypal', 'uses' => 'PaypalController@payWithPaypal']);
// route for post request
// Route::post('paypal', array('as' => 'paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
// route for check status responce
Route::get('paypal', ['as' => 'status', 'uses' => 'PaypalController@getPaymentStatus']);
Route::get('/subscribe/paypal', 'paypalcontroller@paypalredirect')->name('paypal.redirect');
Route::get('/subscribe/paypal/return', 'paypalcontroller@paypalreturn')->name('paypal.return');
// Route::get('create_paypal_plan', 'PaypalController@create_plan');
Route::get('admin/payment_test', 'AdminPaymentManagementController@PaymentIndex');

Route::post('cpp/home', 'ModeratorsLoginController@Login')->name('CPPLogin');

Route::get('cpp/password/reset', 'ModeratorsLoginController@PasswordReset')->name('CPPPasswordRset');
Route::get('cpp/password/reset/{email}/{token}', 'ModeratorsLoginController@VerifyPasswordReset')->name('CPPPasswordRset');
Route::post('cpp/resetpassword', 'ModeratorsLoginController@ResetPassword')->name('CPPResetPassword');
Route::post('cpp/Verify_Reset_Password', 'ModeratorsLoginController@VerifyResetPassword')->name('VerifyResetPassword');

// CPP Middlware     

Route::group(['prefix' => 'cpp', 'middleware' => ['cpp']], function () {
    // Route::middleware(['prefix' => 'cpp' ,cpp::class])->group(function(){
    // Route::get('/Homeone',  'ModeratorsLoginController@Home');

    // CPP Live Event for artist
    Route::get('/live-event-artist', 'CPPLiveEventArtist@CPPindex')->name('cpp_live_event_artist');

    Route::get('/live-event-artist', 'CPPLiveEventArtist@index')->name('cpp_live_event_artist');
    Route::get('/live-event-create', 'CPPLiveEventArtist@create')->name('cpp_live_event_create');
    Route::post('/live-event-store', 'CPPLiveEventArtist@store')->name('cpp_live_event_store');
    Route::get('/live-event-edit/{id}', 'CPPLiveEventArtist@edit')->name('cpp_live_event_edit');
    Route::post('/live-event-update/{id}', 'CPPLiveEventArtist@update')->name('cpp_live_event_update');
    Route::get('/live-event-destroy/{id}', 'CPPLiveEventArtist@destroy')->name('cpp_live_event_destroy');

    Route::get('payouts', 'CPPAnalyticsController@UserPayouts');
    Route::post('payouts_startdate_analytics', 'CPPAnalyticsController@PayoutsStartDateAnalytics');
    Route::post('payouts_enddate_analytics', 'CPPAnalyticsController@PayoutsEndDateAnalytics');
    Route::post('payouts_exportCsv', 'CPPAnalyticsController@PayoutsExportCsv');

    Route::get('live-payouts', 'CPPAnalyticsController@LivePayouts');
    Route::post('live-payouts_startdate_analytics', 'CPPAnalyticsController@LivePayoutsStartDateAnalytics');
    Route::post('live-payouts_enddate_analytics', 'CPPAnalyticsController@LivePayoutsEndDateAnalytics');
    Route::post('live-payouts_exportCsv', 'CPPAnalyticsController@LivePayoutsExportCsv');

    Route::get('video-analytics', 'CPPAnalyticsController@IndexVideoAnalytics');
    Route::post('video_startdate_analytics', 'CPPAnalyticsController@VideoStartDateAnalytics');
    Route::post('video_enddate_analytics', 'CPPAnalyticsController@VideoEndDateAnalytics');
    Route::post('video_exportCsv', 'CPPAnalyticsController@VideoExportCsv');

    Route::get('myprofile', 'ModeratorsUserController@CPPMyProfile');
    Route::post('update-myprofile', 'ModeratorsUserController@CPPUpdateMyProfile');

    Route::get('my-account', 'ModeratorsUserController@CPPmyaccount');
    Route::post('update-account', 'ModeratorsUserController@CPPUpdateMyAccount');

    Route::get('/view_by_region', 'ModeratorsUserController@CPPViewsRegion');
    Route::get('/regionvideos', 'ModeratorsUserController@CPPRegionVideos');
    Route::get('/Allregionvideos', 'ModeratorsUserController@CPPAllRegionVideos');

    Route::get('/dashboard', 'ModeratorsLoginController@IndexDashboard');
    Route::get('/logout', 'ModeratorsLoginController@logout');
    
    //  CPP Video Management
    Route::get('/videos', 'CPPAdminVideosController@CPPindex');
    Route::get('/videos/edit/{id}', 'CPPAdminVideosController@CPPedit');
    Route::get('/videos/editvideo/{id}', 'CPPAdminVideosController@CPPeditvideo');
    Route::post('/Updatem3u8url', 'CPPAdminVideosController@Updatem3u8url');
    Route::post('/UpdateEmbededcode', 'CPPAdminVideosController@UpdateEmbededcode');
    Route::post('/Updatemp4url', 'CPPAdminVideosController@Updatemp4url');
    Route::post('/uploadEditVideo', 'CPPAdminVideosController@uploadEditVideo');
    Route::post('/AWSuploadEditVideo', 'CPPAdminVideosController@AWSuploadEditVideo');
    Route::get('/videos/delete/{id}', ['before' => 'demo', 'uses' => 'CPPAdminVideosController@CPPdestroy']);
    Route::get('/videos/create', 'CPPAdminVideosController@CPPcreate');
    Route::post('/videos/fileupdate', ['before' => 'demo', 'uses' => 'CPPAdminVideosController@CPPfileupdate']);
    Route::post('/videos/store', ['before' => 'demo', 'uses' => 'CPPAdminVideosController@CPPstore']);
    Route::post('/videos/update', ['before' => 'demo', 'uses' => 'CPPAdminVideosController@Cppupdate']);
    Route::get('/category/videos/{slug}', 'CPPChannelController@PlayVideo');
    Route::get('/category/videos/{slug}', 'CPPChannelController@PlayVideo');

    Route::get('/cppusers_videodata', 'CPPAdminVideosController@CPPVideo');
    Route::get('/CPPlive_search', 'CPPAdminVideosController@CPPlive_search');
    Route::post('/m3u8url', 'CPPAdminVideosController@CPPm3u8url');
    Route::post('/embededcode', 'CPPAdminVideosController@CPPEmbededcode');
    Route::post('/mp4url', 'CPPAdminVideosController@CPPMp4url');
    Route::post('/uploadFile', 'CPPAdminVideosController@CPPuploadFile');

    // CPP Video Categories

    Route::post('/videos/categories/store', ['before' => 'demo', 'uses' => 'CPPAdminVideoCategoriesController@CPPstore']);
    Route::post('/videos/categories/order', ['before' => 'demo', 'uses' => 'CPPAdminVideoCategoriesController@CPPorder']);
    Route::get('/videos/categories/edit/{id}', 'CPPAdminVideoCategoriesController@CPPedit');
    Route::post('/videos/categories/update', 'CPPAdminVideoCategoriesController@CPPupdate');
    Route::get('/videos/categories/delete/{id}', ['before' => 'demo', 'uses' => 'CPPAdminVideoCategoriesController@CPPdestroy']);
    Route::post('/category_order', 'CPPAdminVideoCategoriesController@CPPcategory_order');
    Route::get('/videos/categories', 'CPPAdminVideoCategoriesController@CPPindex');

    // CPP Audios Categories

    Route::get('/audios', 'CPPAdminAudioController@CPPindex');
    Route::get('/audios/edit/{id}', 'CPPAdminAudioController@CPPedit');
    Route::post('/audios/update', ['before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPupdate']);
    Route::get('/audios/delete/{id}', ['before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPdestroy']);
    Route::get('/audios/create', 'CPPAdminAudioController@CPPcreate');
    Route::post('/audios/store', ['before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPstore']);
    Route::post('/uploadAudio', 'CPPAdminAudioController@CPPuploadAudio');
    Route::post('/Audiofile', 'CPPAdminAudioController@CPPAudiofile');
    Route::post('/audios/audioupdate', ['before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPaudioupdate']);
    Route::get('audio/{slug}', 'CPPAdminAudioController@play_audios')->name('play_audios');

    //CPP Audio Categories
    Route::get('/audios/categories', 'CPPAdminAudioCategoriesController@CPPindex');
    Route::post('/audios/categories/store', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPstore']);
    Route::post('/audios/categories/order', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPorder']);
    Route::get('/audios/categories/edit/{id}', 'CPPAdminAudioCategoriesController@CPPedit');
    Route::post('/audios/categories/update', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPupdate']);
    Route::get('/audios/categories/delete/{id}', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPdestroy']);

    //CPP Series  Manage

    Route::get('/series-list', 'CPPSeriesController@index');
    Route::get('/series_list', 'CPPSeriesController@index');
    Route::get('/series/create', 'CPPSeriesController@create');
    Route::get('/series_create', 'CPPSeriesController@create');
    Route::post('/series/store', 'CPPSeriesController@store');
    Route::get('/series/edit/{id}', 'CPPSeriesController@edit');
    Route::post('/series/update', 'CPPSeriesController@update');
    Route::get('/series/delete/{id}', 'CPPSeriesController@destroy');
    Route::get('/titlevalidation', 'CPPSeriesController@TitleValidation');
    Route::post('/episode_order', 'CPPSeriesController@episode_order');

    //CPP Series Season Manage
    // Route::get('/season/create/{id}', 'CPPSeriesController@create_season');
    Route::post('/season/create/', 'CPPSeriesController@create_season');
    Route::get('/season/edit/{series_id}/{season_id}', 'CPPSeriesController@manage_season');
    Route::get('/season/edit/{season_id}', 'CPPSeriesController@Edit_season');
    Route::post('/season/update', 'CPPSeriesController@Update_season');
    Route::get('/season/delete/{id}', 'CPPSeriesController@destroy_season');

    //CPP Series Episode Manage

    Route::post('/episode/create', 'CPPSeriesController@create_episode');
    Route::get('/episode/delete/{id}', 'CPPSeriesController@destroy_episode');
    Route::get('/episode/edit/{id}', 'CPPSeriesController@edit_episode');
    Route::post('/episode/update', 'CPPSeriesController@update_episode');
    Route::post('/episode_upload', 'CPPSeriesController@EpisodeUpload');
    Route::post('/uploadepisodeedit', 'CPPSeriesController@EpisodeUploadEdit');
    Route::get('episode/{series_name}/{episode_name}', 'CPPSeriesController@play_episode');

    //Artist Routes
    Route::get('/artists', 'CPPAdminArtistsController@CPPindex');
    Route::get('/artists/create', 'CPPAdminArtistsController@CPPcreate');
    Route::post('/artists/store', 'CPPAdminArtistsController@CPPstore');
    Route::get('/artists/edit/{id}', 'CPPAdminArtistsController@CPPedit');
    Route::post('/artists/update', 'CPPAdminArtistsController@CPPupdate');
    Route::get('/artists/delete/{id}', 'CPPAdminArtistsController@CPPdestroy');
    Route::post('/audios/audioupdate', ['before' => 'demo', 'uses' => 'CPPAdminAudioController@CPPaudioupdate']);
    Route::get('/artist_slug_validation', 'CPPAdminArtistsController@artist_slug_validation');

    //Admin Audio Albums
    Route::get('/audios/albums', 'CPPAdminAudioCategoriesController@CPPalbumIndex');
    Route::post('/audios/albums/store', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPstoreAlbum']);
    Route::post('/audios/albums/order', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPorderAlbum']);
    Route::get('/audios/albums/edit/{id}', 'CPPAdminAudioCategoriesController@CPPeditAlbum');
    Route::post('/audios/albums/update', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPupdateAlbum']);
    Route::get('/audios/albums/delete/{id}', ['before' => 'demo', 'uses' => 'CPPAdminAudioCategoriesController@CPPdestroyAlbum']);

    // CPP Page

    Route::get('/pages', 'CPPAdminPageController@CPPindex');
    Route::get('/pages/create', 'CPPAdminPageController@CPPcreate');
    Route::post('/pages/store', 'CPPAdminPageController@CPPstore');
    Route::get('/pages/edit/{id}', 'CPPAdminPageController@CPPedit');
    Route::post('/pages/update', 'CPPAdminPageController@CPPupdate');
    Route::get('/pages/delete/{id}', 'CPPAdminPageController@CPPdestroy');

    // CPP Livestream

    Route::get('/livestream', 'CPPAdminLiveStreamController@CPPindex');
    Route::get('/livestream/edit/{id}', 'CPPAdminLiveStreamController@CPPedit');
    Route::post('/livestream/update', 'CPPAdminLiveStreamController@CPPupdate');
    Route::get('/livestream/delete/{id}', ['before' => 'demo', 'uses' => 'CPPAdminLiveStreamController@CPPdestroy']);
    Route::get('/livestream/create', 'CPPAdminLiveStreamController@CPPcreate');

    Route::post('/livestream/store', ['before' => 'demo', 'uses' => 'CPPAdminLiveStreamController@CPPstore']);

    // CPP Livestream Categories

    Route::get('/livestream/categories', ['before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPindex']);
    Route::post('/livestream/categories/store', ['before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPstore']);
    Route::post('/livestream/categories/order', ['before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPorder']);
    Route::get('/livestream/categories/edit/{id}', 'CPPAdminLiveCategoriesController@CPPedit');
    Route::post('/livestream/categories/update', 'CPPAdminLiveCategoriesController@CPPupdate');
    Route::get('/livestream/categories/delete/{id}', ['before' => 'demo', 'uses' => 'CPPAdminLiveCategoriesController@CPPdestroy']);
});

Route::get('/channel', 'ChannelLoginController@index');
Route::get('/channel/login', 'ChannelLoginController@index');
Route::get('/channel/register', 'ChannelLoginController@register');
Route::post('channel/store', 'ChannelLoginController@Store');
Route::get('/channel/verify-request', 'ChannelLoginController@VerifyRequest');
Route::get('/channel/verify/{activation_code}', 'ChannelLoginController@Verify');
Route::get('/channel/emailvalidation', 'SignupController@EmailValidation');
Route::post('/channel/home', 'ChannelLoginController@Login');
Route::get('channel/password/reset', 'ChannelLoginController@PasswordRset')->name('channelPasswordRset');
Route::post('channel/resetpassword', 'ChannelLoginController@ResetPassword')->name('channelResetPassword');
Route::get('channel/password/reset/{email}/{token}', 'ChannelLoginController@VerifyPasswordReset')->name('CPPPasswordRset');
Route::post('channel/Verify_Reset_Password', 'ChannelLoginController@VerifyResetPassword')->name('VerifyResetPassword');

Route::group(['prefix' => 'channel', 'middleware' => ['channel']], function () {
    Route::get('/logout', 'ChannelLoginController@Logout');

    // Route::get('episode/{episode_name}', 'ChannelSeriesController@PlayEpisode');
    Route::get('/get_processed_percentage/{id}', 'AdminVideosController@get_processed_percentage');

    // Channel Live Event for artist
    Route::get('/live-event-artist', 'ChannelLiveEventArtist@index')->name('channel_live_event_artist');
    Route::get('/live-event-create', 'ChannelLiveEventArtist@create')->name('channel_live_event_create');
    Route::post('/live-event-store', 'ChannelLiveEventArtist@store')->name('channel_live_event_store');
    Route::get('/live-event-edit/{id}', 'ChannelLiveEventArtist@edit')->name('channel_live_event_edit');
    Route::post('/live-event-update/{id}', 'ChannelLiveEventArtist@update')->name('channel_live_event_update');
    Route::get('/live-event-destroy/{id}', 'ChannelLiveEventArtist@destroy')->name('channel_live_event_destroy');

    Route::get('video-analytics', 'ChannelAnalyticsController@IndexVideoAnalytics');
    Route::post('video_startdate_analytics', 'ChannelAnalyticsController@VideoStartDateAnalytics');
    Route::post('video_enddate_analytics', 'ChannelAnalyticsController@VideoEndDateAnalytics');
    Route::post('video_exportCsv', 'ChannelAnalyticsController@VideoExportCsv');
    Route::get('/category/videos/{slug}', 'ChannelVideosController@PlayVideo');

    Route::get('payouts', 'ChannelAnalyticsController@UserPayouts');
    Route::post('payouts_startdate_analytics', 'ChannelAnalyticsController@PayoutsStartDateAnalytics');
    Route::post('payouts_enddate_analytics', 'ChannelAnalyticsController@PayoutsEndDateAnalytics');
    Route::post('payouts_exportCsv', 'ChannelAnalyticsController@PayoutsExportCsv');

    Route::get('myprofile', 'ChannelLoginController@ChannelMyProfile');
    Route::post('update-myprofile', 'ChannelLoginController@ChannelUpdateMyProfile');

    Route::get('/view_by_region', 'ChannelAnalyticsController@ChannelViewsRegion');
    Route::get('/regionvideos', 'ChannelAnalyticsController@ChannelRegionVideos');
    Route::get('/Allregionvideos', 'ChannelAnalyticsController@ChannelAllRegionVideos');

    Route::get('/dashboard', 'ChannelLoginController@IndexDashboard');
    Route::get('/logout', 'ChannelLoginController@logout');
    //  Channel Video Management
    Route::get('/videos', 'ChannelVideosController@Channelindex');
    Route::get('/videos/edit/{id}', 'ChannelVideosController@Channeledit');
    Route::get('/videos/editvideo/{id}', 'ChannelVideosController@Channeleditvideo');
    Route::post('/Updatem3u8url', 'ChannelVideosController@Updatem3u8url');
    Route::post('/UpdateEmbededcode', 'ChannelVideosController@UpdateEmbededcode');
    Route::post('/Updatemp4url', 'ChannelVideosController@Updatemp4url');
    Route::post('/uploadEditVideo', 'ChannelVideosController@uploadEditVideo');
    Route::post('/AWSuploadEditVideo', 'ChannelVideosController@AWSuploadEditVideo');
    Route::get('/videos/delete/{id}', ['before' => 'demo', 'uses' => 'ChannelVideosController@Channeldestroy']);
    Route::get('/videos/create', 'ChannelVideosController@Channelcreate');
    Route::post('/videos/fileupdate', ['before' => 'demo', 'uses' => 'ChannelVideosController@Channelfileupdate']);
    Route::post('/videos/store', ['before' => 'demo', 'uses' => 'ChannelVideosController@Channelstore']);
    Route::post('/videos/update', ['before' => 'demo', 'uses' => 'ChannelVideosController@Channelupdate']);

    Route::get('/Channelusers_videodata', 'ChannelVideosController@ChannelVideo');
    Route::get('/Channellive_search', 'ChannelVideosController@Channellive_search');
    Route::post('/m3u8url', 'ChannelVideosController@Channelm3u8url');
    Route::post('/embededcode', 'ChannelVideosController@ChannelEmbededcode');
    Route::post('/mp4url', 'ChannelVideosController@ChannelMp4url');
    Route::post('/uploadFile', 'ChannelVideosController@ChanneluploadFile');

    // Channel Video Categories

    Route::post('/videos/categories/store', ['before' => 'demo', 'uses' => 'ChannelVideoCategoriesController@Channelstore']);
    Route::post('/videos/categories/order', ['before' => 'demo', 'uses' => 'ChannelVideoCategoriesController@Channelorder']);
    Route::get('/videos/categories/edit/{id}', 'ChannelVideoCategoriesController@Channeledit');
    Route::post('/videos/categories/update', 'ChannelVideoCategoriesController@Channelupdate');
    Route::get('/videos/categories/delete/{id}', ['before' => 'demo', 'uses' => 'ChannelVideoCategoriesController@Channeldestroy']);
    Route::post('/category_order', 'ChannelVideoCategoriesController@Channelcategory_order');
    Route::get('/videos/categories', 'ChannelVideoCategoriesController@Channelindex');

    // Channel Audios Categories

    Route::get('/audios', 'ChannelAudioController@Channelindex');
    Route::get('/audios/edit/{id}', 'ChannelAudioController@Channeledit');
    Route::post('/audios/update', ['before' => 'demo', 'uses' => 'ChannelAudioController@Channelupdate']);
    Route::get('/audios/delete/{id}', ['before' => 'demo', 'uses' => 'ChannelAudioController@Channeldestroy']);
    Route::get('/audios/create', 'ChannelAudioController@Channelcreate');
    Route::post('/audios/store', ['before' => 'demo', 'uses' => 'ChannelAudioController@Channelstore']);
    Route::post('/uploadAudio', 'ChannelAudioController@ChanneluploadAudio');
    Route::post('/Audiofile', 'ChannelAudioController@ChannelAudiofile');
    Route::post('/audios/audioupdate', ['before' => 'demo', 'uses' => 'ChannelAudioController@Channelaudioupdate']);

    //Channel Audio Categories
    Route::get('/audios/categories', 'ChannelAudioCategoriesController@Channelindex');
    Route::post('/audios/categories/store', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@Channelstore']);
    Route::post('/audios/categories/order', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@Channelorder']);
    Route::get('/audios/categories/edit/{id}', 'ChannelAudioCategoriesController@Channeledit');
    Route::post('/audios/categories/update', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@Channelupdate']);
    Route::get('/audios/categories/delete/{id}', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@Channeldestroy']);

    // Audio Albums
    Route::get('/audios/albums', 'ChannelAudioCategoriesController@ChannelalbumIndex');
    Route::post('/audios/albums/store', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@ChannelstoreAlbum']);
    Route::post('/audios/albums/order', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@ChannelorderAlbum']);
    Route::get('/audios/albums/edit/{id}', 'ChannelAudioCategoriesController@ChanneleditAlbum');
    Route::post('/audios/albums/update', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@ChannelupdateAlbum']);
    Route::get('/audios/albums/delete/{id}', ['before' => 'demo', 'uses' => 'ChannelAudioCategoriesController@ChanneldestroyAlbum']);

    // Channel Page

    Route::get('/pages', 'ChannelPageController@Channelindex');
    Route::get('/pages/create', 'ChannelPageController@Channelcreate');
    Route::post('/pages/store', 'ChannelPageController@Channelstore');
    Route::get('/pages/edit/{id}', 'ChannelPageController@Channeledit');
    Route::post('/pages/update', 'ChannelPageController@Channelupdate');
    Route::get('/pages/delete/{id}', 'ChannelPageController@Channeldestroy');

    // Channel Livestream

    Route::get('/livestream', 'ChannelLiveStreamController@Channelindex');
    Route::get('/livestream/edit/{id}', 'ChannelLiveStreamController@Channeledit');
    Route::post('/livestream/update', 'ChannelLiveStreamController@Channelupdate');
    Route::get('/livestream/delete/{id}', ['before' => 'demo', 'uses' => 'ChannelLiveStreamController@Channeldestroy']);
    Route::get('/livestream/create', 'ChannelLiveStreamController@Channelcreate');

    Route::post('/livestream/store', ['before' => 'demo', 'uses' => 'ChannelLiveStreamController@Channelstore']);

    // Channel Livestream Categories

    Route::get('/livestream/categories', 'ChannelLiveCategoriesController@Channelindex');
    Route::post('/livestream/categories/store', 'ChannelLiveCategoriesController@Channelstore');
    Route::post('/livestream/categories/order', 'ChannelLiveCategoriesController@Channelorder');
    Route::get('/livestream/categories/edit/{id}', 'ChannelLiveCategoriesController@Channeledit');
    Route::post('/livestream/categories/update', 'ChannelLiveCategoriesController@Channelupdate');
    Route::get('/livestream/categories/delete/{id}', 'ChannelLiveCategoriesController@Channeldestroy');

    //Channel Series  Manage

    Route::get('/series-list', 'ChannelSeriesController@index');
    Route::get('/series_list', 'ChannelSeriesController@index');
    Route::get('/series/create', 'ChannelSeriesController@create');
    Route::get('/series_create', 'ChannelSeriesController@create');
    Route::post('/series/store', 'ChannelSeriesController@store');
    Route::get('/series/edit/{id}', 'ChannelSeriesController@edit');
    Route::post('/series/update', 'ChannelSeriesController@update');
    Route::get('/series/delete/{id}', 'ChannelSeriesController@destroy');
    Route::get('/titlevalidation', 'ChannelSeriesController@TitleValidation');
    Route::post('/episode_order', 'ChannelSeriesController@episode_order');

    //Channel Series Season Manage
    // Route::get('/season/create/{id}', 'ChannelSeriesController@create_season');
    Route::post('/season/create/', 'ChannelSeriesController@create_season');
    Route::get('/season/edit/{series_id}/{season_id}', 'ChannelSeriesController@manage_season');
    Route::get('/season/edit/{season_id}', 'ChannelSeriesController@Edit_season');
    Route::post('/season/update', 'ChannelSeriesController@Update_season');
    Route::get('/season/delete/{id}', 'ChannelSeriesController@destroy_season');

    //Channel Series Episode Manage

    Route::post('/episode/create', 'ChannelSeriesController@create_episode');
    Route::get('/episode/delete/{id}', 'ChannelSeriesController@destroy_episode');
    Route::get('/episode/edit/{id}', 'ChannelSeriesController@edit_episode');
    Route::post('/episode/update', 'ChannelSeriesController@update_episode');
    Route::post('/episode_upload', 'ChannelSeriesController@EpisodeUpload');
    Route::post('/uploadepisodeedit', 'ChannelSeriesController@EpisodeUploadEdit');
    Route::get('episode/{series_name}/{episode_name}', 'ChannelSeriesController@play_episode');

    //Artist Routes
    Route::get('artists', 'ChannelArtistsController@index');
    Route::get('artists/create', 'ChannelArtistsController@create');
    Route::post('artists/store', 'ChannelArtistsController@store');
    Route::get('artists/edit/{id}', 'ChannelArtistsController@edit');
    Route::post('artists/update', 'ChannelArtistsController@update');
    Route::get('artists/delete/{id}', 'ChannelArtistsController@destroy');

    Route::get('setting/bank_setting', 'ChannelSettingController@Accountindex');
    Route::get('setting/about_channel_setting', 'ChannelSettingController@Aboutindex');
    Route::post('setting/update-myprofile', 'ChannelSettingController@SaveAccount');
    Route::post('setting/update-channel', 'ChannelSettingController@UpdateChannel');
});

/*  Old CPP Rotues    */

//categories_audio
Route::get('categories_audio', function () {
    $response = DB::table('audio_categories')
        ->where('parent_id', '=', 0)
        ->get();
    return response()->json($response, 200);
});
//audios_list
Route::get('audios_list', function () {
    $response = DB::table('audio')->get();
    return response()->json($response, 200);
});
//audio_albums
Route::get('audio_albums', function () {
    $response = DB::table('audio_albums')->get();
    return response()->json($response, 200);
});
//audio_categories
Route::get('audio_categories', function () {
    $response = DB::table('audio_categories')->get();
    return response()->json($response, 200);
});
//artists_index
Route::get('artists_index', function () {
    $response = DB::table('artists')
        ->orderBy('created_at', 'DESC')
        ->paginate(9);
    return response()->json($response, 200);
});
//Role
Route::get('user_roles', function () {
    $response = DB::table('roles')->get();
    return response()->json($response, 200);
});
//site_themes
Route::get('site_themes', function () {
    $response = DB::table('site_themes')->first();
    return response()->json($response, 200);
});
//system_settings
Route::get('system_settings', function () {
    $response = DB::table('system_settings')->first();
    return response()->json($response, 200);
});
//home_settings
Route::get('home_settings', function () {
    $response = DB::table('home_settings')->first();
    return response()->json($response, 200);
});
//payment_settings
Route::get('payment_settings', function () {
    $response = DB::table('payment_settings')->first();
    return response()->json($response, 200);
});
//mobile_settings
Route::get('mobile_settings', function () {
    $response = DB::table('mobile_apps')->get();
    return response()->json($response, 200);
});
//mobileslider
Route::get('mobileslider', function () {
    $response = DB::table('mobile_sliders')->get();
    return response()->json($response, 200);
});
//paypalplans
Route::get('paypalplans', function () {
    $response = DB::table('paypal_plans')->get();
    return response()->json($response, 200);
});
//coupons
Route::get('coupons', function () {
    $response = DB::table('coupons')->get();
    return response()->json($response, 200);
});
//plans
Route::get('plans', function () {
    $response = DB::table('plans')->get();
    return response()->json($response, 200);
});
//livestream
Route::get('livestream_categories', function () {
    $response = DB::table('live_categories')
        ->where('parent_id', '=', 0)
        ->get();
    return response()->json($response, 200);
});
//livestream
Route::get('livestream', function () {
    $response = DB::table('live_streams')
        ->orderBy('created_at', 'DESC')
        ->paginate(9);
    return response()->json($response, 200);
});
//livestream
Route::get('live_categories', function () {
    $response = DB::table('live_categories')->get();
    return response()->json($response, 200);
});
//series
Route::get('series', function () {
    $response = DB::table('series')
        ->orderBy('created_at', 'DESC')
        ->paginate(9);
    return response()->json($response, 200);
});
//pages
Route::get('pages', function () {
    $response = DB::table('pages')
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
    return response()->json($response, 200);
});
//categories
Route::get('categories', function () {
    $response = DB::table('video_categories')
        ->where('parent_id', '=', 0)
        ->get();
    return response()->json($response, 200);
});
//video_categories
Route::get('video_categories', function () {
    $response = DB::table('video_categories')->get();
    return response()->json($response, 200);
});
//Videos
Route::get('videos', function () {
    $response = DB::table('videos')
        ->orderBy('created_at', 'DESC')
        ->paginate(9);
    return response()->json($response, 200);
});
//Videos_index
Route::get('videos_index', function () {
    $response = DB::table('videos')->get();
    return response()->json($response, 200);
});
//video_categories
Route::get('video_categories', function () {
    $response = DB::table('video_categories')->get();
    return response()->json($response, 200);
});
//video_subtitle
Route::get('video_subtitle', function () {
    $response = DB::table('videos_subtitles')->get();
    return response()->json($response, 200);
});
//languages
Route::get('languages', function () {
    $response = DB::table('video_languages')->get();
    return response()->json($response, 200);
});
//languages
Route::get('alllanguages', function () {
    $response = DB::table('languages')->get();
    return response()->json($response, 200);
});

//subtitles
Route::get('subtitles', function () {
    $response = DB::table('subtitles')->get();
    return response()->json($response, 200);
});
//artists
Route::get('artists', function () {
    $response = DB::table('artists')->get();
    return response()->json($response, 200);
});
//Menu
Route::get('menu', function () {
    $response = DB::table('menus')->get();
    return response()->json($response, 200);
});
// users
Route::get('users', function () {
    $response = DB::table('users')->get();
    return response()->json($response, 200);
});

//Country
Route::get('country', function () {
    $response = DB::table('countries')->get();
    return response()->json($response, 200);
});
//Palyer UI
Route::get('playerui_index', function () {
    $response = DB::table('playerui')->first();
    return response()->json($response, 200);
});
//Slider
Route::get('allCategories', function () {
    $response = DB::table('sliders')->get();
    return response()->json($response, 200);
});
// Moderator

Route::get('moderatorsrole', function () {
    $response = DB::table('moderators_roles')->get();
    return response()->json($response, 200);
});
// Moderator
Route::get('moderatorspermission', function () {
    $response = DB::table('moderators_permissions')->get();
    return response()->json($response, 200);
});
// moderatorsuser
Route::get('moderatorsuser', function () {
    $response = DB::table('moderators_users')->get();
    return response()->json($response, 200);
});
// ADMIN DASHBOARD
Route::get('settings', function () {
    $response = DB::table('settings')->first();
    return response()->json($response, 200);
});
// total_subscription
Route::get('total_subscription', function () {
    $response = DB::table('subscriptions')
        ->where('stripe_status', '=', 'active')
        ->count();
    return response()->json($response, 200);
});
// total_videos
Route::get('total_videos', function () {
    $response = DB::table('videos')
        ->where('active', '=', 1)
        ->count();
    return response()->json($response, 200);
});
// ppvvideo
Route::get('ppvvideo', function () {
    // $response = PpvVideo::where('active','=',1)->count();
    $response = DB::table('ppv_videos')
        ->where('active', '=', 1)
        ->count();
    return response()->json($response, 200);
});
// total_recent_subscription

Route::get('total_recent_subscription', function () {
    $response = DB::table('subscriptions')
        ->orderBy('created_at', 'DESC')
        ->whereDate('created_at', '>', \Carbon\Carbon::now()->today())
        ->count();
    return response()->json($response, 200);
});
// top_rated_videos
Route::get('top_rated_videos', function () {
    $response = DB::table('videos')
        ->where('rating', '>', 7)
        ->get();
    return response()->json($response, 200);
});
// recent_views
Route::get('recent_views', function () {
    $response = DB::table('recent_views')->get();
    return response()->json($response, 200);
});
// permission
Route::get('permission', function () {
    $response = DB::table('moderators_permissions')->get();
    return response()->json($response, 200);
});
Route::get('age_categorie', function () {
    $response = DB::table('age_categories')->get();
    return response()->json($response, 200);
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

Route::group(['middleware' => ['auth']], function () {
    Route::PATCH('/Profile-details/{id}', 'MultiprofileController@profile_details')->name('profile_details');
    Route::get('/profile_delete/{id}', 'MultiprofileController@profile_delete')->name('profile_delete');
    Route::get('/profile-details_edit/{id}', 'MultiprofileController@profileDetails_edit')->name('profile-details_edit');

    Route::resources([
        'Choose-profile' => MultiprofileController::class,
    ]);

    Route::get('/Multi-profile/create', 'MultiprofileController@Multi_Profile_Create')->name('Multi-profile-create');
    Route::post('/Multi-profile/store', 'MultiprofileController@Multi_Profile_Store')->name('Multi-profile-store');
});

// welcome-screen
Route::post('/welcome-screen', 'WelcomeScreenController@Screen_store')->name('welcome-screen');
Route::get('/welcome-screen/destroy/{id}', 'WelcomeScreenController@destroy')->name('welcomescreen_destroy');
Route::get('/welcome-screen/edit/{id}', 'WelcomeScreenController@edit')->name('welcomescreen_edit');
Route::post('/welcome-screen/update/{id}', 'WelcomeScreenController@update')->name('welcomescreen_update');

//    Theme Integration
Route::post('admin/ThemeIntegration/create', 'ThemeIntegrationController@create')->name('ThemeIntegration/create');
Route::get('admin/ThemeIntegration/set_theme', 'ThemeIntegrationController@set_theme')->name('ThemeIntegration/set_theme');
Route::post('admin/ThemeIntegration/uniquevalidation', 'ThemeIntegrationController@uniquevalidation')->name('ThemeIntegration/uniquevalidation');

Route::group(['middleware' => ['CheckAuthTheme5']], function () {
    Route::get('Movie-Description', 'HomeController@Movie_description');

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
    Route::get('LiveCategory/{slug}', 'ChannelController@LiveCategory')->name('LiveCategory');
    Route::get('CategoryLive/', 'ChannelController@CategoryLive')->name('CategoryLive');

    Route::get('audios/category/{slug}', 'HomePageAudioController@AudioCategory')->name('AudioCategory');
    Route::get('AudiocategoryList', 'HomePageAudioController@AudiocategoryList')->name('AudiocategoryList');

    Route::get('series/category/{slug}', 'TvshowsController@SeriesCategory')->name('SeriesCategory');
    Route::get('SeriescategoryList', 'TvshowsController@SeriescategoryList')->name('SeriescategoryList');
    Route::get('Series/category/list', 'TvshowsController@SeriescategoryList')->name('SeriescategoryList');

    Route::get('tv-shows/networks/{slug}', 'TvshowsController@Specific_Series_Networks')->name('Specific_Series_Networks');
    Route::get('tv-shows/networks-list', 'TvshowsController@Series_Networks_List')->name('Series_Networks_List');

    // Filter
    Route::get('categoryfilter', 'ChannelController@categoryfilter')->name('categoryfilter');

    // Landing page  category videos
    Route::get('landing_category_series', 'LandingpageController@landing_category_series')->name('landing_category_series');

    // Channel List
    Route::get('channel/{slug}', 'ChannelHomeController@ChannelHome')->name('ChannelHome');
    Route::get('Channel-list', 'ChannelHomeController@ChannelList')->name('ChannelList');
    Route::get('channel_category_series', 'ChannelHomeController@channel_category_series')->name('channel_category_series');
    Route::get('channel_category_videos', 'ChannelHomeController@channel_category_videos')->name('channel_category_videos');
    Route::get('channel_category_audios', 'ChannelHomeController@channel_category_audios')->name('channel_category_audios');
    Route::get('channel_category_live', 'ChannelHomeController@channel_category_live')->name('channel_category_live');
    Route::get('all_Channel_videos', 'ChannelHomeController@all_Channel_videos')->name('all_Channel_videos');
    Route::get('Channel/Audios-list/{channel_slug}', 'ChannelHomeController@Channel_Audios_list')->name('Channel_Audios_list');
    Route::get('Channel/livevideos-list/{channel_slug}', 'ChannelHomeController@Channel_livevideos_list')->name('Channel_livevideos_list');
    Route::get('Channel/series-list/{channel_slug}', 'ChannelHomeController@Channel_series_list')->name('Channel_series_list');
    Route::get('Channel/videos-list/{channel_slug}', 'ChannelHomeController@Channel_videos_list')->name('Channel_videos_list');

    // Content Partner List
    Route::get('contentpartner/{slug}', 'ContentPartnerHomeController@ContentPartnerHome')->name('ContentPartnerHome');
    //   Route::get('ContentPartner/{slug}', 'ContentPartnerHomeController@ContentPartnerHome')->name('ContentPartnerHome');
    // Route::get('Content-list', 'ContentPartnerHomeController@ContentList')->name('ContentList');
    Route::get('content-partners', 'ContentPartnerHomeController@ContentList')->name('ContentList');
    Route::get('Content_category_series', 'ContentPartnerHomeController@Content_category_series')->name('Content_category_series');
    Route::get('Content_category_videos', 'ContentPartnerHomeController@Content_category_videos')->name('Content_category_videos');
    Route::get('Content_category_audios', 'ContentPartnerHomeController@Content_category_audios')->name('Content_category_audios');
    Route::get('Content_category_live', 'ContentPartnerHomeController@Content_category_live')->name('Content_category_live');
    Route::get('all_Content_videos', 'ContentPartnerHomeController@all_Content_videos')->name('all_Content_videos');

    // CinetPay-Video Rent
    Route::post('/CinetPaySubscription', 'CinetPayController@CinetPaySubscription')->name('CinetPay_Subscription');
    Route::post('/CinetPay-video-rent', 'CinetPayController@CinetPay_Video_Rent_Payment')->name('CinetPay_Video_Rent_Payment');
    Route::post('/CinetPay-audio-rent', 'CinetPayController@CinetPay_audio_Rent_Payment')->name('CinetPay_audio_Rent_Payment');
    Route::post('/CinetPay-live-rent', 'CinetPayController@CinetPay_live_Rent')->name('CinetPay_live_Rent');

    // CinetPay- Series/Season Rent
    Route::post('/CinetPay-series_season-rent', 'PaymentController@CinetPay_series_season_Rent_Payment')->name('CinetPay_series_season_Rent_Payment');

    // Content Partner - Home Page

    Route::get('channel-partner', 'ChannelPartnerController@channelparnter')->name('channelparnter_index');
    Route::get('channel-partner/{slug}', 'ChannelPartnerController@unique_channelparnter')->name('channelparnter_details');

    // Live Event For artist
    Route::get('/live-artists-event', 'LiveEventArtistStream@index')->name('LiveEventArtistStream_index');
    Route::get('/live-artist-event/{slug}', 'LiveEventArtistStream@live_event_play')->name('live_event_play');

    Route::post('/live_event_tips', 'LiveEventArtistStream@live_event_tips')->name('live_event_tips');
    Route::post('/stripePayment-Tips', 'LiveEventArtistStream@stripePaymentTips')->name('stripePaymentTips');
    Route::post('/purchase-live-artist-event', 'LiveEventArtistStream@rent_live_artist_event')->name('rent_live_artist_event');

    Route::get('/liveStream', 'AdminLiveStreamController@liveStream')->name('liveStream');

    // PPV_live_PurchaseUpdate

    Route::post('/PPV_live_PurchaseUpdate', 'LiveStreamController@PPV_live_PurchaseUpdate')->name('PPV_live_PurchaseUpdate');
    Route::post('/unseen_expirydate_checking', 'LiveStreamController@unseen_expirydate_checking')->name('unseen_expirydate_checking');

    // Paystack
    // Paystack-Subscription
    Route::post('/Paystack-Subscription', 'PaystackController@Paystack_CreateSubscription')->name('Paystack_CreateSubscription');
    Route::get('/paystack-verify-request', 'PaystackController@paystack_verify_request')->name('paystack_verify_request');
    Route::get('/paystack-Andriod-verify-request', 'PaystackController@paystack_Andriod_verify_request')->name('paystack_Andriod_verify_request');
    Route::get('/paystack-Subscription-update', 'PaystackController@paystack_Subscription_update')->name('paystack_Subscription_update');
    Route::get('/Paystack-Subscription-cancel/{subscription_id}', 'PaystackController@Paystack_Subscription_cancel')->name('Paystack_Subscription_cancel');

    // Paystack-Video Rent
    Route::get('/Paystack-video-rent/{video_id}/{amount}', 'PaystackController@Paystack_Video_Rent')->name('Paystack_Video_Rent');
    Route::get('/Paystack-video-rent-paymentverify', 'PaystackController@Paystack_Video_Rent_Paymentverify')->name('Paystack_Video_Rent_Paymentverify');

    // Paystack-Live Rent
    Route::get('/Paystack-live-rent/{live_id}/{amount}', 'PaystackController@Paystack_live_Rent')->name('Paystack_live_Rent');
    Route::get('/Paystack-live-rent-paymentverify', 'PaystackController@Paystack_live_Rent_Paymentverify')->name('Paystack_live_Rent_Paymentverify');

    // Live Stream - M3U file
    Route::get('/m3u_file_m3u8url', 'LiveStreamController@m3u_file_m3u8url')->name('m3u_file_m3u8url');
    Route::get('/M3U_video_url', 'LiveStreamController@M3U_video_url')->name('M3U_video_url');

    //Rss Feed
    Route::get('/Rss-Feed-index', 'RssFeedController@index')->name('Rss-Feed-index');
    Route::get('/Rss-Feed-videos', 'RssFeedController@videos_view')->name('Rss-Feed-videos-view');
    Route::get('/Rss-Feed-Livestream', 'RssFeedController@livestream_view')->name('Rss-Feed-Livestream-view');
    Route::get('/Rss-Feed-episode', 'RssFeedController@episode_view')->name('Rss-Feed-episode-view');
    Route::get('/Rss-Feed-audios', 'RssFeedController@audios_view')->name('Rss-Feed-audios-view');

    Route::get('/feed', 'RssFeedController@feed')->name('feed');

    Route::get('/comment_index', 'WebCommentController@comment_index')->name('comment.index');
    Route::get('/comment_store', 'WebCommentController@comment_store')->name('comments.store');
    Route::get('/comment_edit', 'WebCommentController@comment_edit')->name('comments.edit');
    Route::get('/comment_update/{id}', 'WebCommentController@comment_update')->name('comments.update');
    Route::get('/comment_destroy/{id}', 'WebCommentController@comment_destroy')->name('comments.destroy');

    Route::get('/comment_reply/{id}', 'WebCommentController@comment_reply')->name('comments.reply');

    Route::get('/current-time', 'CurrentTimeController@current_time')->name('CurrentTimeController.current_time');

    // Learn Page

    Route::get('/learn', 'AllVideosListController@learn')->name('learn');

    //All Video
    Route::get('/library', 'AllVideosListController@all_videos')->name('all_videos');
    Route::get('/Most-watched-videos', 'AllVideosListController@All_User_MostwatchedVideos')->name('All_User_MostwatchedVideos');
    Route::get('/Most-watched-videos-country', 'AllVideosListController@All_Country_MostwatchedVideos')->name('All_Country_MostwatchedVideos');
    Route::get('/Most-watched-videos-site', 'AllVideosListController@All_MostwatchedVideos')->name('All_MostwatchedVideos');

    // Free-Movies
    Route::get('/Free-Movies', 'AllVideosListController@Free_videos')->name('Free_videos');

    // Series
    Route::get('/series/list', 'AllVideosListController@all_series')->name('all_series');
    Route::get('continue-watching-list', 'AllVideosListController@ContinueWatchingList');
});

// Razorpay
Route::group(['middleware' => ['RazorpayMiddleware']], function () {
    Route::get('Razorpay', 'RazorpayController@Razorpay');
    Route::post('Razorpay_authorization_url', 'RazorpayController@Razorpay_authorization_url')->name('Razorpay_authorization_url');
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

    // Route::get('/RazorpayModeratorPayouts/{user_id}/{amount}', 'RazorpayController@RazorpayModeratorPayouts')->name('RazorpayModeratorPayouts');
    Route::POST('/RazorpayModeratorPayouts', 'RazorpayController@RazorpayModeratorPayouts')->name('RazorpayModeratorPayouts');
    Route::POST('/RazorpayModeratorPayouts_Payment', 'RazorpayController@RazorpayModeratorPayouts_Payment')->name('RazorpayModeratorPayouts_Payment');

    Route::POST('/RazorpayChannelPayouts', 'RazorpayController@RazorpayChannelPayouts')->name('RazorpayChannelPayouts');
    Route::POST('/RazorpayChannelPayouts_Payment', 'RazorpayController@RazorpayChannelPayouts_Payment')->name('RazorpayChannelPayouts_Payment');
});

// Reset Password

Route::get('/Reset-Password', 'PasswordForgetController@Reset_Password')->name('Reset_Password');
Route::post('/Send-Reset-Password-link', 'PasswordForgetController@Send_Reset_Password_link')->name('Send_Reset_Password_link');
Route::get('/confirm-Reset-password/{crypt_email}/{reset_token}', 'PasswordForgetController@confirm_reset_password')->name('confirm_reset_password');
Route::post('/forget-password-update', 'PasswordForgetController@forget_password_update')->name('forget_password_update');

Route::get('/download-xml', function () {
    $file = public_path('uploads/sitemap/sitemap.xml');
    $headers = [
        'Content-Type' => 'application/xml',
    ];

    return response()->download($file, 'sitemap.xml', $headers);
})->name('download.xml');


// Ads Vast

Route::get('Ads-vast', 'AdsVastController@index');

// Advertisement Count

Route::get('Ads-Redirection-URL-Count', 'AdvertisementCountController@Advertisement_Redirection_URL_Count')->name('Advertisement_Redirection_URL_Count');
Route::get('Ads-Views-Count', 'AdvertisementCountController@Advertisement_Views_Count')->name('Advertisement_Views_Count');


Route::get('current-currency', 'AdminCurrencySettings@currentcurrency');
// Route::get('exchangeCurrency','AdminCurrencySettings@exchangeCurrency');

Route::get('exchangeCurrency','AdminCurrencyConvert@Index');

Route::get('PPV-Free-Duration-Logs', 'AdminLiveStreamController@PPV_Free_Duration_Logs')->name('PPV_Free_Duration_Logs');

Route::get('video-player/{slug}', 'ChannelController@video_js_fullplayer')->name('video-js-fullplayer');

Route::post('video_js_watchlater', 'ChannelController@video_js_watchlater')->name('video-js.watchlater');

Route::post('video_js_wishlist', 'ChannelController@video_js_wishlist')->name('video-js.wishlist');

Route::post('video_js_Like', 'ChannelController@video_js_Like')->name('video-js.like');

Route::post('video_js_dislike', 'ChannelController@video_js_disLike')->name('video-js.dislike');

Route::get('rentals', 'MoviesHomePageController@index')->name('videos.Movies-Page');

Route::get('epg/Channels/{slug}', 'EPGChannelController@index')->name('Front-End.EPG');

Route::get('epg/channel-List', 'EPGChannelController@EPG_Channel_List')->name('Front-End.EPG_Channel_List');

Route::get('Landing-page-email-capture', 'LandingPageEmailCaptureController@store')->name('Landing-page-email-capture');