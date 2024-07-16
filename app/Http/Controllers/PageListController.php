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

            $latest_videos_pagelist = $FrontEndQueryController->Latest_videos();
            $latest_videos_paginate = $this->paginateCollection($latest_videos_pagelist, $this->videos_per_page);

            $data = array(
                'current_theme' => $this->current_theme ,
                'currency'      => CurrencySetting::first(),
                'latest_videos_pagelist' => $latest_videos_paginate,
                'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
            );
        
            return Theme::view('Page-List.latest-videos', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
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

}
