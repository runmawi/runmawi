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
        
        
'https://flicknexui.webnexs.org/test',
'https://flicknexui.webnexs.org/video_store',
'https://flicknexui.webnexs.org/menu_store',
'https://flicknexui.webnexs.org/county',
'https://flicknexui.webnexs.org/slider_store',
'https://flicknexui.webnexs.org/all_video_store',
'https://flicknexui.webnexs.org/payment_setting',
'https://flicknexui.webnexs.org/systemsettings',
'https://flicknexui.webnexs.org/homesettings',
'https://flicknexui.webnexs.org/mobileappupdate',
'https://flicknexui.webnexs.org/slider',
'https://flicknexui.webnexs.org/theme_settings',
'https://flicknexui.webnexs.org/site_setting',
'https://flicknexui.webnexs.org/pages',
'https://flicknexui.webnexs.org/livestream',
'https://flicknexui.webnexs.org/livestream_categories',
'https://flicknexui.webnexs.org/user_store',
'https://flicknexui.webnexs.org/user_role',
'https://flicknexui.webnexs.org/languagestrans',
'https://flicknexui.webnexs.org/video_languages',
'https://flicknexui.webnexs.org/playerui_setting',
'https://flicknexui.webnexs.org/plans',
'https://flicknexui.webnexs.org/paypalplans',
'https://flicknexui.webnexs.org/coupons',
'https://flicknexui.webnexs.org/artists',
'https://flicknexui.webnexs.org/audios_categories',
'https://flicknexui.webnexs.org/audios_album',
'https://flicknexui.webnexs.org/audios',

  
    ];
}
