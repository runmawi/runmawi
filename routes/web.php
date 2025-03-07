<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\cpp;
use App\Http\Middleware\Channel;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Schema;
use App\Series;

// @$translate_language = App\Setting::pluck('translate_language')->first();
// \App::setLocale(@$translate_language); translate_language


// Route::get('/update-htaccess', 'HomeController@updateHtaccess');

Route::group(['prefix' => '/admin/filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
    
Route::get('/video-chat', function () {
    // fetch all users apart from the authenticated user
    $users = App\User::where('id', '<>', Auth::id())->get();
    return view('video-chat', ['users' => $users]);
});
// Route::get('video_chat', 'VideoChatController@index');
Route::get('/FFplayoutlogin', 'AdminDashboardController@FFplayoutlogin');
Route::get('/ffplayout-token-channel', 'AdminFFplayoutController@login');
Route::get('/ffplayout-channel', 'AdminFFplayoutController@GetChannels');
Route::get('/getvideocihperdata', 'AdminVideosController@getvideocihperdata');
Route::get('/videocihperplayer', 'AdminVideosController@videocihperplayer');
Route::get('/shakaplayer', 'AdminVideosController@shakaplayer');

Route::get('mytv/quick-response/{tvcode}/{verifytoken}', 'HomeController@TvCodeQuickResponse');
Route::get('/BunnyCDNUpload', 'AdminDashboardController@BunnyCDNUpload');
Route::get('/BunnyCDNStream', 'AdminDashboardController@BunnyCDNStream');
Route::post('/profilePreference', 'AdminUsersController@profilePreference')->name('users-profile-Preference');

Route::get('/paypal/create-payment', 'PayPalController@createPayment');
Route::get('/paypal/execute-payment', 'PayPalController@executePayment');
Route::post('paypal-ppv-video', 'PaymentController@paypalppvVideo');
Route::post('paypal-ppv-series-season', 'PaymentController@PayPal_payment_series_season_PPV_Purchase');
Route::post('paypal-ppv-live', 'PaymentController@LiveRent_Payment');

Route::post('/translate_language', 'AdminDashboardController@TranslateLanguage');

Route::get('/my-logged-devices', 'HomeController@MyLoggedDevices');
Route::get('/my-logged-devices-delete/{id}', 'HomeController@MyLoggedDevicesDelete');

$router->get('tv_code/devices' , 'HomeController@tv_code_devices');

Route::group(['middleware' => 'auth'], function(){
    Route::get('video_chat', 'VideoChatController@index');
    Route::post('auth/video_chat', 'VideoChatController@auth');
  });

  Route::get('admin/episode/csv-episodeslug', 'AdminSeriesController@csvepisodeslug');
  Route::post('admin/episode/upload-csv-episodeslug', 'AdminSeriesController@uploadcsvepisodeslug');

  Route::get('/Document-List', 'HomeController@DocumentList');    
  Route::get('/document/category/{slug}', 'HomeController@DocumentCategoryList');    

//   Route::get('/MusicAudioPlayer', 'ThemeAudioController@MusicAudioPlayer')->name('MusicAudioPlayer');
    Route::get('admin/video/combine-video', 'AdminVideosController@combinevideo');

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
Route::get('/admin/moderator-details', 'ModeratorsUserController@Contentdetails');
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
Route::get('admin/UploadlogActivity', 'HomeController@UploadlogActivity');

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
Route::post('/admin/users/update-Subscription-status', 'AdminUsersController@updateStripeStatus');

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


// Content Purchased Analytics

Route::get('admin/purchased-analytics', 'AdminVideosController@PurchasedContentAnalytics');
// Route::get('admin/purchased-analytics', 'AdminVideosController@purchased-analyticsRevenue');
Route::post('/admin/purchased-analytics_startdate_revenue', 'AdminVideosController@PurchasedContentStartDateRevenue');
Route::post('/admin/purchased-analytics_enddate_revenue', 'AdminVideosController@PurchasedContentEndDateRevenue');
Route::post('/admin/purchased-analytics_exportCsv', 'AdminVideosController@PurchasedContentExportCsv');

Route::get('admin/Content-Analytics', 'AdminContentAnalyticsController@ContentAnalytics')->name('admin.content.analytics');


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

// mobile number exists while signup
Route::post('/SignupCheckMobile', 'SignupController@checkMobile')->name('SignupCheckMobile');




// CheckAuthTheme5 & restrictIp Middleware
Route::group(['middleware' => ['restrictIp', 'CheckAuthTheme5']], function () {
    Route::get('/category/videos/embed/{vid}', 'ChannelController@Embed_play_videos');
    // Route::get('/language/{language}', 'ChannelController@LanguageVideo');
    Route::get('/category/wishlist/{slug}', 'ChannelController@Watchlist');
    Route::post('favorite', 'ThemeAudioController@add_favorite');
    Route::get('/live/category/{cid}', 'LiveStreamController@channelVideos');
    Route::get('/videos-categories/{category_slug}', 'ChannelController@Parent_video_categories')->name('Parent_video_categories');
    Route::get('category/{cid}', 'ChannelController@channelVideos')->name('video_categories');
    Route::get('category/{cid}/channel/{slug}', 'ChannelController@channelVideos')->name('video_categories_channel');
    Route::get('/category/videos/{vid}', 'ChannelController@play_videos')->name('play_videos');
    Route::get('/AllMovies_category', 'ChannelController@AllMovies_category')->name('AllMovies_category');
    Route::get('/AllSeries_category', 'TvshowsController@AllSeries_category')->name('AllSeries_category');

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
Route::get('/mobility/page/{slug}', 'PagesController@MobalityIndex');


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
    Route::get('subcriberuser/{id}', 'HomeController@subcriberuser')->name('subcriberuser');
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
    Route::get('/home-livestream-section-auto-refresh', 'HomeController@home_livestream_section_auto_refresh')->name('home.livestream.section.autorefresh');

    // Reels
    Route::get('/reels', 'AdminReelsVideo@index');

    // Page List
    Route::get('Latest_videos', 'PageListController@Latest_videos')->name('pagelist.Latest-videos');
    Route::get('continue_watching_list', 'PageListController@ContinueWatchingList')->name('pagelist.ContinueWatchingList');
    Route::get('Movies', 'PageListController@AllMovies')->name('pagelist.AllMovies');
    Route::get('channel/latest-videos/{slug}', 'PageListController@Latest_videos')->name('pagelist.Latest-videos');
    Route::get('Featured_videos', 'PageListController@Featured_videos')->name('pagelist.Featured-videos');
    Route::get('channel/Featured_videos/{slug}', 'PageListController@Featured_videos')->name('pagelist.Featured-videos');
    Route::get('Video_categories', 'PageListController@Video_categories')->name('pagelist.category-videos-videos');
    Route::get('Live_list', 'PageListController@Live_list')->name('pagelist.live_list');
    Route::get('Albums_list', 'PageListController@Albums_list')->name('pagelist.albums_list');
    Route::get('Live_categories', 'PageListController@Live_Category_list')->name('pagelist.live-category_list');
    Route::get('Audio_list', 'PageListController@Audio_list')->name('pagelist.audio_list');
    Route::get('Series_list', 'PageListController@Series_list')->name('pagelist.series_list');
    Route::get('Latest_series', 'PageListController@Series_list')->name('pagelist.series_list');
    Route::get('channel/Series_list/{slug}', 'PageListController@Series_list')->name('pagelist.series_list');
    Route::get('Channel_Partner_list', 'PageListController@ChannelPartner_list')->name('pagelist.channelpartner_list');
    Route::get('Content_Partner_list', 'PageListController@ContentPartner_list')->name('pagelist.contentpartner_list');
    Route::get('latest_viewed_audio_list', 'PageListController@LatestViewedAudio_list')->name('pagelist.latestviewed-audio');
    Route::get('epg_list', 'PageListController@epg_list')->name('pagelist.epg_list');
    Route::get('Series_genre_list', 'PageListController@SeriesGenre_list')->name('pagelist.seriesgenre');
    Route::get('watchlater_list', 'PageListController@Watchlater_list')->name('pagelist.watchlater');
    Route::get('wishlist_list', 'PageListController@Wishlist_list')->name('pagelist.wishlist');
    Route::get('audio_genre_list', 'PageListController@AudioGenre_list')->name('pagelist.audiogenre');
    Route::get('latest_viewed_episode_list', 'PageListController@LatestViewedEpisode_list')->name('pagelist.latestviewed-episode');
    Route::get('latest_viewed_live_list', 'PageListController@LatestViewedLive_list')->name('pagelist.latestviewed-live');
    Route::get('latest_viewed_video_list', 'PageListController@LatestViewedVideo_list')->name('pagelist.latestviewed-video');
    Route::get('Featured_episodes', 'PageListController@Featured_episodes')->name('pagelist.Featured_episodes');
    Route::get('Video_based_categories', 'PageListController@VideoBasedCategories_list')->name('pagelist.video-based-categories');
    Route::get('Most_watched_country_videos', 'PageListController@MostWatchedCountryVideos_list')->name('pagelist.most-watched-videos-country');
    Route::get('Most_watched_users_videos', 'PageListController@MostWatchedUserVideos_list')->name('pagelist.most-watched-videos-users');
    Route::get('Most_watched_site_videos', 'PageListController@MostWatchedVideoSite_list')->name('pagelist.most-watched-videos-site');
    Route::get('shorts_minis', 'PageListController@ShortsMinis')->name('pagelist.shorts-minis');
    Route::get('artists_list', 'PageListController@Artist_list')->name('pagelist.artists-list');
    Route::get('latest_episodes', 'PageListController@Latest_episodes')->name('pagelist.latest_episodes');
    // Route::get('continue-watching-list', 'PageListController@ContinueWatching_list')->name('pagelist.continue-watching');
    //Top most Watched Videos need to add

    
    // TV-shows
    Route::get('tv-shows', 'TvshowsController@index')->name('series.tv-shows');

    Route::get('datafree/episode/{series_name}/{episode_name}', 'TvshowsController@play_episode')->name('play_episode');
    Route::get('episode/embed/{series_name}/{episode_name}', 'TvshowsController@Embedplay_episode');
    Route::get('episode/{episode_name}', 'TvshowsController@PlayEpisode');

    Route::get('episode/{series_name}/{episode_name}', 'TvshowsController@play_episode')->name('play_episode');
    Route::get('networks/episode/{series_name}/{episode_name}', 'TvshowsController@play_episode')->name('network_play_episode');
    Route::get('episode/{series_name}/{episode_name}/{plan}', 'TvshowsController@play_episode');

    Route::get('play_series/{name}/', 'TvshowsController@play_series')->name('play_series');
    Route::get('app/play_series/{name}/', 'TvshowsController@play_series')->name('play_series');
    Route::get('networks/play_series/{name}/', 'TvshowsController@play_series')->name('network.play_series');

    Route::get('play-series/season-depends-episode/', 'TvshowsController@season_depends_episode_section')->name('front-end.series.season-depends-episode');

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

    // OTP (March 2024)
    Route::get('/login-otp', 'OTPController@OTP_index')->name('auth.otp.index');
    Route::get('/verify-mobile-number', 'OTPController@verify_mobile_number')->name('auth.otp.verify_mobile_number');
    Route::get('/check-mobile-exist', 'OTPController@check_mobile_exist')->name('auth.otp.check-mobile-exist');
    Route::get('/sending-otp', 'OTPController@Sending_OTP')->name('auth.otp.sending-otp');
    Route::get('/otp_verification', 'OTPController@otp_verification')->name('auth.otp.otp_verification');

    Route::get('/signup-sending-otp', 'OTPController@Signup_Sending_OTP')->name('auth.otp.signup-sending-otp');
    Route::get('/signup-otp-verification', 'OTPController@signup_otp_verification')->name('auth.otp.signup_otp_verification');
    Route::get('/signup-check-mobile-exist', 'OTPController@Signup_check_mobile_exist')->name('auth.otp.signup-check-mobile-exist');

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
    Route::get('/PayPalcancelSubscription', 'PaypalController@PayPalcancelSubscription');

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
    Route::get('/searchResult', 'HomeController@searchResult')->name('searchResult');
    Route::post('/searchResult', 'HomeController@searchResult');

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

    Route::post('video_js_Like_episode', 'TvshowsController@video_js_Like_episode')->name('video-js.video_js_Like_episode');
    Route::post('video_js_dislike_episode', 'TvshowsController@video_js_disLike_episode')->name('video-js.video_js_disLike_episode');

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

    // Stripe Checkout Page - Multicurrency
    Route::post('Stripe_authorization_url', 'StripePaymentController@Stripe_authorization_url')->name('Stripe_authorization_url');
    Route::get('Stripe_payment_success', 'StripePaymentController@Stripe_payment_success')->name('Stripe_payment_success');
    
    // Stripe Live PPV Purchase
    Route::get('Stripe_payment_live_PPV_Purchase/{live_id}/{amount}', 'StripePaymentController@Stripe_payment_live_PPV_Purchase')->name('Stripe_payment_live_PPV_Purchase');
    Route::get('Stripe_payment_live_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/{live_id}', 'StripePaymentController@Stripe_payment_live_PPV_Purchase_verify')->name('Stripe_payment_live_PPV_Purchase_verify');

        // Stripe Video PPV Purchase
    Route::get('Stripe_payment_video_PPV_Purchase/{video_id}/{amount}', 'StripePaymentController@Stripe_payment_video_PPV_Purchase')->name('Stripe_payment_video_PPV_Purchase');
    Route::get('Stripe_payment_video_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/{video_id}', 'StripePaymentController@Stripe_payment_video_PPV_Purchase_verify')->name('Stripe_payment_video_PPV_Purchase_verify');
    
    
    Route::get('Stripe_payment_video_PPV_Plan_Purchase/{ppv_plan}/{video_id}/{amount}', 'StripePaymentController@Stripe_payment_video_PPV_Plan_Purchase')->name('Stripe_payment_video_PPV_Plan_Purchase');
    Route::get('Stripe_payment_video_PPV_Plan_Purchase_verify/{CHECKOUT_SESSION_ID}/{video_id}/{ppv_plan}', 'StripePaymentController@Stripe_payment_video_PPV_Plan_Purchase_verify')->name('Stripe_payment_video_PPV_Plan_Purchase_verify');

        // Stripe Series Season PPV Purchase
    Route::get('Stripe_payment_series_season_PPV_Purchase/{SeriesSeason_id}/{amount}', 'StripePaymentController@Stripe_payment_series_season_PPV_Purchase')->name('Stripe_payment_series_season_PPV_Purchase');
    Route::get('Stripe_payment_series_season_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/{SeriesSeason_id}', 'StripePaymentController@Stripe_payment_series_season_PPV_Purchase_verify')->name('Stripe_payment_series_season_PPV_Purchase_verify');
    
    // Stripe Series  PPV Purchase
    Route::get('Stripe_payment_series_PPV_Purchase/{Series_id}/{amount}', 'StripePaymentController@Stripe_payment_series_PPV_Purchase')->name('Stripe_payment_series_PPV_Purchase');
    Route::get('Stripe_payment_series_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/{Series_id}', 'StripePaymentController@Stripe_payment_series_PPV_Purchase_verify')->name('Stripe_payment_series_season_PPV_Purchase_verify');
    

                // Stripe Series Season PPV Purchase
    Route::get('Stripe_payment_series_season_PPV_Plan_Purchase/{ppv_plan}/{SeriesSeason_id}/{amount}', 'StripePaymentController@Stripe_payment_series_season_PPV_Plan_Purchase')->name('Stripe_payment_series_season_PPV_Plan_Purchase');
    Route::get('Stripe_payment_series_season_PPV_Plan_Purchase_verify/{CHECKOUT_SESSION_ID}/{SeriesSeason_id}/{ppv_plan}', 'StripePaymentController@Stripe_payment_series_season_PPV_Plan_Purchase_verify')->name('StripeStripe_payment_series_season_PPV_Plan_Purchase_verifyPaymentController');
    

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
    Route::get('upgrade-subscriber', 'PaymentController@BecomeSubscriber')->name('payment_UpgradeSubscriber');
    Route::get('BecomeSubscriber_Plans', 'PaymentController@BecomeSubscriber_Plans')->name('BecomeSubscriber_Plans');
    Route::get('transactiondetails', 'PaymentController@TransactionDetails');

    Route::get('/upgrading', 'PaymentController@upgrading');

    Route::get('/channels', 'ChannelController@index');
    Route::get('/ppvVideos', 'ChannelController@ppvVideos');
    Route::get('/live', 'LiveStreamController@Index');

    Route::get('/live/{id}', 'LiveStreamController@Play')->name('LiveStream_play');
    Route::get('/app/live/{id}', 'LiveStreamController@Play')->name('LiveStream_play');
    Route::get('datafree/live/{id}', 'LiveStreamController@Play')->name('LiveStream_play');
    Route::get('/live/embed/{id}', 'LiveStreamController@EmbedLivePlay');

    // Radio Station
    Route::get('/radio-station/{id}', 'LiveStreamController@Play')->name('Radio_station_play');
    Route::get('datafree/radio-station/{id}', 'LiveStreamController@Play')->name('Radio_station_play');
    Route::get('/radio-station-list', 'LiveStreamController@RadioStationList')->name('Radio_station_List');
    Route::get('datafree/radio-station-list', 'LiveStreamController@RadioStationList')->name('Radio_station_List');

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
    Route::get('get-storage-data', 'AdminDashboardController@getStorageData');

    Route::get('/mobileapp', 'AdminUsersController@mobileapp')->name('admin.mobileapp');
    Route::post('/admin_translate_language', 'AdminDashboardController@AdminTranslateLanguage');
    Route::post('/episodes/deleteSelected','AdminSeriesController@deleteSelected')->name('admin.episodes.deleteSelected');
    Route::post('/episodes/deleteSelecte','CPPSeriesController@deleteSelected')->name('cpp.episodes.deleteSelecte');

    // Channel Schedule
    Route::get('/channel/index', 'AdminEPGChannelController@index')->name('admin.Channel.index');
    Route::get('/channel/create', 'AdminEPGChannelController@create')->name('admin.Channel.create');
    Route::post('/channel/store', 'AdminEPGChannelController@store')->name('admin.Channel.store');
    Route::get('/channel/edit/{id}', 'AdminEPGChannelController@edit')->name('admin.Channel.edit');
    Route::post('/channel/update/{id}', 'AdminEPGChannelController@update')->name('admin.Channel.update');
    Route::get('/channel/destroy/{id}', 'AdminEPGChannelController@destroy')->name('admin.Channel.destroy');
    Route::get('/channel/validation', 'AdminEPGChannelController@slug_validation')->name('admin.Channel.slug_validation');

    // EPG Schedule
    Route::get('/epg/index', 'AdminEPGController@index')->name('admin.epg.index');
    Route::get('/epg/create', 'AdminEPGController@create')->name('admin.epg.create');
    Route::post('/epg/generate', 'AdminEPGController@generate')->name('admin.epg.generate');
    Route::get('/epg/delete/{id}', 'AdminEPGController@delete')->name('admin.epg.delete');
    Route::get('/epg/download-json/{id}', 'AdminEPGController@downloadJson')->name('admin.download.json');

    
    
    // Splash Screen
    Route::post('/mobile_app/store', 'AdminUsersController@mobileappupdate');
    Route::get('/mobile_app/Splash_destroy/{source}/{id}', 'AdminUsersController@Splash_destroy')->name('Splash_destroy');
    Route::get('/mobile_app/Splash_edit/{source}/{id}', 'AdminUsersController@Splash_edit')->name('Splash_edit');
    Route::post('/mobile_app/Splash_update/{source}/{id}', 'AdminUsersController@Splash_update')->name('Splash_update');


    // TV Splash Screen
       Route::post('/tv_splash_screen/store', 'AdminUsersController@TVSplashScreen');
       Route::get('/tv_splash_screen/destroy/{id}', 'AdminUsersController@TV_Splash_destroy')->name('TV_Splash_destroy');
       Route::get('/tv_splash_screen/edit/{id}', 'AdminUsersController@TV_Splash_edit')->name('TV_Splash_edit');
       Route::post('/tv_splash_screen/update/{id}', 'AdminUsersController@TV_Splash_update')->name('TV_Splash_update');

    // Device version
    Route::get('/mobile_app/device_version', 'AdminUsersController@device_version')->name('mobile_app.device_version');

    // OTP Auth
    Route::get('/OTP-Credentials', 'AdminOTPCredentialsController@index')->name('admin.OTP-Credentials-index');
    Route::post('/OTP-Credentials-update', 'AdminOTPCredentialsController@update')->name('admin.OTP-Credentials-update');

        // Users Package 
    Route::get('/users-package', 'SuperAdminPackageController@users_package')->name('admin.users-package');
    Route::post('/users-package-update', 'SuperAdminPackageController@users_package_update')->name('admin.users-package-update');

    Route::get('/users', 'AdminUsersController@index')->name('users');
    Route::get('/users/fetch/pagination', 'AdminUsersController@users_pagination')->name('admin.users-pagination');
    Route::post('/users/deleteSelected','AdminUsersController@deleteSelected')->name('admin.users.deleteSelected');
    Route::get('/user/create', 'AdminUsersController@create');
    Route::post('/user/store', 'AdminUsersController@store');
    Route::get('/user/edit/{id}', 'AdminUsersController@edit')->name('admin.users.edit');
    Route::post('/user/update', ['before' => 'demo', 'uses' => 'AdminUsersController@update']);
    Route::get('/user/delete/{id}', ['before' => 'demo', 'uses' => 'AdminUsersController@destroy'])->name('admin.users.destroy');
    Route::post('/export', 'AdminUsersController@export');
    Route::get('/user/view/{id}', 'AdminUsersController@view')->name('admin.users.view');
    Route::post('/profile/update', 'AdminUsersController@myprofileupdate');
    Route::post('/profileupdate', 'AdminUsersController@ProfileImage');
    Route::get('/email_exitsvalidation', 'AdminUsersController@email_exitsvalidation')->name('email_exitsvalidation');
    Route::get('/mobilenumber_exitsvalidation', 'AdminUsersController@mobilenumber_exitsvalidation')->name('mobilenumber_exitsvalidation');
    Route::get('/password_validation', 'AdminUsersController@password_validation')->name('password_validation');
    Route::get('/users-statistics', 'AdminUsersController@UsersStats')->name('users.statistics');
    Route::get('/users-statistics-filter', 'AdminUsersController@UsersStatsFilter')->name('users.statistics.filter');

    Route::get('/settings', 'AdminSettingsController@index');
    Route::post('/settings/save_settings', 'AdminSettingsController@save_settings');
    Route::post('/settings/script_settings', 'AdminSettingsController@script_settings');
    Route::post('/settings/custom_css_settings', 'AdminSettingsController@customCssSettings');

    Route::get('/home-settings', 'Admin\HomeSettingsController@index');
    Route::post('/home-settings/save', 'Admin\HomeSettingsController@save_settings');
    Route::post('/mobile-home-settings/save', 'Admin\HomeSettingsController@mobilesave_settings');
    Route::post('/roku-home-settings/save', 'Admin\HomeSettingsController@rokusave_settings');

    Route::get('/order-home-settings', 'Admin\HomeSettingsController@Orderindex');
    Route::get('/order-home-settings/order_save', 'Admin\HomeSettingsController@Ordersave_settings');
    Route::get('/order_homepage/order_save', 'Admin\HomeSettingsController@Ordersave_settings');
    Route::get('/order_homepage/edit/{id}', 'Admin\HomeSettingsController@OrderEdit_settings');
    Route::get('/order_homepage/delete/{id}', 'Admin\HomeSettingsController@OrderDelete_settings');
    Route::post('/order_homepage/update', 'Admin\HomeSettingsController@OrderUpdate_settings');
    Route::post('/order_homepage/update_setting', 'Admin\HomeSettingsController@OrderUpdate');

    Route::get('/signup', 'AdminSignupMenuController@index')->name('signupindex');
    Route::post('/Signupmenu_Store', 'AdminSignupMenuController@store')->name('store');

    Route::get('/cpp-signup', 'AdminSignupMenuController@cppindex')->name('cppsignupindex');
    Route::post('/CPP_Signupmenu_Store', 'AdminSignupMenuController@CPP_Signupmenu_Store')->name('store');

    Route::get('/channel-signup', 'AdminSignupMenuController@channelindex')->name('channelsignupindex');
    Route::post('/Channel_Signupmenu_Store', 'AdminSignupMenuController@Channel_Signupmenu_Store')->name('Channel_Signupmenu_Store');

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
    Route::get('/get_compression_processed_percentage/{id}', 'AdminVideosController@get_compression_processed_percentage');
    Route::get('/get_processed_percentage_episode/{id}', 'AdminSeriesController@get_processed_percentage_episode');

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
    Route::post('/videos/VideoCipherFileUpload', ['before' => 'demo', 'uses' => 'AdminVideosController@VideoCipherFileUpload']);
    Route::get('/transcoding-management', 'AdminVideosController@TranscodingManagement');


    // Music Genre Routes
    Route::get('/Music/Genre', 'AdminMusicGenreController@index');
    Route::Post('/Music_genre_store', 'AdminMusicGenreController@Music_Genre_Store');
    Route::get('/Music_genre/edit/{id}', 'AdminMusicGenreController@Music_Genre_Edit');
    Route::post('/Music_genre/update', 'AdminMusicGenreController@Music_Genre_Update');
    Route::get('/Music_genre/delete/{id}', 'AdminMusicGenreController@Music_Genre_Delete');
    Route::Post('/Music_genre_order', 'AdminMusicGenreController@Music_Genre_Order');
    Route::post('/Music_genre_active', 'AdminMusicGenreController@Music_Genre_Active');

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
    
    Route::get('/clear-cache', 'ClearCacheController@index')->name('clear_cache');
    Route::post('/clear_caches', 'ClearCacheController@clear_caches')->name('clear_caches');
    Route::post('/clear_view_cache', 'ClearCacheController@clear_view_cache')->name('clear_view_cache');
    Route::post('/view-buffer-cache', 'ClearCacheController@view_buffer_cache')->name('view_buffer_cache');
    Route::post('/clear-buffer-cache', 'ClearCacheController@clear_buffer_cache')->name('clear_buffer_cache');
    Route::get('/testing_command', 'ClearCacheController@testing_command')->name('testing_command');
    
    // ENV APP DEBUG
    Route::get('/debug', 'ClearCacheController@Env_index')->name('env_index');
    Route::Post('/Env_AppDebug', 'ClearCacheController@Env_AppDebug')->name('env_appdebug');

    
    // Htaccess access forbidden 
    Route::get('/access-forbidden', 'HtaccessController@index')->name('access_forbidden');
    Route::Post('/access-forbidden-update', 'HtaccessController@updateHtaccess')->name('updateAccessForbidden');

    //  Bulk Delete
    Route::get('admin/Livestream_bulk_delete', 'AdminLiveStreamController@Livestream_bulk_delete')->name('Livestream_bulk_delete');
    Route::get('admin/Audios_bulk_delete', 'AdminAudioController@Audios_bulk_delete')->name('Audios_bulk_delete');

    // Admin Livestream 
    Route::get('/livestream', 'AdminLiveStreamController@index')->name('admin.livestream.index');
    Route::get('/livestream/edit/{id}', 'AdminLiveStreamController@edit')->name('admin.livestream.edit');
    Route::post('/livestream/update', 'AdminLiveStreamController@update')->name('admin.livestream.update');
    Route::get('/livestream/delete/{id}', ['before' => 'demo', 'uses' => 'AdminLiveStreamController@destroy'])->name('admin.livestream.delete');
    Route::get('/livestream/create', 'AdminLiveStreamController@create')->name('admin.livestream.create');
    Route::post('/livestream/store', ['before' => 'demo', 'uses' => 'AdminLiveStreamController@store'])->name('admin.livestream.store');

    // Admin Radio Station
    
    Route::get('/radio-station-index', 'AdminLiveStreamController@index')->name('admin.radio-station.index');
    Route::get('/radio-station/create', 'AdminLiveStreamController@create')->name('admin.radio-station.create');
    Route::post('/radio-station/store', ['before' => 'demo', 'uses' => 'AdminLiveStreamController@store'])->name('admin.radio-station.store');
    Route::get('/radio-station/edit/{id}', 'AdminLiveStreamController@edit')->name('admin.radio-station.edit');
    Route::post('/radio-station/update', 'AdminLiveStreamController@update')->name('admin.radio-station.update');
    Route::get('/radio-station/delete/{id}', ['before' => 'demo', 'uses' => 'AdminLiveStreamController@destroy'])->name('admin.radio-station.delete');

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

    // Admin User Channel Subscription Plan (Auth user)
    Route::get('/user-channel-subscription-plan', 'AdminUserChannelSubscriptionPlan@index')->name('admin.user-channel-subscription-plan.index');
    Route::get('/user-channel-subscription-plan-store', 'AdminUserChannelSubscriptionPlan@store')->name('admin.user-channel-subscription-plan.store');
    Route::get('/user-channel-subscription-plan-edit/{random_key}', 'AdminUserChannelSubscriptionPlan@edit')->name('admin.user-channel-subscription-plan.edit');
    Route::get('/user-channel-subscription-plan-update', 'AdminUserChannelSubscriptionPlan@update')->name('admin.user-channel-subscription-plan.update');
    Route::get('/user-channel-subscription-plan-delete/{random_key}', 'AdminUserChannelSubscriptionPlan@delete')->name('admin.user-channel-subscription-plan.delete');
    Route::get('/user-channel-subscription-plan-page-status', 'AdminUserChannelSubscriptionPlan@user_channel_plans_page_status')->name('admin.user-channel-subscription-plan.page-status');

    // Multiple channel Subscription Plans
    Route::post('Update-Multiple-Subscription-Plans', 'AdminPlansController@Update_Multiple_Subscription_Plans')->name('Update_Multiple_Subscription_Plans');

    // Admin Channel Partner Subscription Plan
    Route::get('/channel-subscription-plans', 'AdminChannelPlansController@subscriptionindex');
    Route::post('/channel-subscription-plans/store', 'AdminChannelPlansController@subscriptionstore');
    Route::get('/channel-subscription-plans/edit/{id}', 'AdminChannelPlansController@subscriptionedit');
    Route::get('/channel-subscription-plans/delete/{id}', 'AdminChannelPlansController@subscriptiondelete');
    Route::post('/channel-subscription-plans/update', 'AdminChannelPlansController@subscriptionupdate');
    
    // Multiple Moderator Subscription Plans
    Route::post('Update-Multiple-Channel-Subscription-Plans', 'AdminChannelPlansController@Update_Multiple_Subscription_Plans')->name('Update_Multiple_Subscription_Plans');

    Route::get('/moderator-subscription-plans', 'AdminCPPPlansController@subscriptionindex');
    Route::post('/moderator-subscription-plans/store', 'AdminCPPPlansController@subscriptionstore');
    Route::get('/moderator-subscription-plans/edit/{id}', 'AdminCPPPlansController@subscriptionedit');
    Route::get('/moderator-subscription-plans/delete/{id}', 'AdminCPPPlansController@subscriptiondelete');
    Route::post('/moderator-subscription-plans/update', 'AdminCPPPlansController@subscriptionupdate');
    
    // Multiple Subscription Plans
    Route::post('Update-Multiple-Moderator-Subscription-Plans', 'AdminChannelPlansController@Update_Multiple_Subscription_Plans')->name('Update_Multiple_Subscription_Plans');

    
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

    /* Page Premission settings*/

    Route::get('/access-premission', 'AdminAccessPermissionController@Index');
    Route::post('/access_premission/save', 'AdminAccessPermissionController@Store');


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

    Route::get('/livestream_calendar', 'AdminLiveStreamController@livestream_calendar')->name('livestream_calendar');

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
    // Route::get('ThemeIntegration', 'ThemeIntegrationController@index')->name('ThemeIntegratiofn');

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
 
        // Note - Don't remove this 
        
        // Route::get('/channel-package-index', 'AdminChannelPackageController@index')->name('channel_package_index');
        // Route::get('/channel-package-create', 'AdminChannelPackageController@create')->name('channel_package_create');
        // Route::post('/channel-package-store', 'AdminChannelPackageController@store')->name('channel_package_store');
        // Route::get('/channel-package-edit/{id}', 'AdminChannelPackageController@edit')->name('channel_package_edit');
        // Route::post('/channel-package-update/{id}', 'AdminChannelPackageController@update')->name('channel_package_update');
        // Route::get('/channel-package-delete/{id}', 'AdminChannelPackageController@delete')->name('channel_package_delete');

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

    //Writer Routes
        Route::get('Writer', 'AdminWriterController@index');
        Route::get('Writer/create', 'AdminWriterController@create');
        Route::post('Writer/store', 'AdminWriterController@store');
        Route::get('Writer/edit/{id}', 'AdminWriterController@edit');
        Route::post('Writer/update', 'AdminWriterController@update');
        Route::get('Writer/delete/{id}', 'AdminWriterController@destroy');

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
    Route::Post('/Serie/Network-based/order', 'AdminNetworkController@NetworkBased_order')->name('admin.Network_series_order');

    //Admin Series Season Manage
    // Route::get('/season/create/{id}', 'AdminSeriesController@create_season');
    Route::post('/season/create/', 'AdminSeriesController@create_season');
    Route::get('/season/edit/{series_id}/{season_id}', 'AdminSeriesController@manage_season');
    Route::get('/season/edit/{season_id}', 'AdminSeriesController@Edit_season');
    Route::post('/season/update', 'AdminSeriesController@Update_season');
    Route::get('/season/delete/{id}', 'AdminSeriesController@destroy_season');
    Route::post('/bunnycdn_episodelibrary', 'AdminSeriesController@BunnycdnEpisodelibrary');
    Route::post('/stream_bunny_cdn_episode', 'AdminSeriesController@StreamBunnyCdnEpisode');
    Route::Post('/Series_Season_order', 'AdminSeriesController@Series_Season_order');
    Route::post('/Flussonicepisodelibrary', 'AdminSeriesController@Flussonicepisodelibrary');
    Route::post('/stream_Flussonic_episode', 'AdminSeriesController@StreamFlussonicEpisode');
    
    Route::post('/episode/create', 'AdminSeriesController@create_episode');
    Route::get('/episode/delete/{id}', 'AdminSeriesController@destroy_episode');
    Route::get('/episode/edit/{id}', 'AdminSeriesController@edit_episode');
    Route::post('/episode/update', 'AdminSeriesController@update_episode');
    Route::post('/episode_upload', 'AdminSeriesController@EpisodeUpload');
    Route::post('/DeleteEpisodeRecord', 'AdminSeriesController@DeleteEpisodeRecord');
    Route::get('/episode/episode_edit/{id}', 'AdminSeriesController@EpisodeUploadEdit');
    Route::post('/EpisodeVideoUpload', 'AdminSeriesController@EpisodeVideoUpload');
    Route::get('/episode/subtitle/delete/{id}', ['before' => 'demo', 'uses' => 'AdminSeriesController@subtitledestroy']);
    Route::post('/episode/extractedimage', 'AdminSeriesController@ExtractedImage');
    Route::post('/episode/VideoCipheCreate', 'AdminSeriesController@VideoCipheCreate_Episod');

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

        /*  Default Scheduler Videos Setting  */

        Route::get('/default-video-scheduler', 'AdminSiteVideoSchedulerController@SiteVideoScheduler')->name('VideoScheduler');
        Route::get('/default-filter-scheduler', 'AdminSiteVideoSchedulerController@FilterVideoScheduler')->name('FilterScheduler');
        Route::post('/default-drag-drop-Scheduler-videos', 'AdminSiteVideoSchedulerController@DragDropSchedulerVideos');
        Route::get('/default-Scheduled-videos', 'AdminSiteVideoSchedulerController@ScheduledVideos');
        Route::get('/default-get-channel-details/{videoId}', 'AdminSiteVideoSchedulerController@GetChannelDetail');
        Route::post('/default-Scheduler-UpdateTime', 'AdminSiteVideoSchedulerController@SchedulerUpdateTime');
        Route::post('/default-Scheduler-ReSchedule', 'AdminSiteVideoSchedulerController@SchedulerReSchedule');
        Route::post('/default-get-all-channel-details', 'AdminSiteVideoSchedulerController@GetAllChannelDetails');
        Route::post('/default-remove-scheduler', 'AdminSiteVideoSchedulerController@RemoveSchedulers');
        Route::get('/generate-scheduler-xml', 'AdminSiteVideoSchedulerController@generateSchedulerXml');
        Route::post('/default-generate-scheduler-xml', 'AdminSiteVideoSchedulerController@DefaultgenerateSchedulerXml');
        Route::post('/epg-generate-scheduler-xml', 'AdminSiteVideoSchedulerController@EPGgenerateSchedulerXml');

    /*  Channel Videos Setting  */

    Route::get('/video-scheduler', 'AdminChannelVideoController@ChannelVideoScheduler')->name('VideoScheduler');
    Route::get('/filter-scheduler', 'AdminChannelVideoController@FilterVideoScheduler')->name('FilterScheduler');
    Route::post('/drag-drop-Scheduler-videos', 'AdminChannelVideoController@DragDropSchedulerVideos');
    Route::get('/Scheduled-videos', 'AdminChannelVideoController@ScheduledVideos');
    Route::get('/get-channel-details/{videoId}', 'AdminChannelVideoController@GetChannelDetail');
    Route::post('/Scheduler-UpdateTime', 'AdminChannelVideoController@SchedulerUpdateTime');
    Route::post('/Scheduler-ReSchedule', 'AdminChannelVideoController@SchedulerReSchedule');
    Route::post('/get-all-channel-details', 'AdminChannelVideoController@GetAllChannelDetails');
    Route::post('/remove-scheduler', 'AdminChannelVideoController@RemoveSchedulers');
    Route::get('/get-more-videos', 'AdminChannelVideoController@getMoreVideos');

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

    Route::get('advertisement/ads-banners', 'AdminAdvertiserController@ads_banners')->name('admin.ads_banners');
    Route::post('advertisement/ads-banners-update', 'AdminAdvertiserController@ads_banners_update')->name('admin.ads_banners_update');

    Route::get('ads/variables', 'AdminAdvertiserController@ads_variable')->name('admin.ads_variable');
    Route::post('ads/variable-store', 'AdminAdvertiserController@ads_variables_store')->name('admin.ads_variable_store');
    Route::get('ads/variable-edit/{id}', 'AdminAdvertiserController@ads_variables_edit')->name('admin.ads_variables_edit');
    Route::post('ads/variable-update/{id}', 'AdminAdvertiserController@ads_variables_update')->name('admin.ads_variables_update');
    Route::get('ads/variable-delete/{id}', 'AdminAdvertiserController@ads_variables_delete')->name('admin.ads_variables_delete');

    // Admin Series Genre
        Route::get('/document/genre', 'AdminDocumentGenreController@index');
        Route::Post('/document/genre/store', 'AdminDocumentGenreController@Document_Store');
        Route::get('/document/genre/edit/{id}', 'AdminDocumentGenreController@Document_Edit');
        Route::post('/document/genre/update', 'AdminDocumentGenreController@Document_Update');
        Route::get('/document/genre/delete/{id}', 'AdminDocumentGenreController@Document_Delete');
        Route::Post('/document/genre/order', 'AdminDocumentGenreController@Document_Order');
        Route::post('/document/genre/active', 'AdminDocumentGenreController@Document_Active');
    
        
    // Admin Series Genre
        Route::get('/document/list', 'AdminDocumentController@List');
        Route::get('/document/upload', 'AdminDocumentController@index');
        Route::Post('/document/store', 'AdminDocumentController@store');
        Route::get('/document/edit/{id}', 'AdminDocumentController@Edit');
        Route::post('/document/update', 'AdminDocumentController@Update');
        Route::get('/document/delete/{id}', 'AdminDocumentController@Delete');    
            

    // Admin Series Genre

        Route::get('/channel/role', 'AdminChannelRolesController@ChannelRoles');
        Route::post('/channel/role/store', 'AdminChannelRolesController@RolesPermissionStore');
        Route::get('/channel/role/view', 'AdminChannelRolesController@AllChannelRoles');
        Route::get('/channel/role/edit/{id}', 'AdminChannelRolesController@RoleEdit');
        Route::get('/channel/role/delete/{id}', 'AdminChannelRolesController@RoleDelete');
        Route::post('/channel/role/update', 'AdminChannelRolesController@RoleUpdate');

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
    Route::post('/videocipher_type', 'AdminVideosController@videocipher_type');
    Route::post('/video_upload_type', 'AdminVideosController@video_upload_type');

    Route::post('/AWSUploadFile', 'AdminVideosController@AWSUploadFile');

    Route::post('/Updatem3u8url', 'AdminVideosController@Updatem3u8url');
    Route::post('/UpdateEmbededcode', 'AdminVideosController@UpdateEmbededcode');
    Route::post('/Updatemp4url', 'AdminVideosController@Updatemp4url');

    Route::post('/UploadErrorLog', 'AdminVideosController@UploadErrorLog');

    Route::post('/FlussonicUploadlibrary', 'AdminVideosController@FlussonicUploadlibrary');
    Route::post('/Flussonic_Storage_UploadURL', 'AdminVideosController@Flussonic_Storage_UploadURL');

    
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
    Route::get('/CPP-commission-status-update', 'ModeratorsUserController@CPP_Commission_Status_update')->name('admin.CPP_commission_status_update');
    Route::get('/moderatorsrole/edit/{id}', 'ModeratorsUserController@RoleEdit');
    Route::get('/moderatorsrole/delete/{id}', 'ModeratorsUserController@RoleDelete');
    Route::post('/moderatorsrole/update', 'ModeratorsUserController@RoleUpdate');
    Route::get('/moderator/payouts', 'ModeratorsUserController@Payouts');
    Route::get('/moderator/edit_payouts/{id}', 'ModeratorsUserController@EditPayouts');
    Route::get('/moderator/view_payouts/{id}', 'ModeratorsUserController@ViewPayouts');
    Route::post('/moderator/update_payouts', 'ModeratorsUserController@UpdatePayouts');

    // ExecuteShell Command For Maintanace sytsem

    // Route::get('/execute-shell', 'HomeController@ExecuteShell');
    Route::get('/resend/Activation_Code/{id}', 'AdminUsersController@ActivationCode');

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
    Route::get('/subscription/view/{id}', 'AdminPaymentManagementController@SubscriptionView')->name('admin.ppvpayment.view');
    Route::get('/ppvpayment/view/{id}', 'AdminPaymentManagementController@PayPerView');
    Route::get('/subscription_search', 'AdminPaymentManagementController@Subscription_search');
    Route::get('/PayPerView_search', 'AdminPaymentManagementController@PayPerView_search')->name('PayPerView_search');
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

    Route::get('/allmoderator', 'ModeratorsUserController@view')->name('admin.allmoderator');
    Route::get('/moderatorsuser/edit/{id}', 'ModeratorsUserController@edit');
    Route::get('/moderatorsuser/delete/{id}', 'ModeratorsUserController@delete');
    Route::post('/moderatoruser/update', 'ModeratorsUserController@update');
    Route::get('/live_search', 'AdminVideosController@live_search');
    Route::get('/moderatorsuser-get-CPP-Commission', 'ModeratorsUserController@getCPPCommission')->name('ModeratorsUser.getCPPCommission');

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
    Route::get('/CPPLiveVideosIndex', 'AdminLiveStreamController@CPPLiveVideosIndex')->name('admin.livestream.');
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
Route::get('/load-more-series-networks',  'HomeController@loadMore')->name('load.more.series.networks');
Route::get('/Plancountry', 'AdminUsersController@PlanCountry');

    // CPP Payment
Route::get('/cpp-subscriptions-plans', 'CPPSubscriptionController@CPP_subscriptions_plans')->name('CPP_subscriptions_Plans');
Route::post('/cpp-stripe-authorization-url', 'CPPSubscriptionController@CPP_Stripe_authorization_url')->name('CPP_Stripe_authorization_url');
Route::get('/cpp-stripe-payment-verify', 'CPPSubscriptionController@CPP_Stripe_payment_verify')->name('CPP_Stripe_payment_verify');

// Channel Payment
    Route::get('/channel-subscriptions-plans', 'ChannelSubscriptionController@Channel_subscriptions_plans')->name('Channel_subscriptions_plans');
    Route::post('/channel-stripe-authorization-url', 'ChannelSubscriptionController@Channel_Stripe_authorization_url')->name('Channel_Stripe_authorization_url');
    Route::get('/channel-stripe-payment-verify', 'ChannelSubscriptionController@Channel_Stripe_payment_verify')->name('Channel_Stripe_payment_verify');
    

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


    Route::post('/upload_bunny_cdn_video', 'CPPAdminVideosController@UploadBunnyCDNVideo');
    Route::post('/bunnycdn_videolibrary', 'CPPAdminVideosController@BunnycdnVideolibrary');
    Route::post('/stream_bunny_cdn_video', 'CPPAdminVideosController@StreamBunnyCdnVideo');

    Route::post('/FlussonicUploadlibrary', 'CPPAdminVideosController@FlussonicUploadlibrary');
    Route::post('/Flussonic_Storage_UploadURL', 'CPPAdminVideosController@Flussonic_Storage_UploadURL');

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
    Route::post('video_exportCsv', 'CPPAnalyticsContrmyprofileoller@VideoExportCsv');

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
    Route::post('/bunnycdn_episodelibrary', 'CPPSeriesController@BunnycdnEpisodelibrary');
    Route::post('/stream_bunny_cdn_episode', 'CPPSeriesController@StreamBunnyCdnEpisode');
    Route::Post('/Series_Season_order', 'CPPSeriesController@Series_Season_order');
    Route::post('/Flussonicepisodelibrary', 'CPPSeriesController@Flussonicepisodelibrary');
    Route::post('/stream_Flussonic_episode', 'CPPSeriesController@StreamFlussonicEpisode');
    
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

    
    Route::post('/upload_bunny_cdn_video', 'ChannelVideosController@UploadBunnyCDNVideo');
    Route::post('/bunnycdn_videolibrary', 'ChannelVideosController@BunnycdnVideolibrary');
    Route::post('/stream_bunny_cdn_video', 'ChannelVideosController@StreamBunnyCdnVideo');

    Route::post('/FlussonicUploadlibrary', 'ChannelVideosController@FlussonicUploadlibrary');
    Route::post('/Flussonic_Storage_UploadURL', 'ChannelVideosController@Flussonic_Storage_UploadURL');


    // Channel Live Event for artist
    Route::get('/live-event-artist', 'ChannelLiveEventArtist@index')->name('channel_live_event_artist');
    Route::get('/live-event-create', 'ChannelLiveEventArtist@create')->name('channel_live_event_create');
    Route::post('/live-event-store', 'ChannelLiveEventArtist@store')->name('channel_live_event_store');
    Route::get('/live-event-edit/{id}', 'ChannelLiveEventArtist@edit')->name('channel_live_event_edit');
    Route::post('/live-event-update/{id}', 'ChannelLiveEventArtist@update')->name('channel_live_event_update');
    Route::get('/live-event-destroy/{id}', 'ChannelLiveEventArtist@destroy')->name('channel_live_event_destroy');
    Route::post('/livevideo_slider_update', 'ChannelLiveEventArtist@livevideo_slider_update');

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


    Route::get('/partner_monetization_analytics', 'ChannelAnalyticsController@ChannelPartnerMonetization');
    Route::get('/partner_monetization_history', 'ChannelAnalyticsController@ChannelPartnerMonetizationHistory')->name('channel.partner.monetization.history');
    Route::post('/PartnerAnalyticsCSV', 'ChannelAnalyticsController@PartnerAnalyticsCSV');
    Route::post('/PartnerHistoryCSV', 'ChannelAnalyticsController@PartnerHistoryCSV');
    Route::post('/partner-invoice/{id}', 'ChannelAnalyticsController@PartnerInvoice')->name('partner.invoice');

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
    Route::get('/video_search', 'ChannelVideosController@video_search');
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
    Route::post('/bunnycdn_episodelibrary', 'ChannelSeriesController@BunnycdnEpisodelibrary');
    Route::post('/stream_bunny_cdn_episode', 'ChannelSeriesController@StreamBunnyCdnEpisode');
    Route::Post('/Series_Season_order', 'ChannelSeriesController@Series_Season_order');
    Route::post('/Flussonicepisodelibrary', 'ChannelSeriesController@Flussonicepisodelibrary');
    Route::post('/stream_Flussonic_episode', 'ChannelSeriesController@StreamFlussonicEpisode');
    
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
    Route::get('/check-profile-limit', 'MultiprofileController@checkProfileLimit')->name('check-profile-limit');
    Route::post('/check-email', 'MultiprofileController@checkEmail')->name('check.email');
    Route::post('/check-mobile', 'MultiprofileController@checkMobile')->name('check.mobile');


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

    Route::get('networks/tv-shows/{slug}', 'TvshowsController@Specific_Series_Networks')->name('Specific_Series_Networks');
    Route::get('networks/tv-shows', 'TvshowsController@Series_Networks_List')->name('Series_Networks_List');

    // Filter
    Route::get('categoryfilter', 'ChannelController@categoryfilter')->name('categoryfilter');

    // Landing page  category videos
    Route::get('landing_category_series', 'LandingpageController@landing_category_series')->name('landing_category_series');

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

    // Content Partner

    Route::get('channel-partner', 'ChannelPartnerController@channelparnter')->name('channelparnter_index');
    Route::get('channel-partner/{slug}', 'ChannelPartnerController@unique_channelparnter')->name('channelparnter_details');

    Route::get('channel-addons', 'ChannelPartnerController@all_Channel_home')->name('channel.all_Channel_home');
    Route::get('channel-payment/{channel_id}', 'ChannelPartnerController@channelparnterpayment')->name('channel.payment');
    Route::get('channel-payment-gateway-depends-plans', 'ChannelPartnerController@payment_gateway_depends_plans')->name('channel.payment_gateway_depends_plans');

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
    Route::get('continue-watching-list', 'AllVideosListController@ContinueWatchingList')->name('ContinueWatchingList');
});


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
    Route::post('/RazorpayVideoRent_Paymentfailure', 'RazorpayController@RazorpayVideoRent_Paymentfailure')->name('RazorpayVideoRent_Paymentfailure');

    Route::get('/RazorpayVideoRent_PPV/{ppv_plan}/{video_id}/{amount}', 'RazorpayController@RazorpayVideoRent_PPV')->name('RazorpayVideoRent_PPV');

    Route::get('/RazorpayLiveRent/{live_id}/{amount}', 'RazorpayController@RazorpayLiveRent')->name('RazorpayLiveRent');
    Route::POST('/RazorpayLiveRent_Payment', 'RazorpayController@RazorpayLiveRent_Payment')->name('RazorpayLiveRent_Payment');
    Route::post('/RazorpayLiveRent_Paymentfailure', 'RazorpayController@RazorpayLiveRent_Paymentfailure')->name('RazorpayLiveRent_Paymentfailure');


    Route::get('/RazorpaySeriesSeasonRent/{SeriesSeason_id}/{amount}', 'RazorpayController@RazorpaySeriesSeasonRent')->name('RazorpaySeriesSeasonRent');
    Route::POST('/RazorpaySeriesSeasonRent_Payment', 'RazorpayController@RazorpaySeriesSeasonRent_Payment')->name('RazorpaySeriesSeasonRent_Payment');
    Route::POST('/RazorpaySeriesSeasonRent_Paymentfailure', 'RazorpayController@RazorpaySeriesSeasonRent_Paymentfailure')->name('RazorpaySeriesSeasonRent_Paymentfailure');

    Route::get('/RazorpaySeriesSeasonRent_PPV/{ppv_plan}/{SeriesSeason_id}/{amount}', 'RazorpayController@RazorpaySeriesSeasonRent_PPV')->name('RazorpaySeriesSeasonRent_PPV');


    // Route::get('/RazorpayModeratorPayouts/{user_id}/{amount}', 'RazorpayController@RazorpayModeratorPayouts')->name('RazorpayModeratorPayouts');
    Route::POST('/RazorpayModeratorPayouts', 'RazorpayController@RazorpayModeratorPayouts')->name('RazorpayModeratorPayouts');
    Route::POST('/RazorpayModeratorPayouts_Payment', 'RazorpayController@RazorpayModeratorPayouts_Payment')->name('RazorpayModeratorPayouts_Payment');

    Route::POST('/RazorpayChannelPayouts', 'RazorpayController@RazorpayChannelPayouts')->name('RazorpayChannelPayouts');
    Route::POST('/RazorpayChannelPayouts_Payment', 'RazorpayController@RazorpayChannelPayouts_Payment')->name('RazorpayChannelPayouts_Payment');
});

