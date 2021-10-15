<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        
        
'http://dev-flick.webnexs.org/test',
'http://dev-flick.webnexs.org/video_store',
'http://dev-flick.webnexs.org/menu_store',
'http://dev-flick.webnexs.org/county',
'http://dev-flick.webnexs.org/slider_store',
'http://dev-flick.webnexs.org/all_video_store',
'http://dev-flick.webnexs.org/payment_setting',
'http://dev-flick.webnexs.org/systemsettings',
'http://dev-flick.webnexs.org/homesettings',
'http://dev-flick.webnexs.org/mobileappupdate',
'http://dev-flick.webnexs.org/slider',
'http://dev-flick.webnexs.org/theme_settings',
'http://dev-flick.webnexs.org/site_setting',
'http://dev-flick.webnexs.org/pages',
'http://dev-flick.webnexs.org/livestream',
'http://dev-flick.webnexs.org/livestream_categories',
'http://dev-flick.webnexs.org/user_store',
'http://dev-flick.webnexs.org/user_role',
'http://dev-flick.webnexs.org/languagestrans',
'http://dev-flick.webnexs.org/video_languages',
'http://dev-flick.webnexs.org/playerui_setting',
'http://dev-flick.webnexs.org/plans',
'http://dev-flick.webnexs.org/paypalplans',
'http://dev-flick.webnexs.org/coupons',
'http://dev-flick.webnexs.org/artists',
'http://dev-flick.webnexs.org/audios_categories',
'http://dev-flick.webnexs.org/audios_album',
'http://dev-flick.webnexs.org/audios',
'http://dev-flick.webnexs.org/edit_video',
'http://dev-flick.webnexs.org/update_video',
'http://dev-flick.webnexs.org/destroy_video',
'http://dev-flick.webnexs.org/edit_video_category',
'http://dev-flick.webnexs.org/update_video_store',
'http://dev-flick.webnexs.org/destroy_video_category',
'http://dev-flick.webnexs.org/series_store',
'http://dev-flick.webnexs.org/edit_series',
'http://dev-flick.webnexs.org/update_series',
'http://dev-flick.webnexs.org/destory_series',
'http://dev-flick.webnexs.org/update_audio',
'http://dev-flick.webnexs.org/destory_audio',
'http://dev-flick.webnexs.org/edit_audio_categories',
'http://dev-flick.webnexs.org/destroy_audio_categories',
'http://dev-flick.webnexs.org/edit_artist_categories',
'http://dev-flick.webnexs.org/update_artist_categories',
'http://dev-flick.webnexs.org/destroy_artist_categories',

'http://dev-flick.webnexs.org/editAlbum',
'http://dev-flick.webnexs.org/destroyAlbum',
'http://dev-flick.webnexs.org/destroy_artist_categories',

'http://dev-flick.webnexs.org/MobileSliderEdit',
'http://dev-flick.webnexs.org/MobileSliderUpdate',
'http://dev-flick.webnexs.org/MobileSliderDelete',


'http://dev-flick.webnexs.org/page_edit',
'http://dev-flick.webnexs.org/page_update',
'http://dev-flick.webnexs.org/page_destory',



'http://dev-flick.webnexs.org/plans_edit',
'http://dev-flick.webnexs.org/plans_update',
'http://dev-flick.webnexs.org/plans_destory',
  

'http://dev-flick.webnexs.org/PaypalEdit',
'http://dev-flick.webnexs.org/PaypalUpdate',
'http://dev-flick.webnexs.org/PaypalDelete',


'http://dev-flick.webnexs.org/editcoupons',
'http://dev-flick.webnexs.org/updatecoupons',
'http://dev-flick.webnexs.org/deletecoupons',


'http://dev-flick.webnexs.org/deletecountry',
'http://dev-flick.webnexs.org/SliderEdit',
'http://dev-flick.webnexs.org/SliderUpdate',
'http://dev-flick.webnexs.org/SliderDelete',
'http://dev-flick.webnexs.org/menu_edit',
'http://dev-flick.webnexs.org/menu_update',
'http://dev-flick.webnexs.org/menu_destroy',
'http://dev-flick.webnexs.org/LanguageEdit',
'http://dev-flick.webnexs.org/LanguageUpdate',
'http://dev-flick.webnexs.org/LanguageDelete',
'http://dev-flick.webnexs.org/LanguageTransEdit',
'http://dev-flick.webnexs.org/LanguageTransUpdate',
'http://dev-flick.webnexs.org/LanguageTransDelete',

'http://dev-flick.webnexs.org/user_edit',
'http://dev-flick.webnexs.org/user_update',
'http://dev-flick.webnexs.org/user_delete',

'http://dev-flick.webnexs.org/userroles_edit',
'http://dev-flick.webnexs.org/userroles_update',
'http://dev-flick.webnexs.org/userroles_destroy',

'http://dev-flick.webnexs.org/livestream_edit',
'http://dev-flick.webnexs.org/livestream_update',

'http://dev-flick.webnexs.org/livestreamcategory_edit',
'http://dev-flick.webnexs.org/livestreamcategory_update',
'http://dev-flick.webnexs.org/livestreamcategory_destroy',

'http://dev-flick.webnexs.org/deletecountry',


'http://dev-flick.webnexs.org/Fileupload',
'http://dev-flick.webnexs.org/updatefile',
'http://dev-flick.webnexs.org/mp4url_data',
'http://dev-flick.webnexs.org/m3u8url_data',
'http://dev-flick.webnexs.org/Embed_Data',
'http://dev-flick.webnexs.org/Audioupload',
'http://dev-flick.webnexs.org/fileAudio',
'http://dev-flick.webnexs.org/edit_audio',
'http://dev-flick.webnexs.org/Dashboard_Revenue',
'http://dev-flick.webnexs.org/deletecountry',

    ];
}
