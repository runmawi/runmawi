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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'ApiAuthController@login');
     Route::post('search','ApiAuthController@search');
    Route::post('signup', 'ApiAuthController@signup');
    Route::post('directVerify', 'ApiAuthController@directVerify');
    Route::post('resetpassword', 'ApiAuthController@resetpassword');
    Route::post('updatepassword', 'ApiAuthController@updatepassword');
    Route::post('changepassword', 'ApiAuthController@changepassword');
    Route::post('verifyandupdatepassword', 'ApiAuthController@verifyandupdatepassword');
    Route::get('latestvideos', 'ApiAuthController@latestvideos');
    Route::get('categorylist', 'ApiAuthController@categorylist');
    Route::post('channelvideos', 'ApiAuthController@channelvideos');
    Route::get('categoryvideos', 'ApiAuthController@categoryvideos');
    Route::post('videodetail', 'ApiAuthController@videodetail');
    Route::get('livestreams', 'ApiAuthController@livestreams');
    Route::post('livestreamdetail', 'ApiAuthController@livestreamdetail');
    Route::get('cmspages', 'ApiAuthController@cmspages');
    Route::get('sliders', 'ApiAuthController@sliders');
    Route::post('coupons', 'ApiAuthController@coupons');
    Route::get('mobile_sliders', 'ApiAuthController@MobileSliders');
    Route::get('ppvvideos', 'ApiAuthController@ppvvideos');
    Route::post('ppvvideodetail', 'ApiAuthController@ppvvideodetail');
    Route::post('updateProfile', 'ApiAuthController@updateProfile');
    Route::post('addwishlist', 'ApiAuthController@addwishlist');
    Route::post('addfavorite', 'ApiAuthController@addfavorite');
    Route::post('addwatchlater', 'ApiAuthController@addwatchlater');
    Route::post('myWishlists', 'ApiAuthController@myWishlists');
    Route::post('myFavorites', 'ApiAuthController@myFavorites');
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
    Route::post('becomesubscriber', 'ApiAuthController@becomesubscriber');
    Route::post('subscriptiondetail', 'ApiAuthController@subscriptiondetail');
    Route::post('subscriptiondetail', 'ApiAuthController@subscriptiondetail');
    Route::post('add_payperview', 'ApiAuthController@add_payperview');
    Route::post('addppvpaypal', 'ApiAuthController@AddPpvPaypal');
    Route::get('splash', 'ApiAuthController@splash');
    Route::get('payment_settings','ApiAuthController@payment_settings');
    Route::post('ViewProfile', 'ApiAuthController@ViewProfile');
    Route::get('getCountries','ApiAuthController@getCountries');
    Route::post('getStates','ApiAuthController@getStates');
    Route::post('getCities','ApiAuthController@getCities');
    Route::get('stripe_onetime','ApiAuthController@StripeOnlyTimePlan');
    Route::get('stripe_recurring','ApiAuthController@StripeRecurringPlan');
    Route::get('paypal_onetime','ApiAuthController@PaypalOnlyTimePlan');
    Route::get('paypal_recurring','ApiAuthController@PaypalRecurringPlan');
    Route::post('relatedchannelvideos','ApiAuthController@relatedchannelvideos');
    Route::post('relatedppvvideos','ApiAuthController@relatedppvvideos');
    Route::post('searchapi','ApiAuthController@searchapi');
    Route::get('isPaymentEnable','ApiAuthController@isPaymentEnable');
    Route::post('checkEmailExists','ApiAuthController@checkEmailExists');
    Route::post('SendOtp','ApiAuthController@SendOtp');
    Route::post('VerifyOtp','ApiAuthController@VerifyOtp');
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
    Route::post('relatedepisodes', 'ApiAuthController@relatedepisodes');
    Route::post('seasonepisodes', 'ApiAuthController@seasonepisodes');
    Route::post('user_notifications', 'ApiAuthController@seasonepisodes');
    Route::post('user_comments', 'ApiAuthController@UserComments');
    Route::post('add_comment', 'ApiAuthController@AddComment');
    Route::get('series_title_status', 'ApiAuthController@SeriesTitle');
    Route::get('cast_lists', 'ApiAuthController@CastList');
    Route::post('mobile_signup', 'ApiAuthController@MobileSignup');
    Route::post('mobile_login', 'ApiAuthController@MobileLogin');

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
    Route::get('trendingaudio', 'ApiAuthController@trendingaudio');
    Route::get('albumlist', 'ApiAuthController@albumlist');
    Route::post('albumaudios', 'ApiAuthController@albumaudios');
    Route::post('addwatchlateraudio', 'ApiAuthController@addwatchlateraudio');
    Route::post('addfavoriteaudio', 'ApiAuthController@addfavoriteaudio');
    Route::post('/dislikeaudio', 'ApiAuthController@DisLikeAudio');
    Route::post('/likeaudio', 'ApiAuthController@LikeAudio');
    Route::get('AllAudios', 'ApiAuthController@AllAudios');
    Route::post('mywatchlatersaudio', 'ApiAuthController@mywatchlatersaudio');
    Route::post('myFavoriteaudio', 'ApiAuthController@myFavoriteaudio');
        Route::get('Alllanguage','ApiAuthController@Alllanguage');
    Route::post('VideoLanguage','ApiAuthController@VideoLanguage');
    Route::get('FeaturedVideo ','ApiAuthController@FeaturedVideo');
    Route::post('RecentViews ','ApiAuthController@RecentViews');
    Route::get('RecentlyViewed ','ApiAuthController@RecentlyViewed');
    Route::post('AddRecentAudio ','ApiAuthController@AddRecentAudio');
});