// Paydunya
Route::group(['middleware' => []], function () {
    Route::get('Paydunya-verify-request', 'PaydunyaPaymentController@Paydunya_verify_request')->name('Paydunya_verify_request');
    Route::post('Paydunya-checkout', 'PaydunyaPaymentController@Paydunya_checkout')->name('Paydunya_checkout');
    
    Route::get('/Paydunya_live_checkout_Rent_payment/{live_id}/{amount}', 'PaydunyaPaymentController@Paydunya_live_checkout_Rent_payment')->name('Paydunya_live_checkout_Rent_payment');
    Route::get('/Paydunya_live_Rent_payment_verify', 'PaydunyaPaymentController@Paydunya_live_Rent_payment_verify')->name('Paydunya_live_Rent_payment_verify');

    Route::get('/Paydunya_video_checkout_Rent_payment/{video_id}/{amount}', 'PaydunyaPaymentController@Paydunya_video_checkout_Rent_payment')->name('Paydunya_video_checkout_Rent_payment');
    Route::get('/Paydunya_video_Rent_payment_verify', 'PaydunyaPaymentController@Paydunya_video_Rent_payment_verify')->name('Paydunya_video_Rent_payment_verify');

    Route::get('/Paydunya_SeriesSeason_checkout_Rent_payment/{SeriesSeason_id}/{amount}', 'PaydunyaPaymentController@Paydunya_SeriesSeason_checkout_Rent_payment')->name('Paydunya_SeriesSeason_checkout_Rent_payment');
    Route::get('/Paydunya_SeriesSeason_Rent_payment_verify', 'PaydunyaPaymentController@Paydunya_SeriesSeason_Rent_payment_verify')->name('Paydunya_SeriesSeason_Rent_payment_verify');

    Route::get('/PaydunyaCancelSubscriptions', 'PaydunyaPaymentController@PaydunyaCancelSubscriptions')->name('PaydunyaCancelSubscriptions');
});


