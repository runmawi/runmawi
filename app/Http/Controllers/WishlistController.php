<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\Video as Video;
use App\PpvVideo as PpvVideo;
use App\Homesetting;
use Auth;
use View;
use Session;
use Theme;
class WishlistController extends Controller
{
    public function mywishlist(Request $request)
    {

        $video_id = $request['video_id'];
        Session::flash('success', __('Password change successfully. Please Login again'));

        if ($video_id)
        {
            $watchlater = Wishlist::where('user_id', '=', Auth::user()->id)
                ->where('video_id', '=', $video_id)->where('type', '=', 'channel')
                ->first();
            if (isset($watchlater->id))
            {
                $watchlater->delete();
                $response = "Removed From Wishlist";
                return $response;
            }
            else
            {
                $watchlater = new Wishlist;
                $watchlater->user_id = Auth::user()->id;
                $watchlater->video_id = $video_id;
                $watchlater->type = 'channel';
                $watchlater->save();
                Session::flash('success', 'Product Suucess!');
                // Session::flash('success','Product Suucess!');
                $response = "Added To Wishlist";

                return $response;
                //echo $watchlater;
                
            }

        }
    }

    public function ppvWishlist(Request $request)
    {

        $video_id = $request['video_id'];

        if ($video_id)
        {
            $watchlater = Wishlist::where('user_id', '=', Auth::user()->id)
                ->where('video_id', '=', $video_id)->where('type', '=', 'ppv')
                ->first();
            if (isset($watchlater->id))
            {
                $watchlater->delete();
            }
            else
            {
                $watchlater = new Wishlist;
                $watchlater->user_id = Auth::user()->id;
                $watchlater->video_id = $video_id;
                $watchlater->type = 'ppv';
                $watchlater->save();
                echo $watchlater;
            }

        }
    }

    public function show_mywishlists()
    {
        $Theme = Homesetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);
        
        if (Auth::guest())
        {
            return redirect('/login');
        }
        $channelwatchlater = Wishlist::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'channel')
            ->get();
        $ppvwatchlater = Wishlist::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'ppv')
            ->get();

        $channel_watchlater_array = array();
        foreach ($channelwatchlater as $key => $cfave)
        {
            array_push($channel_watchlater_array, $cfave->video_id);
        }

        $ppv_watchlater_array = array();
        foreach ($ppvwatchlater as $key => $ccfave)
        {
            array_push($ppv_watchlater_array, $ccfave->video_id);
        }

        $videos = Video::where('active', '=', '1')->whereIn('id', $channel_watchlater_array)->paginate(12);
        $ppvvideos = PpvVideo::where('active', '=', '1')->whereIn('id', $ppv_watchlater_array)->paginate(12);

        $data = array(
            'ppvwatchlater' => $ppvvideos,
            'channelwatchlater' => $videos
        );

        return Theme::view('mywhislist', $data);

    }

}

