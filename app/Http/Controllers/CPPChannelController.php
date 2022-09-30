<?php
namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\Setting;
use App\Genre;
use App\Audio;
use App\Page as Page;
use App\Watchlater as Watchlater;
use App\Wishlist as Wishlist;
use App\PpvVideo as PpvVideo;
use App\PpvPurchase as PpvPurchase;
use App\RecentView as RecentView;
use App\Movie;
use App\Episode;
use App\ContinueWatching as ContinueWatching;
use App\LikeDislike as LikeDislike;
use App\VideoCategory;
use App\RegionView;
use App\UserLogs;
use App\Videoartist;
use App\Artist;
use App\PaymentSetting;
use App\ScheduleVideos;
use App\Language;
use URL;
use Auth;
use View;
use Hash;
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;
use Session;
use App\Playerui as Playerui;
use App\MoviesSubtitles as MoviesSubtitles;
use App\Video as Video;
use Carbon\Carbon;
use DateTime;
use App\CurrencySetting as CurrencySetting;
use App\HomeSetting as HomeSetting;
use App\BlockVideo as BlockVideo;
use App\CategoryVideo as CategoryVideo;
use App\LanguageVideo;
use App\AdsVideo;
use Theme;
use App\ThumbnailSetting;
use App\Geofencing;
use App\AgeCategory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use App\RelatedVideo;
use App\LiveCategory;
use App\SeriesGenre;
use App\Series;

class CPPChannelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')
            ->first();
        Theme::uses($this->Theme);
    }
        

    public function PlayVideo($slug)
    {
        // dd($slug);

        try
        {
            $user_package =    User::where('id', 1)->first();
            $package = $user_package->package;
            if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
              $user = Session::get('user'); 
                $id = $user->id;
                    $videos = Video::where('slug',$slug)->first();
            $data = array(
                'video' => $videos,

            );
            return View('moderator.cpp.videos.player', $data);

            }else{
                return Redirect::to('/blocked');
            }
    }
    catch(\Throwable $th)
    {

        return abort(404);

    }
    }

}

