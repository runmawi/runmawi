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
        
        
'test',
'video_store',
'menu_store',
'county',
'slider_store',
'all_video_store',
'payment_setting',
'systemsettings',
'homesettings',
'mobileappupdate',
'slider',
'theme_settings',
'site_setting',
'pages',
'livestream',
'livestream_categories',
'user_store',
'user_role',
'languagestrans',
'video_languages',
'playerui_setting',
'plans',
'paypalplans',
'coupons',
'artists',
'audios_categories',
'audios_album',
'audios',
'edit_video',
'update_video',
'destroy_video',
'edit_video_category',
'update_video_store',
'destroy_video_category',
'series_store',
'edit_series',
'update_series',
'destory_series',
'update_audio',
'destory_audio',
'edit_audio_categories',
'destroy_audio_categories',
'edit_artist_categories',
'update_artist_categories',
'destroy_artist_categories',

'editAlbum',
'destroyAlbum',
'destroy_artist_categories',

'MobileSliderEdit',
'MobileSliderUpdate',
'MobileSliderDelete',


'page_edit',
'page_update',
'page_destory',



'plans_edit',
'plans_update',
'plans_destory',
  

'PaypalEdit',
'PaypalUpdate',
'PaypalDelete',


'editcoupons',
'updatecoupons',
'deletecoupons',


'deletecountry',
'SliderEdit',
'SliderUpdate',
'SliderDelete',
'menu_edit',
'menu_update',
'menu_destroy',
'LanguageEdit',
'LanguageUpdate',
'LanguageDelete',
'LanguageTransEdit',
'LanguageTransUpdate',
'LanguageTransDelete',

'user_edit',
'user_update',
'user_delete',

'userroles_edit',
'userroles_update',
'userroles_destroy',

'livestream_edit',
'livestream_update',

'livestreamcategory_edit',
'livestreamcategory_update',
'livestreamcategory_destroy',

'deletecountry',


'Fileupload',
'updatefile',
'mp4url_data',
'm3u8url_data',
'Embed_Data',
'Audioupload',
'fileAudio',
'edit_audio',
'Dashboard_Revenue',
'deletecountry',

    ];
}