// Recurly Payment
Route::group(['prefix' => 'recurly', 'middleware' => []], function () {
    
    Route::post('checkout-page', 'RecurlyPaymentController@checkout_page')->name('Recurly.checkout_page');
    Route::get('createSubscription', 'RecurlyPaymentController@createSubscription')->name('Recurly.subscription');
    Route::get('subscription-cancel/{subscription_id}', 'RecurlyPaymentController@CancelSubscription')->name('Recurly.Subscription_cancel');
    Route::get('upgrade-subscription', 'RecurlyPaymentController@UpgradeSubscription')->name('Recurly.UpgradeSubscription');

    Route::post('channel-checkout-page', 'RecurlyPaymentChannelController@channel_checkout_page')->name('channel.Recurly.checkout_page');
    Route::get('channel-createSubscription', 'RecurlyPaymentChannelController@channelcreateSubscription')->name('channel.Recurly.subscription');
    Route::get('channel-subscription-cancel/{subscription_id}', 'RecurlyPaymentChannelController@channelCancelSubscription')->name('channel.Recurly.Subscription_cancel');
    Route::get('channel-upgrade-subscription', 'RecurlyPaymentChannelController@channeUpgradeSubscription')->name('channel.Recurly.UpgradeSubscription');
});

// Reset Password

