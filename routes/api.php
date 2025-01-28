<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    [
        'prefix' => 'auth',
    ],
    function () {

        Route::addRoute(['GET', 'POST'], 'All_Homepage', 'ApiAuthController@All_Homepage');

        Route::post('All_Pagelist', 'ApiAuthController@All_Pagelist');
        Route::post('Network_depends_series', 'ApiAuthController@Network_depends_series');

        Route::get('Interest-Genre-list', 'ApiAuthController@Interest_Genre_list');
        Route::post('Users-Interest-Genres', 'ApiAuthController@users_interest_genres');
        Route::post('Users-Password-Pin-Update', 'ApiAuthController@Users_Password_Pin_Update');
        Route::get('website-baseurl', 'ApiAuthController@website_baseurl');
        Route::post('Series-details', 'ApiAuthController@Series_details');

        Route::post('Channel-Audios-list', 'ApiAuthController@Channel_Audios_list');
        Route::post('Channel-livevideos-list', 'ApiAuthController@Channel_livevideos_list');
        Route::post('Channel-series-list', 'ApiAuthController@Channel_series_list');
        Route::post('Channel-videos-list', 'ApiAuthController@Channel_videos_list');
        
        // Search 
        Route::post('search', 'ApiAuthController@search');
        Route::post('searchapi', 'ApiAuthController@searchapi');
        Route::post('tv_search', 'ApiAuthController@TV_Search');
        Route::post('search_andriod', 'ApiAuthController@search_andriod');

        Route::post('series_image_details', 'ApiAuthController@series_image_details');

        Route::get('home_page', 'ApiAuthController@PageHome');
        Route::get('PageHome_Livestream', 'ApiAuthController@PageHome_Livestream');
        
        Route::post('login', 'ApiAuthController@login');
        Route::post('signup', 'ApiAuthController@signup');
        Route::post('verify-activation-code', 'ApiAuthController@verify_activation_code');
        Route::post('resend-activation-code', 'ApiAuthController@resend_activation_code');
        Route::post('directVerify', 'ApiAuthController@directVerify');
        Route::post('resetpassword', 'ApiAuthController@resetpassword');
        Route::post('updatepassword', 'ApiAuthController@updatepassword');
        Route::post('changepassword', 'ApiAuthController@changepassword');
        Route::post('verifyandupdatepassword', 'ApiAuthController@verifyandupdatepassword');

        Route::post('verify-token-reset-password', 'ApiAuthController@verify_token_reset_password');
        Route::post('update-reset-password', 'ApiAuthController@update_reset_password');

        Route::get('latestvideos', 'ApiAuthController@latestvideos');
        Route::get('categorylist', 'ApiAuthController@categorylist');
        Route::post('channelvideos', 'ApiAuthController@channelvideos');
        Route::post('channelvideosIOS', 'ApiAuthController@channelvideosIOS');
        Route::get('categoryvideos', 'ApiAuthController@categoryvideos');
        Route::get('categoryvideosIOS', 'ApiAuthController@categoryvideosIOS');
        Route::post('videodetail', 'ApiAuthController@videodetail');
        Route::get('livestreams', 'ApiAuthController@livestreams');
        Route::post('livestreamdetail', 'ApiAuthController@livestreamdetail');
        Route::post('M3u_channel_videos', 'ApiAuthController@M3u_channel_videos');
        Route::get('cmspages', 'ApiAuthController@cmspages');
        Route::get('sliders', 'ApiAuthController@sliders');
        Route::post('coupons', 'ApiAuthController@coupons');
        Route::get('mobile_sliders', 'ApiAuthController@MobileSliders');
        Route::get('ppvvideos', 'ApiAuthController@ppvvideos');
        Route::post('ppvvideodetail', 'ApiAuthController@ppvvideodetail');
        Route::post('PPVVideodetails', 'ApiAuthController@PPVVideodetails');

        Route::post('updateProfile', 'ApiAuthController@updateProfile');
        Route::post('addwishlist', 'ApiAuthController@addwishlist');
        Route::post('addfavorite', 'ApiAuthController@addfavorite');
        Route::post('addwatchlater', 'ApiAuthController@addwatchlater');
        Route::post('myWishlists', 'ApiAuthController@myWishlists');
        Route::post('Wishlists_list', 'ApiAuthController@Wishlists_list');
        Route::post('myFavorites', 'ApiAuthController@myFavorites');
        Route::post('Favourites_list', 'ApiAuthController@Favourites_list');
        Route::post('mywatchlaters', 'ApiAuthController@mywatchlaters');
        Route::post('showWishlist', 'ApiAuthController@showWishlist');
        Route::post('showFavorites', 'ApiAuthController@showFavorites');
        Route::post('showWatchlater', 'ApiAuthController@showWatchlater');
        Route::post('getPPV', 'ApiAuthController@getPPV');
        Route::post('getLivepurchased', 'ApiAuthController@getLivepurchased');
        Route::get('settings', 'ApiAuthController@settings');
        Route::post('upgradesubscription', 'ApiAuthController@upgradesubscription');
        Route::post('cancelsubscription', 'ApiAuthController@cancelsubscription');
        Route::post('renewsubscription', 'ApiAuthController@renewsubscription');

        // Stripe become_subscriber New
        Route::post('stripe-become-subscriber', 'ApiAuthController@stripe_become_subscriber');
        Route::post('retrieve_stripe_coupon', 'ApiAuthController@retrieve_stripe_coupon');

        // Stripe become_subscriber Old 
        Route::post('becomesubscriber', 'ApiAuthController@becomesubscriber');

        Route::post('subscriptiondetail', 'ApiAuthController@subscriptiondetail');
        Route::post('subscriptiondetail', 'ApiAuthController@subscriptiondetail');
        Route::post('add_payperview', 'ApiAuthController@add_payperview');
        Route::post('add_livepayperview', 'ApiAuthController@add_livepayperview');
        Route::post('addppvpaypal', 'ApiAuthController@AddPpvPaypal');
        Route::get('splash', 'ApiAuthController@splash');
        Route::get('payment_settings', 'ApiAuthController@payment_settings');
        Route::post('ViewProfile', 'ApiAuthController@ViewProfile');
        Route::get('getCountries', 'ApiAuthController@getCountries');
        Route::post('getStates', 'ApiAuthController@getStates');
        Route::post('getCities', 'ApiAuthController@getCities');
        Route::get('stripe_onetime', 'ApiAuthController@StripeOnlyTimePlan');
        Route::get('stripe_recurring', 'ApiAuthController@StripeRecurringPlan');
        Route::get('paypal_onetime', 'ApiAuthController@PaypalOnlyTimePlan');
        Route::get('paypal_recurring', 'ApiAuthController@PaypalRecurringPlan');
        Route::post('relatedchannelvideos', 'ApiAuthController@relatedchannelvideos');
        Route::post('relatedppvvideos', 'ApiAuthController@relatedppvvideos');
        Route::get('isPaymentEnable', 'ApiAuthController@isPaymentEnable');
        Route::post('checkEmailExists', 'ApiAuthController@checkEmailExists');
        Route::post('SendOtp', 'ApiAuthController@SendOtp');
        Route::post('VerifyOtp', 'ApiAuthController@VerifyOtp');
        Route::post('refferal', 'ApiAuthController@refferal');
        Route::post('/stripe/billings-details', 'ApiAuthController@ViewStripe');
        Route::post('/social_user', 'ApiAuthController@SocialUser');
        Route::get('/check_block_list', 'ApiAuthController@CheckBlockList');
        Route::get('/skip_time', 'ApiAuthController@SkipTime');
        Route::post('/next_video', 'ApiAuthController@NextVideo');
        Route::post('/prev_video', 'ApiAuthController@PrevVideo');
        Route::get('/sociallink', 'ApiAuthController@sociallinks');
        Route::post('/dislike', 'ApiAuthController@DisLikeVideo');
        Route::post('/like', 'ApiAuthController@LikeVideo');
        Route::post('/like_dislike', 'ApiAuthController@LikeDisLike');
        Route::get('popular_series', 'ApiAuthController@popular_series');
        Route::get('serieslist', 'ApiAuthController@serieslist');
        Route::post('seasonlist', 'ApiAuthController@seasonlist');
        Route::post('seriesepisodes', 'ApiAuthController@seriesepisodes');
        Route::post('episodedetails', 'ApiAuthController@episodedetails');
        Route::post('episodedetails_android', 'ApiAuthController@episodedetailsAndriod');
        Route::post('episodedetails_IOS', 'ApiAuthController@episodedetailsIOS');
        Route::post('relatedepisodes', 'ApiAuthController@relatedepisodes');
        Route::post('seasonepisodes', 'ApiAuthController@SeasonsEpisodes');
        Route::post('user_notifications', 'ApiAuthController@seasonepisodes');
        Route::post('user_comments', 'ApiAuthController@UserComments');
        Route::post('add_comment', 'ApiAuthController@AddComment');
        Route::get('series_title_status', 'ApiAuthController@SeriesTitle');
        Route::get('cast_lists', 'ApiAuthController@CastList');
        Route::post('mobile_signup', 'ApiAuthController@MobileSignup');
        Route::post('mobile_login', 'ApiAuthController@MobileLogin');

        // Episode like & Dislike
        Route::post('Episode_like', 'ApiAuthController@Episode_like');
        Route::post('Episode_dislike', 'ApiAuthController@Episode_dislike');
        Route::post('Episode_addfavorite', 'ApiAuthController@Episode_addfavorite');
        Route::post('Episode_addwishlist', 'ApiAuthController@Episode_addwishlist');
        Route::post('Episode_addwatchlater', 'ApiAuthController@Episode_addwatchlater');

        // Audio Like & Dislike

        Route::post('audio_like', 'ApiAuthController@audio_like');
        Route::post('audio_dislike', 'ApiAuthController@audio_dislike');

        // Season and Episodes list
        Route::post('SeasonsEpisodes', 'ApiAuthController@SeasonsEpisodes');
        // Wishlist Next Prev Video
        Route::post('nextwishlistvideo', 'ApiAuthController@nextwishlistvideo');
        Route::post('prevwishlistvideo', 'ApiAuthController@prevwishlistvideo');
        // Watchlater Next Prev Video
        Route::post('nextwatchlatervideo', 'ApiAuthController@nextwatchlatervideo');
        Route::post('prevwatchlatervideo', 'ApiAuthController@prevwatchlatervideo');

        // Favourite Next Prev Video
        Route::post('nextfavouritevideo', 'ApiAuthController@nextfavouritevideo');
        Route::post('prevfavouritevideo', 'ApiAuthController@prevfavouritevideo');

        // Season  Next Prev Episode
        Route::post('NextEpisode', 'ApiAuthController@NextEpisode');
        Route::post('PrevEpisode', 'ApiAuthController@PrevEpisode');
        // Wishlist Next Prev Video
        Route::post('nextwishlistEpisode', 'ApiAuthController@nextwishlistEpisode');
        Route::post('prevwishlistEpisode', 'ApiAuthController@prevwishlistEpisode');

        // Watchlater Next Prev Episode
        Route::post('nextwatchlaterEpisode', 'ApiAuthController@nextwatchlaterEpisode');
        Route::post('prevwatchlaterEpisode', 'ApiAuthController@prevwatchlaterEpisode');

        // Favourite Next Prev Episode
        Route::post('nextfavouriteEpisode', 'ApiAuthController@nextfavouriteEpisode');
        Route::post('prevfavouriteEpisode', 'ApiAuthController@prevfavouriteEpisode');

        //  Palyer UI Settings

        Route::post('Playerui', 'ApiAuthController@Playerui');

        Route::get('Playerui', 'ApiAuthController@Playerui');

        Route::post('Playerui', 'ApiAuthController@Playerui');

        Route::get('Playerui', 'ApiAuthController@Playerui');

        // Route::post('Useraccesslogin', 'ApiAuthController@Useraccesslogin');
        Route::get('Moderatorsuser', 'ApiAuthController@Moderatorsuser');

        Route::get('Useraccess', 'ApiAuthController@Useraccess');

        Route::get('Moderatorsrole', 'ApiAuthController@Moderatorsrole');

        Route::get('Moderatorspermission', 'ApiAuthController@Moderatorspermission');

        Route::post('addtocontinuewatching', 'ApiAuthController@addtocontinuewatching');

        Route::post('listcontinuewatchings', 'ApiAuthController@listcontinuewatchings');

        Route::post('episode-continuewatching-update', 'ApiAuthController@episode_continuewatching_update');

        Route::post('remove_continue_watchingvideo', 'ApiAuthController@remove_continue_watchingvideo');

        Route::post('remove_continue_watchingepisode', 'ApiAuthController@remove_continue_watchingepisode');

        Route::post('EpisodeContinuewatching', 'ApiAuthController@EpisodeContinuewatching');

        Route::post('listcontinuewatchingsepisode', 'ApiAuthController@listcontinuewatchingsepisode');

        Route::post('addchilduserprofile', 'ApiAuthController@addchilduserprofile');

        Route::post('viewchildprofile', 'ApiAuthController@viewchildprofile');
        Route::post('updatechildprofile', 'ApiAuthController@updatechildprofile');

        Route::post('savefavouritecategory', 'ApiAuthController@savefavouritecategory');

        Route::get('getRecentAudios', 'ApiAuthController@getRecentAudios');
        Route::post('audiodetail', 'ApiAuthController@audiodetail');
        Route::post('next_audio', 'ApiAuthController@next_audio');
        Route::post('prev_audio', 'ApiAuthController@prev_audio');
        Route::post('relatedaudios', 'ApiAuthController@relatedaudios');
        Route::get('categoryaudios', 'ApiAuthController@categoryaudios');
        Route::get('artistlist', 'ApiAuthController@artistlist');
        Route::post('artistfavorites', 'ApiAuthController@artistfavorites');
        Route::post('artistfollowings', 'ApiAuthController@artistfollowings');
        Route::post('artistaddremovefav', 'ApiAuthController@artistaddremovefav');
        Route::post('artistaddremovefollow', 'ApiAuthController@artistaddremovefollow');
        Route::post('artistdetail', 'ApiAuthController@artistdetail');
        Route::post('upnextAudio', 'ApiAuthController@upnextAudio');
        Route::post('similarAudio', 'ApiAuthController@similarAudio');
        Route::get('trendingaudio', 'ApiAuthController@trendingaudio');
        Route::get('albumlist', 'ApiAuthController@albumlist');
        Route::post('albumaudios', 'ApiAuthController@albumaudios');
        Route::post('addwatchlateraudio', 'ApiAuthController@addwatchlateraudio');
        Route::post('addwishlistaudio', 'ApiAuthController@addwishlistaudio');
        Route::post('addfavoriteaudio', 'ApiAuthController@addfavoriteaudio');
        Route::post('/dislikeaudio', 'ApiAuthController@DisLikeAudio');
        Route::post('/likeaudio', 'ApiAuthController@LikeAudio');
        Route::get('AllAudios', 'ApiAuthController@AllAudios');
        Route::post('mywatchlatersaudio', 'ApiAuthController@mywatchlatersaudio');
        Route::post('myFavoriteaudio', 'ApiAuthController@myFavoriteaudio');
        Route::get('Alllanguage', 'ApiAuthController@Alllanguage');
        Route::post('VideoLanguage', 'ApiAuthController@VideoLanguage');
        Route::get('FeaturedVideo ', 'ApiAuthController@FeaturedVideo');
        Route::post('RecentViews ', 'ApiAuthController@RecentViews');
        Route::get('RecentlyViewed ', 'ApiAuthController@RecentlyViewed');
        Route::get('RecentlyViewedVideos ', 'ApiAuthController@RecentlyViewedVideos');
        Route::post('AddRecentAudio ', 'ApiAuthController@AddRecentAudio');
        Route::get('SubscriptionEndNotification ', 'ApiAuthController@SubscriptionEndNotification');
        Route::post('SubscriptionPayment', 'ApiAuthController@SubscriptionPayment');
        Route::get('SubscriberedUsers ', 'ApiAuthController@SubscriberedUsers');
        Route::post('LocationCheck ', 'ApiAuthController@LocationCheck');

        Route::post('myWishlistsEpisode', 'ApiAuthController@myWishlistsEpisode');
        Route::post('mywatchlatersEpisode', 'ApiAuthController@mywatchlatersEpisode');
        Route::post('myFavoritesEpisode', 'ApiAuthController@myFavoritesEpisode');
        Route::post('addwatchlaterEpisode', 'ApiAuthController@addwatchlaterEpisode');
        Route::post('addwishlistEpisode', 'ApiAuthController@addwishlistEpisode');
        Route::post('addfavoriteEpisode', 'ApiAuthController@addfavoriteEpisode');

        //  Multi-profile
        Route::post('Multiprofile', 'ApiAuthController@Multiprofile');
        Route::post('Multiprofile_create', 'ApiAuthController@Multiprofile_create');
        Route::get('Multiprofile_edit', 'ApiAuthController@Multiprofile_edit');
        Route::post('Multiprofile_update', 'ApiAuthController@Multiprofile_update');
        Route::post('Multiprofile_delete', 'ApiAuthController@Multiprofile_delete');

        Route::get('subusers', 'ApiAuthController@subusers');

        // freecontent Episodes
        Route::get('freecontent_episodes', 'ApiAuthController@freecontent_episodes');

        // Recommendation Videos
        Route::get('MostwatchedVideos', 'ApiAuthController@MostwatchedVideos');
        Route::post('MostwatchedVideosUser', 'ApiAuthController@MostwatchedVideosUser');
        Route::get('Country_MostwatchedVideos', 'ApiAuthController@Country_MostwatchedVideos');
        Route::get('Preference_genres', 'ApiAuthController@Preference_genres');
        Route::get('Preference_Language', 'ApiAuthController@Preference_Language');
        Route::get('category_Mostwatchedvideos', 'ApiAuthController@category_Mostwatchedvideos');

        Route::get('ComingSoon ', 'ApiAuthController@ComingSoon');
        Route::post('video_cast', 'ApiAuthController@video_cast');
        Route::post('series_cast', 'ApiAuthController@series_cast');
        Route::get('Welcome_Screen', 'ApiAuthController@Welcome_Screen');
        Route::post('payment_plan', 'ApiAuthController@PaymentPlan');
        Route::post('SeasonsPPV', 'ApiAuthController@SeasonsPPV');
        Route::post('PurchaseSeries', 'ApiAuthController@PurchaseSeries');

        // Razorpay
        Route::post('RazorpaySubscription', 'ApiAuthController@RazorpaySubscription');
        Route::post('RazorpayStore', 'ApiAuthController@RazorpayStore');
        Route::post('RazorpaySubscriptionCancel', 'ApiAuthController@RazorpaySubscriptionCancel');
        Route::post('RazorpaySubscriptionUpdate', 'ApiAuthController@RazorpaySubscriptionUpdate');

        // Paystack
        Route::post('Paystack-become-subscriber', 'ApiAuthController@Paystack_become_subscriber');
        Route::post('Paystack-liveRent-Paymentverify', 'ApiAuthController@Paystack_liveRent_Paymentverify')->name('Paystack_liveRent_Paymentverify');
        Route::post('Paystack-VideoRent-Paymentverify', 'ApiAuthController@Paystack_VideoRent_Paymentverify')->name('Paystack_VideoRent_Paymentverify');
        Route::post('Paystack-SeriesRent-Paymentverify', 'ApiAuthController@Paystack_SeriesRentRent_Paymentverify')->name('Paystack_VideoRent_Paymentverify');
        Route::post('Paystack-SerieSeasonRent-Paymentverify', 'ApiAuthController@Paystack_SerieSeasonRentRent_Paymentverify')->name('Paystack_VideoRent_Paymentverify');
        Route::post('Paystack-AudioRent-Paymentverify', 'ApiAuthController@Paystack_AudioRent_Paymentverify')->name('Paystack_VideoRent_Paymentverify');

        //Common Cancel Subscriptions
        Route::post('cancel-subscription', 'ApiAuthController@Cancel_Subscriptions');

        // Ads
        Route::post('AdsView', 'ApiAuthController@AdsView');
        Route::post('Adstatus_upate', 'ApiAuthController@Adstatus_upate');

        Route::get('profileimage_default', 'ApiAuthController@profileimage_default');

        // Home Setting Status
        Route::get('homesetting', 'ApiAuthController@homesetting');

        // audiocategory
        Route::get('audiocategory', 'ApiAuthController@AudioCategory');
        Route::post('ppv_videocount', 'ApiAuthController@PPVVideocount');
        Route::post('ppv_videorent', 'ApiAuthController@PPVVideorent');
        Route::post('album_audios', 'ApiAuthController@album_audios');
        Route::get('homepage_order', 'ApiAuthController@HomepageOrder');

        Route::post('audioscategory', 'ApiAuthController@audioscategory');
        Route::post('livecategory', 'ApiAuthController@livecategory');
        Route::get('LiveCategorylist', 'ApiAuthController@LiveCategorylist');

        // Andriod Slider
        Route::get('andriod_slider', 'ApiAuthController@andriod_slider');

        Route::get('/videos', 'Api\AdminVideosController@index');

        // Theme Primary Color
        Route::get('theme_primary_color', 'ApiAuthController@theme_primary_color');
        Route::post('PlayerAnalytics', 'ApiAuthController@PlayerAnalytics');
        Route::get('socialsetting', 'ApiAuthController@SocialSetting');
        Route::post('ContinueWatchingExits', 'ApiAuthController@ContinueWatchingExits');

        // Audio Shuffle
        Route::post('audio_shufffle', 'ApiAuthController@audio_shufffle');

        // Audio Like & dislike - IOS
        Route::post('Audiolike_ios', 'ApiAuthController@Audiolike_ios');
        Route::post('Audiodislike_ios', 'ApiAuthController@Audiodislike_ios');

        Route::post('live_like_ios', 'ApiAuthController@live_like_ios');
        Route::post('live_dislike_ios', 'ApiAuthController@live_dislike_ios');
        Route::post('live_addwatchalter', 'ApiAuthController@live_addwatchalter');

        // Audio Like & dislike - IOS
        Route::post('Videolike_ios', 'ApiAuthController@Videolike_ios');
        Route::post('Videodislike_ios', 'ApiAuthController@Videodislike_ios');

        // Audio Like & dislike - IOS
        Route::post('Episodelike_ios', 'ApiAuthController@Episodelike_ios');
        Route::post('Episodedislike_ios', 'ApiAuthController@Episodedislike_ios');

        Route::get('ReelsVideo', 'ApiAuthController@ReelsVideo');

        // Andriod Categories
        Route::get('home_categorylist', 'ApiAuthController@home_categorylist');

        Route::get('Currency_setting', 'ApiAuthController@Currency_setting');

        Route::get('mobile_side_menu', 'ApiAuthController@MobileSideMenu');

        Route::post('series_season_episodes', 'ApiAuthController@Series_SeasonsEpisodes');

        Route::post('relatedseries', 'ApiAuthController@relatedseries');

        Route::post('related_livestream', 'ApiAuthController@relatedlive');

        Route::get('cpanelstorage', 'ApiAuthController@cpanelstorage');

        Route::get('albumlist_ios', 'ApiAuthController@albumlist_ios');

        Route::post('account_delete', 'ApiAuthController@account_delete');

        Route::post('remaining_Episode', 'ApiAuthController@remaining_Episode');

        Route::post('related_series', 'ApiAuthController@related_series');

        // Route::get('home_page','ApiAuthController@HomePage');

        Route::post('video_language', 'ApiAuthController@LanguageVideo');

        Route::post('series_language', 'ApiAuthController@LanguageSeries');

        Route::post('live_language', 'ApiAuthController@LanguageLive');

        Route::post('audio_language', 'ApiAuthController@LanguageAudio');

        Route::post('TV_Language', 'ApiAuthController@TV_Language');

        Route::post('pages', 'ApiAuthController@Page');


        Route::post('tv_barcode_login', 'ApiAuthController@TVQRLogin');

        Route::post('tv_code_verification', 'ApiAuthController@TVCodeVerification');

        Route::post('tv_code_login', 'ApiAuthController@TVCodeLogin');

        Route::post('tv_uniquecode_login', 'ApiAuthController@TvUniqueCodeLogin');

        Route::post('tv_logout', 'ApiAuthController@TVLogout');

        Route::get('tv_unique_alphanumeric', 'ApiAuthController@TVAlphaNumeric');

        Route::post('verfiy_become_subscription', 'ApiAuthController@CheckBecomeSubscription');

        Route::get('videoschedules', 'ApiAuthController@VideoSchedules');

        Route::get('scheduledvideos', 'ApiAuthController@ScheduledVideos');

        Route::get('rescheduledvideos', 'ApiAuthController@ReScheduledVideos');

        Route::post('video_schedule', 'ApiAuthController@Video_Schedules');

        Route::post('scheduled_video', 'ApiAuthController@Scheduled_Videos');

        Route::post('rescheduled_video', 'ApiAuthController@ReScheduled_Videos');

        Route::get('site_theme_setting', 'ApiAuthController@site_theme_setting');
        Route::post('tv_logged_user', 'ApiAuthController@TVLoggedDetails');

            // QR code - TV
        Route::post('tv_qrcode_login', 'ApiAuthController@TvQRCodeLogin');
        Route::post('tv_qrcode_logout', 'ApiAuthController@TVQRCodeLogout');

            // QR code - Mobile
        Route::post('qrcode_mobile_login', 'ApiAuthController@QRCodeMobileLogin');
        Route::post('qrcode_mobile__logout', 'ApiAuthController@QRCodeMobileLogout');

            // Comment Section
            
        Route::post('/comment_message', 'ApiAuthController@comment_message');
        Route::post('/comment_store', 'ApiAuthController@comment_store');
        Route::post('/comment_edit', 'ApiAuthController@comment_edit');
        Route::post('/comment_update', 'ApiAuthController@comment_update');
        Route::post('/comment_destroy', 'ApiAuthController@comment_destroy');
        Route::post('/comment_reply', 'ApiAuthController@comment_reply');

        // Channel Partner
        Route::get('/home_channel_partner', 'ApiAuthController@HomeChannelPartner');
        Route::post('channel_partner', 'ApiAuthController@ChannelHome')->name('ChannelHome');
        Route::get('channel_partner_list', 'ApiAuthController@ChannelList')->name('ChannelList');
        Route::post('channel_partner_category_series', 'ApiAuthController@channel_category_series')->name('channel_category_series');
        Route::post('channel_partner_category_videos', 'ApiAuthController@channel_category_videos')->name('channel_category_videos');
        Route::post('channel_partner_category_audios', 'ApiAuthController@channel_category_audios')->name('channel_category_audios');
        Route::post('channel_partner_category_live', 'ApiAuthController@channel_category_live')->name('channel_category_live');
        
        // Content Partner
        Route::get('/home_content_partner', 'ApiAuthController@HomeContentPartner');
        Route::post('contentpartner', 'ApiAuthController@ContentPartnerHome')->name('ContentPartnerHome');
        Route::get('Content_list', 'ApiAuthController@ContentList')->name('ContentList');
        Route::get('content_partners', 'ApiAuthController@ContentList')->name('ContentList');
        Route::post('Content_category_series', 'ApiAuthController@Content_category_series')->name('Content_category_series');
        Route::post('Content_category_videos', 'ApiAuthController@Content_category_videos')->name('Content_category_videos');
        Route::post('Content_category_audios', 'ApiAuthController@Content_category_audios')->name('Content_category_audios');
        Route::post('Content_category_live', 'ApiAuthController@Content_category_live')->name('Content_category_live');

        // learn - Only for Nemisha
        Route::get('learn', 'ApiAuthController@learn');

        // library - All videos
        Route::get('library', 'ApiAuthController@all_videos');
        Route::post('library-IOS', 'ApiAuthController@all_videos_IOS');
        Route::get('library-TV', 'ApiAuthController@all_videos_tv');
        
        Route::get('menus', 'ApiAuthController@Menus');

        // Data Free - Only for Nemisha

        Route::get('data_free', 'ApiAuthController@DataFree');
        Route::post('category_live', 'ApiAuthController@categorylive');

        Route::get('category_videos', 'ApiAuthController@Category_Videos');
        Route::post('relatedtvvideos', 'ApiAuthController@relatedtvvideos');
        Route::post('LoggedUserDeviceDelete', 'ApiAuthController@LoggedUserDeviceDelete');

        Route::post('android_continue_watchings', 'ApiAuthController@android_continue_watchings');
        Route::post('android_list_continue_watchings', 'ApiAuthController@android_ContinueWatching');

        Route::post('Ios_continue_watchings', 'ApiAuthController@Ios_continue_watchings');
        Route::post('Ios_list_continue_watchings', 'ApiAuthController@Ios_ContinueWatching');


            Route::post('Android_addwishlist', 'ApiAuthController@Android_addwishlist');
            Route::post('Android_Video_wishlist', 'ApiAuthController@Android_Video_wishlist');
            Route::post('Android_Episode_wishlist', 'ApiAuthController@Android_Episode_wishlist');
            Route::post('Android_Audio_wishlist', 'ApiAuthController@Android_Audio_wishlist');
            Route::post('Android_LiveStream_wishlist', 'ApiAuthController@Android_LiveStream_wishlist');


            Route::post('IOS_addwishlist', 'ApiAuthController@IOS_addwishlist');
            Route::post('IOS_Video_wishlist', 'ApiAuthController@IOS_Video_wishlist');
            Route::post('IOS_Episode_wishlist', 'ApiAuthController@IOS_Episode_wishlist');
            Route::post('IOS_Audio_wishlist', 'ApiAuthController@IOS_Audio_wishlist');
            Route::post('IOS_LiveStream_wishlist', 'ApiAuthController@IOS_LiveStream_wishlist');



            Route::post('addfavorite', 'ApiAuthController@addfavorite');
            Route::post('addwatchlater', 'ApiAuthController@addwatchlater');

            // Audio Like & dislike - Android
            Route::post('/Android_Videolike', 'ApiAuthController@Android_LikeVideo');
            Route::post('/Android_Videodislike', 'ApiAuthController@Android_DisLikeVideo');

            // Audio Like & dislike - Android
            Route::post('Android_Audiolike', 'ApiAuthController@Android_Audiolike');
            Route::post('Android_Audiodislike', 'ApiAuthController@Android_Audiodislike');

            Route::post('Android_live_like', 'ApiAuthController@Android_live_like');
            Route::post('Android_live_dislike', 'ApiAuthController@Android_live_dislike');

            Route::post('Android_liked_disliked', 'ApiAuthController@Android_liked_disliked');

            // Audio Like & dislike - Android
            Route::post('Android_Episodelike', 'ApiAuthController@Android_Episodelike');
            Route::post('Android_Episodedislike', 'ApiAuthController@Android_Episodedislike');


            // Audio Like & dislike - IOS
            Route::post('/IOS_Videolike', 'ApiAuthController@IOS_LikeVideo');
            Route::post('/IOS_Videodislike', 'ApiAuthController@IOS_DisLikeVideo');
            Route::post('/IOS_Video_Like', 'ApiAuthController@IOS_Video_Like');

            // Audio Like & dislike - IOS
            Route::post('IOS_Audiolike', 'ApiAuthController@IOS_Audiolike');
            Route::post('IOS_Audiodislike', 'ApiAuthController@IOS_Audiodislike');

            Route::post('IOS_live_like', 'ApiAuthController@IOS_live_like');
            Route::post('IOS_live_dislike', 'ApiAuthController@IOS_live_dislike');

            // Audio Like & dislike - IOS
            Route::post('IOS_Episodelike', 'ApiAuthController@IOS_Episodelike');
            Route::post('IOS_Episodedislike', 'ApiAuthController@IOS_Episodedislike');
                
            Route::post('IOS_liked_disliked', 'ApiAuthController@IOS_liked_disliked');


            Route::get('series_genre_list', 'ApiAuthController@series_genre_list');
            Route::post('series_genre', 'ApiAuthController@series_genre');
            Route::post('Android_ContinueWatchingExits', 'ApiAuthController@Android_ContinueWatchingExits');
            Route::post('IOS_ContinueWatchingExits', 'ApiAuthController@IOS_ContinueWatchingExits');


            Route::post('Android_Video_favorite', 'ApiAuthController@Android_Video_favorite');
            Route::post('Android_Episode_favorite', 'ApiAuthController@Android_Episode_favorite');
            Route::post('Android_Audio_favorite', 'ApiAuthController@Android_Audio_favorite');
            Route::post('Android_LiveStream_favorite', 'ApiAuthController@Android_LiveStream_favorite');


            Route::post('IOS_Video_favorite', 'ApiAuthController@IOS_Video_favorite');
            Route::post('IOS_Episode_favorite', 'ApiAuthController@IOS_Episode_favorite');
            Route::post('IOS_Audio_favorite', 'ApiAuthController@IOS_Audio_favorite');
            Route::post('IOS_LiveStream_favorite', 'ApiAuthController@IOS_LiveStream_favorite');


            Route::post('Android_Video_watchlater', 'ApiAuthController@Android_Video_watchlater');
            Route::post('Android_Episode_watchlater', 'ApiAuthController@Android_Episode_watchlater');
            Route::post('Android_Audio_watchlater', 'ApiAuthController@Android_Audio_watchlater');
            Route::post('Android_LiveStream_watchlater', 'ApiAuthController@Android_LiveStream_watchlater');


            Route::post('IOS_Video_watchlater', 'ApiAuthController@IOS_Video_watchlater');
            Route::post('IOS_Episode_watchlater', 'ApiAuthController@IOS_Episode_watchlater');
            Route::post('IOS_Audio_watchlater', 'ApiAuthController@IOS_Audio_watchlater');
            Route::post('IOS_LiveStream_watchlater', 'ApiAuthController@IOS_LiveStream_watchlater');

            Route::post('TV_Season_Episode_Count', 'ApiAuthController@TV_Season_Episode_Count');
            Route::post('TV_Season_Episdoe_List', 'ApiAuthController@TV_Season_Episdoe_List');

            Route::post('IOS_ShowVideo_favorite', 'ApiAuthController@IOS_ShowVideo_favorite');
            Route::post('IOS_ShowEpisode_favorite', 'ApiAuthController@IOS_ShowEpisode_favorite');
            Route::post('IOS_ShowAudio_favorite', 'ApiAuthController@IOS_ShowAudio_favorite');
            Route::post('IOS_ShowLiveStream_favorite', 'ApiAuthController@IOS_ShowLiveStream_favorite');

            Route::post('Android_ShowVideo_favorite', 'ApiAuthController@Android_ShowVideo_favorite');
            Route::post('Android_ShowEpisode_favorite', 'ApiAuthController@Android_ShowEpisode_favorite');
            Route::post('Android_ShowAudio_favorite', 'ApiAuthController@Android_ShowAudio_favorite');
            Route::post('Android_ShowLiveStream_favorite', 'ApiAuthController@Android_ShowLiveStream_favorite');


            Route::post('IOS_ShowVideo_wishlist', 'ApiAuthController@IOS_ShowVideo_wishlist');
            Route::post('IOS_ShowEpisode_wishlist', 'ApiAuthController@IOS_ShowEpisode_wishlist');
            Route::post('IOS_ShowAudio_wishlist', 'ApiAuthController@IOS_ShowAudio_wishlist');
            Route::post('IOS_ShowLiveStream_wishlist', 'ApiAuthController@IOS_ShowLiveStream_wishlist');

            Route::post('Android_ShowVideo_wishlist', 'ApiAuthController@Android_ShowVideo_wishlist');
            Route::post('Android_ShowEpisode_wishlist', 'ApiAuthController@Android_ShowEpisode_wishlist');
            Route::post('Android_ShowAudio_wishlist', 'ApiAuthController@Android_ShowAudio_wishlist');
            Route::post('Android_ShowLiveStream_wishlist', 'ApiAuthController@Android_ShowLiveStream_wishlist');
            
            
            Route::get('social_network_setting', 'ApiAuthController@social_network_setting');
            Route::get('contact_email_setting', 'ApiAuthController@contact_email_setting');

            Route::get('tv_livestreams', 'ApiAuthController@tv_livestreams');
            Route::post('enable_dark_light_mode', 'ApiAuthController@enable_dark_light_mode');


            // Create Audio Playlist 


            Route::post('add_myaudio_playlist', 'ApiAuthController@AudioMYPlaylist');
            Route::post('add_audio_playlist', 'ApiAuthController@AddAudioPlaylist');
            Route::post('my_audio_playlist', 'ApiAuthController@MyAudioPlaylist');
            Route::post('audio_playlist', 'ApiAuthController@PlaylistAudio');
            Route::post('remove_audio_playlist', 'ApiAuthController@RemoveAudioPlaylist');
            Route::post('remove_playlist', 'ApiAuthController@Remove_Playlist');

            // Create Audio Playlist 


            Route::post('video_playlist', 'ApiAuthController@VideoPlaylist');

            Route::post('/IOS_social_user', 'ApiAuthController@IOSSocialUser');
            Route::post('login_tv ', 'ApiAuthController@TV_login');

            Route::post('login_tv ', 'ApiAuthController@TV_login');

            Route::get('Master-List-videos', 'ApiAuthController@Master_list_videos');
            Route::get('register-dropdown-data', 'ApiAuthController@RegisterDropdownData');
            Route::post('Related_Audios_LikeDisLike ', 'ApiAuthController@Related_Audios_LikeDisLike');
            Route::get('featured_videos ', 'ApiAuthController@FeaturedVideos');

            Route::get('music_station ', 'ApiAuthController@MusicStation');
            Route::post('my_music_station ', 'ApiAuthController@MyMusicSation');
            Route::post('store_music_station ', 'ApiAuthController@StoreMusicSation');
            Route::post('play_music_station ', 'ApiAuthController@PlayerMusicStation');
            Route::post('delete_music_station ', 'ApiAuthController@DeleteStation');

            Route::get('tv_settings', 'ApiAuthController@TVSetting');

            Route::post('tv_continue_watchings', 'ApiAuthController@TV_continue_watchings');
            Route::post('tv_list_continue_watchings', 'ApiAuthController@TV_ContinueWatching');
    
            Route::post('TV_Addwishlist', 'ApiAuthController@TV_Addwishlist');
            Route::post('TV_ShowVideo_wishlist', 'ApiAuthController@TV_ShowVideo_wishlist');
            Route::post('TV_ShowEpisode_wishlist', 'ApiAuthController@TV_ShowEpisode_wishlist');
            Route::post('TV_ShowAudio_wishlist', 'ApiAuthController@TV_ShowAudio_wishlist');
            Route::post('TV_ShowLiveStream_wishlist', 'ApiAuthController@TV_ShowLiveStream_wishlist');
            
            Route::get('TV_retrieve_search_data', 'ApiAuthController@tv_retrieve_search_data');
            Route::post('TV_search_data_update', 'ApiAuthController@tv_search_data_update');
            Route::post('auto-store-station', 'ApiAuthController@AutoStoreStation');
            Route::post('multi-currency-converter', 'ApiAuthController@Currency_Convert');


            Route::post('scanner_code', 'ApiAuthController@QRScannerCode');
            Route::post('mobile_pair_code', 'ApiAuthController@QRMobilePair');
            Route::post('tv_signup', 'ApiAuthController@TvSignUp');
            Route::post('tv_code_verifyToken', 'ApiAuthController@verifytokenCode');
            Route::post('CinetPaySubscription', 'ApiAuthController@CinetPaySubscription');
            Route::post('PayPalSubscription', 'ApiAuthController@PayPalSubscription');

            Route::get('channels', 'ApiAuthController@Channels');
            Route::post('channel-scheduled-videos', 'ApiAuthController@ChannelScheduledVideos');
            Route::post('scheduled-programs', 'ApiAuthController@ChannelScheduledDataVideos');
            Route::post('store-user-translation', 'ApiAuthController@ChooseTranslation');
            Route::post('user-translation', 'ApiAuthController@UserTranslation');
            Route::get('translation-language', 'ApiAuthController@LanguageTranslation');
            Route::get('translation-checkout', 'ApiAuthController@TranslationEnable'); 

            // Sending OTP
            Route::addRoute(['GET', 'POST'], 'Mobile-exists-verify', 'ApiAuthController@Mobile_exists_verify');
 
            Route::post('Sending-OTP', 'ApiAuthController@Sending_OTP'); 
            Route::addRoute(['GET', 'POST'], 'Verify-OTP', 'ApiAuthController@Verify_OTP');

            Route::post('send-video-push-notifications', 'ApiAuthController@SendVideoPushNotification'); 

            Route::post('time-zone', 'ApiAuthController@TimeZone'); 
            Route::post('channel-epg', 'ApiAuthController@channel_epg'); 
            Route::post('unique-channel-epg', 'ApiAuthController@unique_channel_epg'); 

            Route::get('storage-setting', 'ApiAuthController@StorageSetting'); 
            Route::get('GeoIPLocation', 'ApiAuthController@GeoIPLocation'); 

            Route::get('Ads-variables', 'ApiAuthController@Ads_variables'); 

            Route::get('tv-splash-screen', 'ApiAuthController@tv_splash_screen'); 

            Route::post('radiostationdetail', 'ApiAuthController@radiostationdetail');
            Route::get('ugcvideolist', 'ApiAuthContinueController@ugcvideolist');
            Route::post('uploadugcvideo', 'ApiAuthContinueController@uploadugcvideo');
            Route::post('editugcvideo', 'ApiAuthContinueController@editugcvideo');
            Route::post('deleteugcvideo', 'ApiAuthContinueController@deleteugcvideo');
            Route::post('revenueshare', 'ApiAuthContinueController@revenueshare');
            Route::post('episoderevenueshare', 'ApiAuthContinueController@episoderevenueshare');
            Route::post('livestreamrevenueshare', 'ApiAuthContinueController@livestreamrevenueshare');
            Route::post('ugcsubscribe', 'ApiAuthContinueController@ugcsubscribe');
            Route::post('ugcunsubscribe', 'ApiAuthContinueController@ugcunsubscribe');
            Route::post('ugcvideodetail', 'ApiAuthContinueController@ugcvideodetail');
            Route::post('ugcwishlist', 'ApiAuthContinueController@ugcwishlist');
            Route::post('ugcwatchlater', 'ApiAuthContinueController@ugcwatchlater');
            Route::post('showUgcProfileApi', 'ApiAuthContinueController@showUgcProfileApi');
            Route::post('relatedradiostations', 'ApiAuthContinueController@relatedradiostations');
            Route::post('ugclike', 'ApiAuthContinueController@ugclike');
            Route::post('ugcdislike', 'ApiAuthContinueController@ugcdislike');
            Route::post('add_favorite_ugcvideo', 'ApiAuthContinueController@add_favorite_ugcvideo');
        });