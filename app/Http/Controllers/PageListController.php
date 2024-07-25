<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\HomeSetting ;
use App\CurrencySetting;
use App\Setting ;
use App\Video;
use Theme;
use App\OrderHomeSetting;
use App\VideoCategory;

class PageListController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::first();
        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();

        $this->current_theme = $this->HomeSetting->theme_choosen ;
        Theme::uses($this->current_theme);
    }

    function paginateCollection(Collection $items, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, $items->count(), $perPage);
        $paginatedItems->setPath(request()->url());

        return $paginatedItems;
    }

    public function Latest_videos()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latest_videos_pagelist = $FrontEndQueryController->Latest_videos();
            $latest_videos_paginate = $this->paginateCollection($latest_videos_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_videos_pagelist' => $latest_videos_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.latest-videos', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Featured_videos()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $featured_videos_pagelist = $FrontEndQueryController->featured_videos();
            $featured_videos_paginate = $this->paginateCollection($featured_videos_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'featured_videos_pagelist' => $featured_videos_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.Featured-videos', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Video_categories()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $category_videos_pagelist = $FrontEndQueryController->genre_video_display();
            $category_videos_paginate = $this->paginateCollection($category_videos_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'category_videos_pagelist' => $category_videos_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.video-category', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Live_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $live_list_pagelist = $FrontEndQueryController->livestreams();
            $live_list_paginate = $this->paginateCollection($live_list_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'live_list_pagelist' => $live_list_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.live-stream', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Albums_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $albums_list_pagelist = $FrontEndQueryController->AudioAlbums();
            $albums_list_paginate = $this->paginateCollection($albums_list_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'albums_list_pagelist' => $albums_list_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.albums-list', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }
    public function Live_Category_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $live_category_pagelist = $FrontEndQueryController->LiveCategory();
            $live_category_paginate = $this->paginateCollection($live_category_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'live_category_pagelist' => $live_category_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.live-category', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function Audio_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $audio_list_pagelist = $FrontEndQueryController->latest_audios();
            $audio_list_paginate = $this->paginateCollection($audio_list_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'audio_list_pagelist' => $audio_list_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                    'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.audio-list', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function Series_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latest_series_pagelist = $FrontEndQueryController->latest_Series();
            $latest_series_paginate = $this->paginateCollection($latest_series_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_series_pagelist' => $latest_series_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.latest-series', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function ChannelPartner_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $channel_partner_pagelist = $FrontEndQueryController->Channel_Partner();
            $channel_partner_paginate = $this->paginateCollection($channel_partner_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'channel_partner_pagelist' => $channel_partner_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.channel-partner', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function LatestViewedAudio_list()
    {
        try {
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();

            $latestViewed_audio_paginate = $this->paginateCollection($latestViewed_audio_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'order_settings_list' => $order_settings_list,
                'latestViewed_audio_pagelist' => $latestViewed_audio_paginate,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );

            return Theme::view('Page-List.latest-viewed-audios', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function SeriesGenre_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $series_genre_pagelist = $FrontEndQueryController->SeriesGenre();
            $series_genre_paginate = $this->paginateCollection($series_genre_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'series_genre_pagelist' => $series_genre_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.series-genre', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function Watchlater_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $watchlater_pagelist = $FrontEndQueryController->watchLater();
            $watchlater_paginate = $this->paginateCollection($watchlater_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'watchlater_pagelist' => $watchlater_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.watchlater', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function Wishlist_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $wishlist_pagelist = $FrontEndQueryController->wishlist();
            $wishlist_paginate = $this->paginateCollection($wishlist_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'wishlist_pagelist' => $wishlist_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.wishlist', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function epg_list()
    {
        
    }

    public function deconstruct()
    {
        $this->settings = Setting::first();
        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();

        $this->current_theme = $this->HomeSetting->theme_choosen ;
        Theme::uses($this->current_theme);
    }

}