Route::get('/Reset-Password', 'PasswordForgetController@Reset_Password')->name('Reset_Password');
Route::post('/Send-Reset-Password-link', 'PasswordForgetController@Send_Reset_Password_link')->name('Send_Reset_Password_link');
Route::get('/confirm-Reset-password/{crypt_email}/{reset_token}', 'PasswordForgetController@confirm_reset_password')->name('confirm_reset_password');
Route::post('/forget-password-update', 'PasswordForgetController@forget_password_update')->name('forget_password_update');

Route::get('/current-time', 'CurrentTimeController@current_time')->name('CurrentTimeController.current_time');

// Datafree URL 
if (Schema::hasTable('home_settings')) {

$datafree = App\HomeSetting::pluck('theme_choosen')->first();

    if ( $datafree == "theme5-nemisha") {
        Route::group(['prefix' => '', 'middleware' => []], function () {

            // welcome-screen
                Route::post('datafree/welcome-screen', 'WelcomeScreenController@Screen_store')->name('welcome-screen');
                Route::get('datafree/welcome-screen/destroy/{id}', 'WelcomeScreenController@destroy')->name('welcomescreen_destroy');
                Route::get('datafree/welcome-screen/edit/{id}', 'WelcomeScreenController@edit')->name('welcomescreen_edit');
                Route::post('datafree/welcome-screen/update/{id}', 'WelcomeScreenController@update')->name('welcomescreen_update');


                Route::get('datafree/Movie-Description', 'HomeController@Movie_description');

                    // Reels
                Route::get('datafree/Reals_videos/videos/{slug}', 'ChannelController@Reals_videos');

                    // Cast & crew
                Route::get('datafree/Artist/{slug}', 'ChannelController@artist_videos');

                // category List
                Route::get('datafree/categoryList', 'ChannelController@categoryList')->name('categoryList');
                Route::get('datafree/Movie-list', 'ChannelController@MovieList')->name('MovieList');
                Route::get('datafree/Live-list', 'ChannelController@liveList')->name('liveList');
                Route::get('datafree/Series-list', 'ChannelController@Series_List')->name('SeriesList');
                Route::get('datafree/Series/Genre/{id}', 'ChannelController@Series_genre_list')->name('Series_genre_list');
                Route::get('datafree/artist-list', 'ChannelController@artist_list')->name('artist_list');
                Route::get('datafree/LiveCategory/{slug}', 'ChannelController@LiveCategory')->name('LiveCategory');
                Route::get('datafree/CategoryLive/', 'ChannelController@CategoryLive')->name('CategoryLive');

                Route::get('datafree/audios/category/{slug}', 'HomePageAudioController@AudioCategory')->name('AudioCategory');
                Route::get('datafree/AudiocategoryList', 'HomePageAudioController@AudiocategoryList')->name('AudiocategoryList');

                Route::get('datafree/series/category/{slug}', 'TvshowsController@SeriesCategory')->name('SeriesCategory');
                Route::get('datafree/SeriescategoryList', 'TvshowsController@SeriescategoryList')->name('SeriescategoryList');

                    // Filter 
                Route::get('datafree/categoryfilter', 'ChannelController@categoryfilter')->name('categoryfilter');

                    // Landing page 
                Route::get('datafree/pages/{landing_page_slug}', 'LandingpageController@landing_page')->name('landing_page');

                    // Landing page  category videos
                Route::get('datafree/landing_category_series', 'LandingpageController@landing_category_series')->name('landing_category_series');

                // Channel List
                Route::get('datafree/channel/{slug}', 'ChannelHomeController@ChannelHome')->name('ChannelHome');
                Route::get('datafree/Channel-list', 'ChannelHomeController@ChannelList')->name('ChannelList');
                Route::get('datafree/channel_category_series', 'ChannelHomeController@channel_category_series')->name('channel_category_series');
                Route::get('datafree/channel_category_videos', 'ChannelHomeController@channel_category_videos')->name('channel_category_videos');
                Route::get('datafree/channel_category_audios', 'ChannelHomeController@channel_category_audios')->name('channel_category_audios');
                Route::get('datafree/channel_category_live', 'ChannelHomeController@channel_category_live')->name('channel_category_live');
                Route::get('datafree/all_Channel_videos', 'ChannelHomeController@all_Channel_videos')->name('all_Channel_videos');

                // Content Partner List
                Route::get('datafree/contentpartner/{slug}', 'ContentPartnerHomeController@ContentPartnerHome')->name('ContentPartnerHome');
                //   Route::get('ContentPartner/{slug}', 'ContentPartnerHomeController@ContentPartnerHome')->name('ContentPartnerHome');
                //   Route::get('Content-list', 'ContentPartnerHomeController@ContentList')->name('ContentList');
                Route::get('datafree/content-partners', 'ContentPartnerHomeController@ContentList')->name('ContentList');
                Route::get('datafree/Content_category_series', 'ContentPartnerHomeController@Content_category_series')->name('Content_category_series');
                Route::get('datafree/Content_category_videos', 'ContentPartnerHomeController@Content_category_videos')->name('Content_category_videos');
                Route::get('datafree/Content_category_audios', 'ContentPartnerHomeController@Content_category_audios')->name('Content_category_audios');
                Route::get('datafree/Content_category_live', 'ContentPartnerHomeController@Content_category_live')->name('Content_category_live');
                Route::get('datafree/all_Content_videos', 'ContentPartnerHomeController@all_Content_videos')->name('all_Content_videos');

                
                // CinetPay-Video Rent
                Route::post('datafree/CinetPaySubscription', 'CinetPayController@CinetPaySubscription')->name('CinetPay_Subscription');
                Route::post('datafree/CinetPay-video-rent', 'CinetPayController@CinetPay_Video_Rent_Payment')->name('CinetPay_Video_Rent_Payment');
                Route::post('datafree/CinetPay-audio-rent', 'CinetPayController@CinetPay_audio_Rent_Payment')->name('CinetPay_audio_Rent_Payment');
                Route::post('datafree/CinetPay-live-rent', 'CinetPayController@CinetPay_live_Rent')->name('CinetPay_live_Rent');
                    
                // CinetPay- Series/Season Rent
                Route::post('datafree/CinetPay-series_season-rent', 'PaymentController@CinetPay_series_season_Rent_Payment')->name('CinetPay_series_season_Rent_Payment');
                                    
                // Content Partner - Home Page

                Route::get('datafree/channel-partner', 'ChannelPartnerController@channelparnter')->name('channelparnter_index');
                Route::get('datafree/channel-partner/{slug}', 'ChannelPartnerController@unique_channelparnter')->name('channelparnter_details');
                
                // Live Event For artist 
                Route::get('datafree/live-artists-event', 'LiveEventArtistStream@index')->name('LiveEventArtistStream_index');
                Route::get('datafree/live-artist-event/{slug}', 'LiveEventArtistStream@live_event_play')->name('live_event_play');

                Route::post('datafree/live_event_tips', 'LiveEventArtistStream@live_event_tips')->name('live_event_tips');
                Route::post('datafree/stripePayment-Tips', 'LiveEventArtistStream@stripePaymentTips')->name('stripePaymentTips');
                Route::post('datafree/purchase-live-artist-event', 'LiveEventArtistStream@rent_live_artist_event')->name('rent_live_artist_event'); 

                Route::get('datafree/liveStream', 'AdminLiveStreamController@liveStream')->name('liveStream');



                // PPV_live_PurchaseUpdate

                Route::post('datafree/PPV_live_PurchaseUpdate', 'LiveStreamController@PPV_live_PurchaseUpdate')->name('PPV_live_PurchaseUpdate');
                Route::post('datafree/unseen_expirydate_checking', 'LiveStreamController@unseen_expirydate_checking')->name('unseen_expirydate_checking');

                // Paystack
                                    // Paystack-Subscription
                Route::post('datafree/Paystack-Subscription', 'PaystackController@Paystack_CreateSubscription')->name('Paystack_CreateSubscription');
                Route::get('datafree/paystack-verify-request', 'PaystackController@paystack_verify_request')->name('paystack_verify_request');
                Route::get('datafree/paystack-Andriod-verify-request', 'PaystackController@paystack_Andriod_verify_request')->name('paystack_Andriod_verify_request');
                Route::get('datafree/paystack-Subscription-update', 'PaystackController@paystack_Subscription_update')->name('paystack_Subscription_update');
                Route::get('datafree/Paystack-Subscription-cancel/{subscription_id}', 'PaystackController@Paystack_Subscription_cancel')->name('Paystack_Subscription_cancel');

                                    // Paystack-Video Rent
                Route::get('datafree/Paystack-video-rent/{video_id}/{amount}', 'PaystackController@Paystack_Video_Rent')->name('Paystack_Video_Rent');
                Route::get('datafree/Paystack-video-rent-paymentverify', 'PaystackController@Paystack_Video_Rent_Paymentverify')->name('Paystack_Video_Rent_Paymentverify');

                                    // Paystack-Live Rent
                Route::get('datafree/Paystack-live-rent/{live_id}/{amount}', 'PaystackController@Paystack_live_Rent')->name('Paystack_live_Rent');
                Route::get('datafree/Paystack-live-rent-paymentverify', 'PaystackController@Paystack_live_Rent_Paymentverify')->name('Paystack_live_Rent_Paymentverify');

                                    // Live Stream - M3U file
                Route::get('datafree/m3u_file_m3u8url', 'LiveStreamController@m3u_file_m3u8url')->name('m3u_file_m3u8url');
                Route::get('datafree/M3U_video_url', 'LiveStreamController@M3U_video_url')->name('M3U_video_url');

                                        //Rss Feed
                Route::get('datafree/Rss-Feed-index', 'RssFeedController@index')->name('Rss-Feed-index');
                Route::get('datafree/Rss-Feed-videos', 'RssFeedController@videos_view')->name('Rss-Feed-videos-view');
                Route::get('datafree/Rss-Feed-Livestream', 'RssFeedController@livestream_view')->name('Rss-Feed-Livestream-view');
                Route::get('datafree/Rss-Feed-episode', 'RssFeedController@episode_view')->name('Rss-Feed-episode-view');
                Route::get('datafree/Rss-Feed-audios', 'RssFeedController@audios_view')->name('Rss-Feed-audios-view');

                Route::get('datafree/feed', 'RssFeedController@feed')->name('feed');

                Route::get('datafree/comment_index', 'WebCommentController@comment_index')->name('comment.index');
                Route::get('datafree/comment_store', 'WebCommentController@comment_store')->name('comments.store');
                Route::get('datafree/comment_edit', 'WebCommentController@comment_edit')->name('comments.edit');
                Route::get('datafree/comment_update/{id}', 'WebCommentController@comment_update')->name('comments.update');
                Route::get('datafree/comment_destroy/{id}', 'WebCommentController@comment_destroy')->name('comments.destroy');

                Route::get('datafree/comment_reply/{id}', 'WebCommentController@comment_reply')->name('comments.reply');

                // Reset Password 

                Route::get('datafree/Reset-Password', 'PasswordForgetController@Reset_Password')->name('Reset_Password');
                Route::post('datafree/Send-Reset-Password-link', 'PasswordForgetController@Send_Reset_Password_link')->name('Send_Reset_Password_link');
                Route::get('datafree/confirm-Reset-password/{crypt_email}/{reset_token}', 'PasswordForgetController@confirm_reset_password')->name('confirm_reset_password');
                Route::post('datafree/forget-password-update', 'PasswordForgetController@forget_password_update')->name('forget_password_update');

                Route::get('datafree/current-time', 'CurrentTimeController@current_time')->name('CurrentTimeController.current_time');

                // Learn Page   
                Route::get('datafree/learn', 'AllVideosListController@learn')->name('learn');

                //All Video
                Route::get('datafree/library', 'AllVideosListController@all_videos')->name('all_videos');
                Route::get('datafree/Most-watched-videos', 'AllVideosListController@All_User_MostwatchedVideos')->name('All_User_MostwatchedVideos');
                Route::get('datafree/Most-watched-videos-country', 'AllVideosListController@All_Country_MostwatchedVideos')->name('All_Country_MostwatchedVideos');
                Route::get('datafree/Most-watched-videos-site', 'AllVideosListController@All_MostwatchedVideos')->name('All_MostwatchedVideos');

                // Free-Movies 
                Route::get('datafree/Free-Movies', 'AllVideosListController@Free_videos')->name('Free_videos');

                // Series
                Route::get('datafree/series/list', 'AllVideosListController@all_series')->name('all_series');
                Route::get('datafree/continue-watching-list', 'AllVideosListController@ContinueWatchingList');

                Route::post('datafree/schedule/videos', 'ChannelController@ScheduledVideos');
                Route::get('datafree/schedule/videos/embed/{name}','ChannelController@EmbedScheduledVideos');
                Route::get('datafree/videos/category/{cid}', 'ChannelController@channelVideos');
                Route::get('datafree/movies/category/{cid}', 'ChannelController@channelVideos');
                
                Route::post('datafree/register1', 'HomeController@PostcreateStep1');
                Route::get('datafree/verify-request', 'HomeController@VerifyRequest');
                Route::get('datafree/verify-request-sent', 'HomeController@VerifyRequestNotsent');
                Route::get('datafree/verify/{activation_code}', 'SignupController@Verify');
                Route::get('datafree/category/{cid}', 'ChannelController@channelVideos');
                Route::get('datafree/category/videos/{vid}', 'ChannelController@play_videos')->name('play_videos');
                Route::get('datafree/category/videos/{vid}','ChannelController@play_videos');
                Route::get('datafree/category/videos/embed/{vid}', 'ChannelController@Embed_play_videos');
                Route::get('datafree/language/{language}', 'ChannelController@LanguageVideo');
                Route::post('datafree/saveSubscription', 'PaymentController@saveSubscription');
                Route::get('datafree/category/wishlist/{slug}', 'ChannelController@Watchlist');
                Route::post('datafree/favorite', 'ThemeAudioController@add_favorite');
                Route::post('datafree/albumfavorite', 'ThemeAudioController@albumfavorite');
                Route::get('datafree/live/category/{cid}', 'LiveStreamController@channelVideos');
                
                //theme 3 full Player 
                Route::get('datafree/category/videos/play/{vid}', 'ChannelController@fullplayer_videos')->name('fullplayer_videos');
                
                
                Route::get('datafree/updatecard', 'PaymentController@UpdateCard');
                Route::get('datafree/my-refferals', 'PaymentController@MyRefferal');
                Route::get('datafree/nexmo', 'HomeController@nexmo')->name('nexmo');
                Route::post('datafree/nexmo', 'HomeController@verify')->name('nexmo');
                
                Route::get('datafree/serieslist', array('uses' => 'ChannelController@series', 'as' => 'series') );
                // Route::get('series/category/{id}', 'ChannelController@series_genre' );
                Route::get('datafree/datafreewatchlater', 'WatchLaterController@show_watchlaters');
                Route::get('datafree/myprofile', 'AdminUsersController@myprofile')->name('myprofile');
                Route::get('datafree/refferal', 'AdminUsersController@refferal');
                Route::post('datafree/profile/update', 'AdminUsersController@profileUpdate');   
                Route::get('datafree/latest-videos', 'HomeController@LatestVideos');
                Route::get('datafree/language/{lanid}/{language}', 'HomeController@LanguageVideo');
                Route::get('datafree/featured-videos', 'HomeController@Featured_videos');
                Route::post('datafree/mywishlist', 'WishlistController@mywishlist');
                Route::post('datafree/ppvWishlist', 'WishlistController@ppvWishlist');
                Route::get('datafree/mywishlists', 'WishlistController@show_mywishlists');
                Route::get('datafree/cancelSubscription', 'PaymentController@CancelSubscription');
                Route::get('datafree/renew', 'PaymentController@RenewSubscription');

                Route::post('datafree/upgradeSubscription', 'PaymentController@UpgradeSubscription');
                Route::post('datafree/upgrade-stripe-plan', 'PaymentController@UpgradeStripe');
                Route::post('datafree/upgrade-paypal-plan', 'PaymentController@UpgradePaypalPage');
                Route::post('datafree/upgradePaypal', 'PaymentController@upgradePaypal');
                Route::post('datafree/becomePaypal', 'PaymentController@BecomePaypal');
                Route::get('datafree/upgrade-subscription', 'PaymentController@Upgrade');

                Route::post('datafree/profile/update_username', 'AdminUsersController@update_username');   
                Route::post('datafree/profile/update_userImage', 'AdminUsersController@update_userImage');   
                Route::post('datafree/profile/update_userEmail', 'AdminUsersController@update_userEmail');   

                Route::get('datafree/upgrade-subscription_plan', 'PaymentController@Upgrade_Plan');
                Route::get('datafree/becomesubscriber', 'PaymentController@BecomeSubscriber')->name('payment_becomeSubscriber');
                Route::get('datafree/BecomeSubscriber_Plans', 'PaymentController@BecomeSubscriber_Plans')->name('BecomeSubscriber_Plans');
                Route::get('datafree/transactiondetails','PaymentController@TransactionDetails');

                Route::get('datafree/upgrading', 'PaymentController@upgrading');

                Route::get('datafree/channels', 'ChannelController@index');
                Route::get('datafree/ppvVideos', 'ChannelController@ppvVideos');
                Route::get('datafree/live', 'LiveStreamController@Index');
                // Route::get('/live/{play}/{id}', 'LiveStreamController@Play');

                Route::get('datafree/live/{id}', 'LiveStreamController@Play')->name('LiveStream_play');
                Route::get('datafree/live/{id}', 'LiveStreamController@Play')->name('LiveStream_play');
                Route::get('datafree/live/embed/{id}', 'LiveStreamController@EmbedLivePlay');


                Route::post('datafree/lifetime-subscription-payment', 'PaymentController@lifetime_subscription')->name('stripe.lifetime_subscription'); 

                Route::post('datafree/purchase-live', 'PaymentController@StoreLive')->name('stripe.store'); 
                Route::post('datafree/purchase-video', 'PaymentController@purchaseVideo');
                Route::post('datafree/purchase-videocount', 'AdminVideosController@purchaseVideocount');
                Route::post('datafree/player_analytics_create', 'AdminPlayerAnalyticsController@PlayerAnalyticsCreate');
                Route::post('datafree/player_analytics_store', 'AdminPlayerAnalyticsController@PlayerAnalyticsStore');
                Route::post('datafree/player_seektime_store', 'AdminPlayerAnalyticsController@PlayerSeekTimeStore');
                Route::post('datafree/purchase-episode', 'PaymentController@purchaseEpisode');
                Route::post('datafree/purchase-series', 'PaymentController@purchaseSeries');
                Route::get('datafree/ppvVideos/play_videos/{vid}', 'ChannelController@PlayPpv');
                Route::get('datafree/logout', 'AdminUsersController@logout');
                Route::post('datafree/stripe-payment', 'PaymentController@store')->name('stripe.store');
                Route::post('datafree/rentpaypal', 'PaymentController@RentPaypal');
                // Route::get('stripe', 'PaymentController@index');
                Route::get('datafree/myppv', 'ChannelController@Myppv');
                Route::get('datafree/stripe', 'SignupController@index');
                Route::post('datafree/stripe', 'SignupController@store');
                Route::get('datafree/form', 'SignupController@form');
                Route::get('datafree/roles', 'PermissionController@Permission');
                Route::post('datafree/mywishlist', 'WishlistController@mywishlist');
                Route::get('datafree/mywishlists', 'WishlistController@show_mywishlists');
                Route::post('datafree/LiveWishlist', 'WishlistController@LiveWishlist');
                Route::get('datafree/wishlist_video/{id}', 'WishlistController@wishlist_video');
                Route::get('datafree/file-upload', 'FileUploadController@index');
                Route::post('datafree/file-upload/upload', 'FileUploadController@fileStore')->name('upload');
                Route::post('datafree/profileupdate', 'AdminUsersController@ProfileImage');


            //custom login route 
            
                Route::get('datafree/mobileLogin', 'HomeController@mobileLogin');
                Route::post('datafree/stripesubscription', 'HomeController@stripes');
                Route::post('datafree/ckeditor/image_upload', 'AdminPageController@upload')->name('upload');
                Route::get('datafree/image/index', 'ImageController@index');
            
                Route::post('datafree/image/upload', 'ImageController@upload');
                Route::get('datafree/', 'HomeController@FirstLanging');

                // Reels 
            
                Route::get('datafree/reels', 'AdminReelsVideo@index');
            
            
                Route::get('datafree/home', 'HomeController@index')->name('home');
            
                /*TV-shows */ 
                Route::get('datafree/tv-shows', 'TvshowsController@index');
                Route::get('datafree/episode/{series_name}/{episode_name}', 'TvshowsController@play_episode')->name('play_episode');
                Route::get('datafree/episode/embed/{series_name}/{episode_name}', 'TvshowsController@Embedplay_episode');
                Route::get('datafree/episode/{episode_name}', 'TvshowsController@PlayEpisode');
            
                Route::get('datafree/play_series/{name}/', 'TvshowsController@play_series');    
            
                /* Audio Pages */
                Route::get('datafree/audios', 'ThemeAudioController@audios');
                Route::get('datafree/artist/{slug}', 'ThemeAudioController@artist' );
            
                Route::post('datafree/artist/following', 'ThemeAudioController@ArtistFollow' );
                Route::get('datafree/audio/{slug}', 'ThemeAudioController@index')->name('play_audios');
                Route::get('datafree/album/{album_slug}', 'ThemeAudioController@album');
                Route::get('datafree/albums-list', 'ThemeAudioController@albums_list')->name('albums_list');
            
                    
                Route::post('datafree/sendOtp', 'HomeController@SendOTP');
                Route::post('datafree/verifyOtp', 'HomeController@verifyOtp');  
                Route::post('datafree/directVerify', 'SignupController@directVerify');
                Route::get('datafree/signup', 'SignupController@createStep1')->name('signup');
                Route::post('datafree/SignupMobile_val', 'SignupController@SignupMobile_val')->name('SignupMobile_val');
            
                
            
                Route::get('datafree/registerUser', 'SignupController@SaveAsRegisterUser');
                Route::get('datafree/register2', 'SignupController@createStep2');

                Route::post('datafree/remove-image', 'SignupController@removeImage');
                Route::post('datafree/store', 'SignupController@store');
                Route::get('datafree/data', 'SignupController@index');
                Route::get('datafree/stripe1', 'PaymentController@stripe');
                Route::post('datafree/stripe', 'PaymentController@stripePost')->name('stripe.post');
            
                                // search
                Route::get('datafree/search','HomeController@search');
                Route::post('datafree/searchResult', 'HomeController@searchResult')->name('searchResult');
                Route::get('datafree/search-videos/{videos_search_value}', 'HomeController@searchResult_videos')->name('searchResult_videos');
                Route::get('datafree/search-livestream/{livestreams_search_value}', 'HomeController@searchResult_livestream')->name('searchResult_livestream');
                Route::get('datafree/search-series/{series_search_value}', 'HomeController@searchResult_series')->name('searchResult_series');
                Route::get('datafree/search-episode/{Episode_search_value}', 'HomeController@searchResult_episode')->name('searchResult_episode');
                Route::get('datafree/search-audios/{Audios_search_value}', 'HomeController@searchResult_audios')->name('searchResult_audios');
            
                Route::get('datafree/showPayperview', 'WatchLaterController@showPayperview');
                Route::post('datafree/watchlater', 'WatchLaterController@watchlater');
                Route::get('datafree/purchased-media', 'WatchLaterController@showPayperview');
                Route::post('datafree/addwatchlater', 'WatchLaterController@watchlater');
                Route::post('datafree/ppvWatchlater', 'WatchLaterController@ppvWatchlater');
                Route::get('datafree/promotions', 'HomeController@promotions');
                Route::get('datafree/page/{slug}', 'PagesController@index');
            
            // Episode watchlater and wishlist
            
                Route::get('datafree/episode_watchlist', 'WatchLaterController@episode_watchlist');
                Route::get('datafree/episode_watchlist_remove', 'WatchLaterController@episode_watchlist_remove');
            
                Route::get('datafree/episode_wishlist', 'WishlistController@episode_wishlist');
                Route::get('datafree/episode_wishlist_remove', 'WishlistController@episode_wishlist_remove');
            
                Route::post('datafree/like-episode', 'TvshowsController@LikeEpisode');
                Route::post('datafree/remove_like-episode', 'TvshowsController@RemoveLikeEpisode');
            
                Route::post('datafree/dislike-episode', 'TvshowsController@DisLikeEpisode');
                Route::post('datafree/remove_dislike-episode', 'TvshowsController@RemoveDisLikeEpisode');
        });
    }
}
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

