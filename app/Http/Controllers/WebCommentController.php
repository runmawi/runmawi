<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Redirect;
use App\HomeSetting;
use App\WebComment;
use Theme;
use Auth;
use Illuminate\Support\Facades\Route;

class WebCommentController extends Controller
{

    public function __construct()
    {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);
    }

    public function comment_index(Request $request)
    {
        $inputs = array(
            'comment' =>  WebComment::where('source_id',1)->where('commentable_type','LiveStream_play')->first(),
        );

        return Theme::view('comments.index', $inputs);
    }

    public function comment_store(Request $request)
    {

        if( $request->source == 'LiveStream_play' ){
            $source = "App\LiveStream";
        }
        elseif( $request->source == 'play_videos' ){
            $source = "App\Video";
        }
        elseif( $request->source == 'play_episode' ){
            $source = "App\Episode";
        }
        elseif( $request->source == 'play_audios' ){
            $source = "App\Audio";
        }

        $inputs = array(
            'user_id'   => Auth::user()->id ,
            'user_role' => Auth::user()->role ,
            'user_name' => Auth::user()->username ,
            'first_letter' => Auth::user()->username != null ? ucfirst(mb_substr(Auth::user()->username, 0, 1)) : 'No Name',
            'commenter_type'   => 'App\User' ,
            'commentable_type' => $request->source ,
            'source'      => $source ,
            'source_id'   => $request->source_id ,
            'comment'  => $request->message ,
            'approved' => 1 ,
        );
        
        WebComment::create($inputs);

        return Redirect::back();
    }


    public function comment_update(Request $request,$id)
    {
        
        if( $request->source == 'LiveStream_play' ){
            $source = "App\LiveStream";
        }
        elseif( $request->source == 'play_videos' ){
            $source = "App\Video";
        }
        elseif( $request->source == 'play_episode' ){
            $source = "App\Episode";
        }
        elseif( $request->source == 'play_audios' ){
            $source = "App\Audio";
        }

        $inputs = array(
            'user_id'   => Auth::user()->id ,
            'user_role' => Auth::user()->role ,
            'user_name' => Auth::user()->username ,
            'first_letter' => Auth::user()->username != null ? ucfirst(mb_substr(Auth::user()->username, 0, 1))  : 'No Name',
            'commenter_type'   => 'App\User' ,
            'commentable_type' => $request->source ,
            'source'      => $source ,
            'source_id'   => $request->source_id ,
            'comment'  => $request->message ,
            'approved' => 1 ,
        );

        WebComment::findorfail($id)->update($inputs);

        return Redirect::back();
    }

    public function comment_destroy($id)
    {
        WebComment::findorfail($id)->delete();

        return Redirect::back();
    }

    public function comment_reply(Request $request,$id)
    {
        if( $request->source == 'LiveStream_play' ){
            $source = "App\LiveStream";
        }
        elseif( $request->source == 'play_videos' ){
            $source = "App\Video";
        }
        elseif( $request->source == 'play_episode' ){
            $source = "App\Episode";
        }
        elseif( $request->source == 'play_audios' ){
            $source = "App\Audio";
        }

        $inputs = array(
            'user_id'   => Auth::user()->id ,
            'user_role' => Auth::user()->role ,
            'user_name' => Auth::user()->username ,
            'commenter_type'   => 'App\User' ,
            'commentable_type' => $request->source ,
            'source'      =>  $source   ,
            'source_id'   => $request->source_id ,
            'comment'   => $request->message ,
            'child_id'  => $id ,
            'approved' => 1 ,
        );

        WebComment::create($inputs);

        return Redirect::back();
    }
}
