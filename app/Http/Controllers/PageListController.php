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
use App\Channel;
use App\ButtonText;
use App\StorageSetting;
use Illuminate\Support\Facades\URL; 

class PageListController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::first();
        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();

        $this->current_theme = $this->HomeSetting->theme_choosen ;
        Theme::uses($this->current_theme);

        $this->BunnyCDNEnable = StorageSetting::pluck('bunny_cdn_storage')->first();

        $this->BaseURL = $this->BunnyCDNEnable == 1 ? StorageSetting::pluck('bunny_cdn_base_url')->first() : URL::to('public/uploads') ;

    }

    function paginateCollection(Collection $items, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, $items->count(), $perPage);
        $paginatedItems->setPath(request()->url());

        return $paginatedItems;
    }

    public function Latest_videos($slug = null)
    {
        try {

            $channel_partner_id = Channel::where('channel_slug',$slug)->pluck('id')->first(); 
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();

            $latest_videos_pagelist = ($slug == null) ? $FrontEndQueryController->Latest_videos() : $FrontEndQueryController->latest_videos()->filter(function ($latest_videos) use ($channel_partner_id) {
                if ( $latest_videos->user_id == $channel_partner_id && $latest_videos->uploaded_by == "Channel" ) {
                    return $latest_videos;
                }
            });;
            $latest_videos_paginate = $this->paginateCollection($latest_videos_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_videos_pagelist' => $latest_videos_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
                'page_list' => $latest_videos_paginate,
                'base_url' => 'category/videos',
                'header_name' => $order_settings_list[1]->header_name,
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.videos-list', $data);
            } else {
            return Theme::view('Page-List.latest-videos', $data);
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function AllMovies($slug = null)
    {
        try {

            $channel_partner_id = Channel::where('channel_slug',$slug)->pluck('id')->first(); 
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $All_movies_list = ($slug == null) ? $FrontEndQueryController->AllMovies() : $FrontEndQueryController->AllMovies()->filter(function ($all_movies) use ($channel_partner_id) {
                if ( $all_movies->user_id == $channel_partner_id && $all_movies->uploaded_by == "Channel" ) {
                    return $all_movies;
                }
            });;
            $All_movies_paginate = $this->paginateCollection($All_movies_list, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'All_movies_list' => $All_movies_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.all-movies', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function Featured_videos($slug = null)
    {
        try {

            $channel_partner_id = Channel::where('channel_slug',$slug)->pluck('id')->first(); 
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            

            $featured_videos_pagelist = ($slug == null) ? $FrontEndQueryController->featured_videos() : $FrontEndQueryController->featured_videos()->filter(function ($featured_videos) use ($channel_partner_id) {
                if ( $featured_videos->user_id == $channel_partner_id && $featured_videos->uploaded_by == "Channel" ) {
                    return $featured_videos;
                }
            });;
            $featured_videos_paginate = $this->paginateCollection($featured_videos_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'featured_videos_pagelist' => $featured_videos_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
                'page_list' => $featured_videos_paginate,
                'base_url' => 'category/videos',
                'header_name' => $order_settings_list[0]->header_name,
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.videos-list', $data);
            } else {
            return Theme::view('Page-List.Featured-videos', $data);
            }

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
            $button_text = ButtonText::first();
            
            $live_list_pagelist = $FrontEndQueryController->livestreams();
            $live_list_paginate = $this->paginateCollection($live_list_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'live_list_pagelist' => $live_list_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
                'button_text'                => $button_text,
                'page_list' => $live_list_paginate,
                'base_url' => 'live',
                'header_name' => $order_settings_list[3]->header_name,
                'BaseURL'                            => $this->BaseURL
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.videos-list', $data);
            } else {
            return Theme::view('Page-List.live-stream', $data);
            }

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
            // return $th->getMessage();
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
            // return $th->getMessage();
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
                'page_list' => $audio_list_paginate,
                'base_url' => 'audio',
                'header_name' => $order_settings_list[5]->header_name,
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.audios-list', $data);
            } else {
            return Theme::view('Page-List.audio-list', $data);
            }

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Series_list($slug = null)
    {
        try {

            $channel_partner_id = Channel::where('channel_slug',$slug)->pluck('id')->first(); 
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latest_series_pagelist = ($slug == null) ? $FrontEndQueryController->latest_Series(): $FrontEndQueryController->latest_Series()->filter(function ($latest_Series) use ($channel_partner_id) {
                if ( $latest_Series->user_id == $channel_partner_id && $latest_Series->uploaded_by == "Channel" ) {
                    return $latest_Series;
                }
            });
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
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Featured_episodes()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $featured_episodes_pagelist = $FrontEndQueryController->featured_episodes();
            $featured_episodes_paginate = $this->paginateCollection($featured_episodes_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'featured_episodes_pagelist' => $featured_episodes_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.featured-episodes', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
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
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function ContentPartner_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $content_partner_pagelist = $FrontEndQueryController->content_Partner();
            $content_partner_paginate = $this->paginateCollection($content_partner_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'content_partner_pagelist' => $content_partner_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.content-partner', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function LatestViewedAudio_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latestViewed_audio_pagelist = $FrontEndQueryController->latestViewedAudio();
            $latestViewed_audio_paginate = $this->paginateCollection($latestViewed_audio_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latestViewed_audio_pagelist' => $latestViewed_audio_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
                'page_list' => $latestViewed_audio_paginate,
                'base_url' => 'audio',
                'header_name' => $order_settings_list[17]->header_name,
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.audios-list', $data);
            } else {
            return Theme::view('Page-List.latest_viewed_audios', $data);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    
    public function epg_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $epg_pagelist = $FrontEndQueryController->Epg();
            $epg_paginate = $this->paginateCollection($epg_pagelist, $this->videos_per_page);


            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'epg_pagelist' => $epg_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.epg-list', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
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

            $combined_watchlater = collect($watchlater_pagelist['videos'])
                ->merge($watchlater_pagelist['episodes'])
                ->merge($watchlater_pagelist['livestream']);

            $watchlater_paginate = $this->paginateCollection($combined_watchlater, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme,
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
            
            $combined_wishlist = collect($wishlist_pagelist['videos'])
                ->merge($wishlist_pagelist['episodes']);

            $wishlist_paginate = $this->paginateCollection($combined_wishlist, $this->videos_per_page);

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

    public function AudioGenre_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $audiogenre_pagelist = $FrontEndQueryController->AudioCategory();
            $audiogenre_paginate = $this->paginateCollection($audiogenre_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'audiogenre_pagelist' => $audiogenre_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.audioGenre', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function LatestViewedEpisode_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latest_viewed_episode_pagelist = $FrontEndQueryController->latestViewedEpisode();
            $latest_viewed_episode_paginate = $this->paginateCollection($latest_viewed_episode_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_viewed_episode_pagelist' => $latest_viewed_episode_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.latest_viewed_episode', $data);
            } else {
        
            return Theme::view('Page-List.latest_viewed_Episode', $data);
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function LatestViewedLive_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latest_viewed_live_pagelist = $FrontEndQueryController->latestViewedLive();
            $latest_viewed_live_paginate = $this->paginateCollection($latest_viewed_live_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_viewed_live_pagelist' => $latest_viewed_live_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
                'page_list' => $latest_viewed_live_paginate,
                'base_url' => 'live',
                'header_name' => $order_settings_list[16]->header_name,
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.videos-list', $data);
            } else {
            return Theme::view('Page-List.latest_viewed_live', $data);
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function LatestViewedVideo_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latest_viewed_video_pagelist = $FrontEndQueryController->latestViewedVideo();
            $latest_viewed_video_paginate = $this->paginateCollection($latest_viewed_video_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_viewed_video_pagelist' => $latest_viewed_video_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
                'page_list' => $latest_viewed_video_paginate,
                'base_url' => 'category/videos',
                'header_name' => $order_settings_list[15]->header_name,
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.videos-list', $data);
            } else {
                return Theme::view('Page-List.latest_viewed_video', $data);
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function VideoBasedCategories_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $video_based_category_pagelist = $FrontEndQueryController->Video_Based_Category();
            $video_based_category_paginate = $this->paginateCollection($video_based_category_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'video_based_category_pagelist' => $video_based_category_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
        return Theme::view('Page-List.video_based_categories', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function MostWatchedCountryVideos_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $most_watched_videos_country_pagelist = $FrontEndQueryController->Most_watched_videos_country();
            $most_watched_videos_country_paginate = $this->paginateCollection($most_watched_videos_country_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'most_watched_videos_country_pagelist' => $most_watched_videos_country_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
        return Theme::view('Page-List.most-watched-videos-country', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function MostWatchedUserVideos_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $most_watched_user_videos_pagelist = $FrontEndQueryController->Most_watched_videos_users();
            $most_watched_user_videos_paginate = $this->paginateCollection($most_watched_user_videos_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'most_watched_user_videos_pagelist' => $most_watched_user_videos_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
        return Theme::view('Page-List.most-watched-videos-user', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function MostWatchedVideoSite_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $most_watched_videos_site_pagelist = $FrontEndQueryController->Most_watched_videos_site();
            $most_watched_videos_site_paginate = $this->paginateCollection($most_watched_videos_site_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'most_watched_videos_site_pagelist' => $most_watched_videos_site_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
        return Theme::view('Page-List.most-watched-videos-site', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function ContinueWatching_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $continue_watching_pagelist = $FrontEndQueryController->continueWatching();
            $continue_watching_paginate = $this->paginateCollection($continue_watching_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'continue_watching_pagelist' => $continue_watching_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        return Theme::view('Page-List.continue-watching-list', $data);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function ContinueWatchingList(Request $request)
    {
        try {

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }

            
            $this->current_theme = $this->HomeSetting->theme_choosen ;
            $current_theme = $this->current_theme;

                $OrderHomeSetting = OrderHomeSetting::get(); 

                $FrontEndQueryController = new FrontEndQueryController();


                // $Video_cnt         = $FrontEndQueryController->VideoJsContinueWatching();
                // $Video_cnt_paginate = $this->paginateCollection($Video_cnt, $this->videos_per_page);

                // $episode_cnt         = $FrontEndQueryController->VideoJsEpisodeContinueWatching();
                // $episode_cnt_paginate = $this->paginateCollection($episode_cnt, $this->videos_per_page);
                // dd($episode_cnt_paginate);

            $data = array(
                'Video_cnt'             => $FrontEndQueryController->VideoJsContinueWatching(),
                'episode_cnt'           => $FrontEndQueryController->VideoJsEpisodeContinueWatching(),
                'current_theme'         => $current_theme,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'currency'      => CurrencySetting::first(),
            );
            // dd($Video_cnt);
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.continue-watching-list', $data);
            } else {   
            return Theme::view('Page-List.Continue-watching', $data);
            }
            // return Theme::view('All-Videos.ContinueWatchingList', $respond_data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Artist_list()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $artist_pagelist = $FrontEndQueryController->artist();
            $artist_paginate = $this->paginateCollection($artist_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'artist_pagelist' => $artist_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
        return Theme::view('Page-List.artist-list', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function ShortsMinis()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $ugc_pagelist = $FrontEndQueryController->UGCVideos();
            $ugc_paginate = $this->paginateCollection($ugc_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'ugc_pagelist' => $ugc_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
                'page_list' => $ugc_paginate,
                'base_url' => 'ugc/video-player',
                'header_name' => $order_settings_list[41]->header_name,
            );
        
            if ($this->current_theme == 'theme5-nemisha') {
                return Theme::view('Page-List.videos-list', $data);
            } else {
                return Theme::view('Page-List.videos-list', $data);
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

    public function deconstruct()
    {
        $this->settings = Setting::first();
        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();

        $this->current_theme = $this->HomeSetting->theme_choosen ;
        Theme::uses($this->current_theme);
    }

    public function Latest_episodes()
    {
        try {
             
            $FrontEndQueryController = new FrontEndQueryController();
            $order_settings_list = OrderHomeSetting::get();
            
            $latest_episodes_pagelist = $FrontEndQueryController->latest_episodes();
            $latest_episodes_paginate = $this->paginateCollection($latest_episodes_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_episodes_pagelist' => $latest_episodes_paginate,
                'order_settings_list' => $order_settings_list,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                'default_vertical_image_url' => default_vertical_image_url(),
            );
        
            return Theme::view('Page-List.Latest-episodes', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

}