Route::get('video-player/{slug}/{plan}', 'ChannelController@video_js_fullplayer');

Route::post('video_js_watchlater', 'ChannelController@video_js_watchlater')->name('video-js.watchlater');

Route::post('video_js_wishlist', 'ChannelController@video_js_wishlist')->name('video-js.wishlist');

Route::post('video_js_Like', 'ChannelController@video_js_Like')->name('video-js.like');

Route::post('video_js_dislike', 'ChannelController@video_js_disLike')->name('video-js.dislike');

Route::post('videojs_live_watchlater', 'LiveStreamController@videojs_live_watchlater')->name('videojs.live.watchlater');

Route::post('videojs_live_Like', 'LiveStreamController@videojs_live_Like')->name('videojs.live.like');

Route::post('videojs_live_dislike', 'LiveStreamController@videojs_live_disLike')->name('videojs.live.dislike');

Route::get('/livestream-fetch-timeline', 'LiveStreamController@fetchTimeline')->name('livestream-fetch-timeline');

Route::get('rentals', 'MoviesHomePageController@index')->name('videos.Movies-Page');

Route::get('/channel-video-scheduler/{slug}', 'ChannelVideoSchedulerController@index')->name('Front-End.Channel-video-scheduler');

Route::get('/channel-video-scheduler-List', 'ChannelVideoSchedulerController@page_list')->name('Front-End.Channel-video-scheduler.page_list');

Route::get('Landing-page-email-capture', 'LandingPageEmailCaptureController@store')->name('Landing-page-email-capture');

Route::get('activationcode', 'AdminUsersController@myprofile');

Route::get('EPG_date_filter', 'HomeController@EPG_date_filter')->name('front-end.EPG_date_filter');

// videoJs player continue watching
Route::post('saveContinueWatching','ChannelController@saveContinueWatching')->name('saveContinueWatching');
Route::post('EpisodeContinueWatching','TvshowsController@EpisodeContinueWatching')->name('EpisodeContinueWatching');

// For theme6 

Route::post('HomePage-watchlater', 'HomeController@Homepage_watchlater')->name('home-page.watchlater');

Route::post('HomePage-wishlist', 'HomeController@Homepage_wishlist')->name('home-page.wishlist');

// Test Page
Route::get('/testpage', function () {
    return view('testpage');
})->name('testpage');

// Version Info 
Route::get('version-info', 'VersionInfoController@version_info')->name('version.info');

// User Generated Content
Route::get('ugc-create', 'UGCController@create');
Route::get('ugc-edit/{id}', 'UGCController@edit');
Route::get('ugc-editvideo/{id}', 'UGCController@editvideo');
Route::post('ugc/uploadEditUGCVideo', 'UGCController@uploadEditUGCVideo');
Route::post('ugc/uploadEditUGCVideo', 'UGCController@AWSuploadEditUGCVideo');
Route::post('ugc/update', ['before' => 'demo', 'uses' => 'UGCController@update']);
Route::get('ugc-delete/{id}', ['before' => 'demo', 'uses' => 'UGCController@destroy']);
Route::get('ugc/video-player/{slug}', 'UGCController@PlayUGCVideos')->name('play_ugc_videos');
Route::post('/ugc/fileupdate', ['before' => 'demo', 'uses' => 'UGCController@ugcfileupdate']);
Route::post('ugc/uploadFile', 'UGCController@uploadFile');
Route::post('ugc/AWSUploadFile', 'UGCController@AWSUploadFile');
Route::post('ugc/mp4url', 'UGCController@Mp4url');
Route::post('ugc/updatemp4url', 'UGCController@Updatemp4url');
Route::post('ugc/m3u8url', 'UGCController@m3u8url');
Route::post('ugc/updatem3u8url', 'UGCController@Updatem3u8url');
Route::post('ugc/embededcode', 'UGCController@Embededcode');
Route::post('ugc/updateembededcode', 'UGCController@UpdateEmbededcode');
Route::post('ugc/submit-ugcabout', 'UGCController@SubmitUGCAbout')->name('ugc.about.submit');
Route::post('ugc/submit-ugcfacebook', 'UGCController@SubmitUGCFacebook')->name('ugc.facebook.submit');
Route::post('ugc/submit-ugcinstagram', 'UGCController@SubmitUGCInstagram')->name('ugc.instagram.submit');
Route::post('ugc/submit-ugctwitter', 'UGCController@SubmitUGCTwitter')->name('ugc.twitter.submit');
Route::post('/comment/like', 'WebCommentController@like')->name('comment.like');
Route::post('/comment/dislike', 'WebCommentController@dislike')->name('comment.dislike');
Route::post('ugc_watchlater', 'UGCController@ugc_watchlater')->name('ugc_watchlater');
Route::post('ugc_wishlist', 'UGCController@ugc_wishlist')->name('ugc_wishlist');
Route::post('ugc_like', 'UGCController@ugc_like')->name('ugc_like');
Route::post('ugc_dislike', 'UGCController@ugc_dislike')->name('ugc_dislike');
Route::get('/profile/{username}', 'UGCController@showugcprofile')->name('profile.show');
Route::post('/subscribe', 'UGCController@subscribe')->name('subscribe');
Route::post('/unsubscribe', 'UGCController@unsubscribe')->name('unsubscribe');
Route::get('ugc/view_all_profile', 'UGCController@viewallprofile')->name('viewallprofile');
Route::post('ugc/video_slug_validate', 'UGCController@video_slug_validate');
Route::post('ugc/extractedimage', 'UGCController@ExtractedImage');

// UGC management admin
Route::get('admin/ugc_videos', 'UGCController@index')->name('ugcvideos');
Route::get('admin/ugc_videos_index', 'UGCController@UGCvideosIndex')->name('ugcvideos_index');
Route::get('admin/ugc_videos_approval/{id}', 'UGCController@UGCVideosApproval');
Route::get('admin/ugc_videos_reject/{id}', 'UGCController@UGCVideosReject');

Route::get('/fetch-timeline', [LiveStreamController::class, 'fetchTimeline'])->name('fetch-timeline');

// Revenue Settings

Route::get('admin/partner_monetization_settings/index', 'AdminPartnerMonetizationSettings@Index')->name('partner_monetization_settings');
Route::post('admin/partner_monetization_settings/store', 'AdminPartnerMonetizationSettings@Store');
Route::get('admin/partner_monetization_settings/edit/{id}', 'AdminPartnerMonetizationSettings@Edit');
Route::post('admin/partner_monetization_settings/update', 'AdminPartnerMonetizationSettings@Update');

// Partner Monetization Payouts
Route::get('admin/partner_monetization_payouts/index', 'AdminPartnerMonetizationPayouts@index')->name('partner-monetization-payouts');
Route::get('admin/partner_monetization_payouts/analytics', 'AdminPartnerMonetizationPayouts@PartnerAnalytics')->name('partner-monetization-analytics');
Route::get('admin/partner_monetization_payouts/partner_payment/{id}', 'AdminPartnerMonetizationPayouts@Partnerpayment');
Route::post('admin/partner_monetization_payouts/store', 'AdminPartnerMonetizationPayouts@Store');
Route::get('admin/partner_monetization_payouts/history', 'AdminPartnerMonetizationPayouts@PartnerPaymentHistory')->name('partner-monetization-history');
Route::get('/get-channel-data/{id}', 'AdminPartnerMonetizationPayouts@getChannelData' )->name('get.channel.data');
Route::get('/admin/get-user-details/{id}', 'AdminPartnerMonetizationPayouts@getUserDetails')->name('get.user.details');

Route::post('PartnerMonetization','ChannelController@PartnerMonetization')->name('PartnerMonetization');
Route::post('EpisodePartnerMonetization','TvshowsController@EpisodePartnerMonetization')->name('EpisodePartnerMonetization');
Route::post('LivestreamPartnerMonetization', 'AdminLiveStreamController@LivestreamPartnerMonetization')->name('LivestreamPartnerMonetization');

Route::get('admin/transaction_details', 'AdminTransactionDetailsController@index')->name('admin.transaction-details.index');
Route::get('admin/transaction_details/{unique_id}/edit', 'AdminTransactionDetailsController@edit')->name('admin.transaction-details.edit');
Route::post('admin/transaction_details/{unique_id}/update', 'AdminTransactionDetailsController@update')->name('admin.transaction-details.update');
Route::get('admin/transaction_details/{unique_id}/show', 'AdminTransactionDetailsController@show')->name('admin.transaction-details.show');
Route::get('admin/transaction_live_search', 'AdminTransactionDetailsController@live_search');
Route::get('admin/missing-transaction', 'RazorpayController@Razorpay_Missingtransaction')->name('admin.transaction-details.missing-transaction');

// Analytics management
Route::get('/admin/analytics', 'AdminUsersController@AnalyticsIndex')->name('admin.analytics.index');

// Unassigned episodes assign
Route::post('season/unassigned_episodes','AdminSeriesController@UnassignedEpisodes')->name('season.unassigned_episodes');
Route::get('/get-epg-content', 'LiveStreamController@getEpgContent');
Route::post('/toggle-favorite','LiveStreamController@toggleFavorite')->name('toggle.favorite');
Route::post('datafree/toggle-favorite', 'LiveStreamController@toggleFavorite')->name('toggle.favorite');

Route::post('getSeriesEpisodeImg','FrontEndQueryController@getSeriesEpisodeImg')->name('getSeriesEpisodeImg');
Route::post('getModalEpisodeImg','FrontEndQueryController@getModalEpisodeImg')->name('getModalEpisodeImg');
Route::post('getLiveDropImg','FrontEndQueryController@getLiveDropImg')->name('getLiveDropImg');
Route::post('getnetworkSeriesImg','FrontEndQueryController@getnetworkSeriesImg')->name('getnetworkSeriesImg');
Route::post('getSeriesNetworkModalImg','FrontEndQueryController@getSeriesNetworkModalImg')->name('getSeriesNetworkModalImg');
Route::post('getLatestSeriesImg','FrontEndQueryController@getLatestSeriesImg')->name('getLatestSeriesImg');
Route::post('getLiveModal','FrontEndQueryController@getLiveModal')->name('getLiveModal');

Route::get('/series/image/{series_id}', function ($series_id) {
    $image = Series::where('id', $series_id)->pluck('image')->first();

    $BunnyCDNEnable = \App\StorageSetting::pluck('bunny_cdn_storage')->first();
    $defaultVerticalImageUrl = default_vertical_image_url();

    $BaseURL = $BunnyCDNEnable == 1 
        ? \App\StorageSetting::pluck('bunny_cdn_base_url')->first()
        : url('public/uploads');

    // Generate full image URL
    $image = ($image !== 'default_image.jpg')
        ? $BaseURL . '/images/' . $image
        : $defaultVerticalImageUrl;

    return response()->json(['image_url' => $image]);
})->name('network.series.image');

Route::get('/header_menus','HomeController@header_menus')->name('header_menus');
Route::get('/fetch-menus', 'HomeController@fetchMenus');