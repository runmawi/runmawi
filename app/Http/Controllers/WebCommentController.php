<?php

namespace App\Http\Controllers;

use Auth;
use Theme;
use \Redirect;
use App\WebComment;
use App\HomeSetting;
use App\CommentLikeDislike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        elseif( $request->source == 'play_ugc_videos' ){
            $source = "App\UGCVideo";
        } 
        else {
            $source = null;
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
            'approved' => Auth::user()->role == "admin" ? 1 : 0 ,
        );
        
        $comment = WebComment::create($inputs);

        try {
            \Mail::send('emails.comment_admin_approval', 
                array(
                    'website_name' => GetWebsiteName()
                ) , 
                function ($message) {
                    $message->to( AdminMail(), AdminMail())->subject('Comment Is Pending & Waiting For Admin Approval !');
                });

            $email_log      = 'Mail Sent Successfully from Comment Is Pending & Waiting For Admin Approval !';
            $email_template = null;
            $user_id = Auth::user()->id;

            Email_sent_log($user_id,$email_log,$email_template);

        } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = null ;
            $user_id =  Auth::user()->id;
        
            Email_notsent_log($user_id,$email_log,$email_template);
        }

        $response = [
            'success' => true,
            'commentId' => $comment->id,
            'userName' => Auth::user()->username,
            'commentText' => $comment->comment,
            'commentTime' => $comment->created_at->diffForHumans(),
            'likeCount' => $comment->likes()->count(),
            'dislikeCount' => $comment->dislikes()->count(),
        ];

        if ($request->ajax()) {
            return response()->json($response);
        }

        return Redirect::back()->with(['message' => 'Comment Submitted Successfully and Waiting for Admin Approval!', 'note_type' => 'success']);
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
        elseif( $request->source == 'play_ugc_videos' ){
            $source = "App\UGCVideo";
        } 
        else {
            $source = null;
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
            'approved' => Auth::user()->role == "admin" ? 1 : 0 ,
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
        elseif( $request->source == 'play_ugc_videos' ){
            $source = "App\UGCVideo";
        } 
        else {
            $source = null;
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
            'approved' => Auth::user()->role == "admin" ? 1 : 0 ,
        );

        WebComment::create($inputs);

        return Redirect::back();
    }

    public function like(Request $request)
    {
        $comment = Webcomment::find($request->comment_id);
        $user = auth()->user();

        $existing = CommentLikeDislike::where('comment_id', $request->comment_id)
                                      ->where('user_id', $user->id)
                                      ->first();

        if ($existing) {
            if ($existing->type == 1) {
                $existing->delete();
            } else {
                $existing->delete();
                CommentLikeDislike::create([
                    'comment_id' => $request->comment_id,
                    'user_id' => $user->id,
                    'type' => 1
                ]);
            }
        } else {
            CommentLikeDislike::create([
                'comment_id' => $request->comment_id,
                'user_id' => $user->id,
                'type' => 1
            ]);
        }

        CommentLikeDislike::where('comment_id', $request->comment_id)
                          ->where('user_id', $user->id)
                          ->where('type', 2)
                          ->delete();

        return response()->json([
            'success' => true,
            'like_count' => $comment->likes()->count(),
            'dislike_count' => $comment->dislikes()->count(),
            'like_status' => is_null($existing) ? "Add" : "Remove "  ,
            'liked' => true,
        ]);
    }

    public function dislike(Request $request)
    {
        $comment = Webcomment::find($request->comment_id);
        $user = auth()->user();

        $existing = CommentLikeDislike::where('comment_id', $request->comment_id)
                                      ->where('user_id', $user->id)
                                      ->first();

        if ($existing) {
            if ($existing->type == 2) {
                $existing->delete();
            } else {
                $existing->delete();
                CommentLikeDislike::create([
                    'comment_id' => $request->comment_id,
                    'user_id' => $user->id,
                    'type' => 2
                ]);
            }
        } else {
            CommentLikeDislike::create([
                'comment_id' => $request->comment_id,
                'user_id' => $user->id,
                'type' => 2
            ]);
        }

        CommentLikeDislike::where('comment_id', $request->comment_id)
                          ->where('user_id', $user->id)
                          ->where('type', 1)
                          ->delete();

        return response()->json([
            'success' => true,
            'like_count' => $comment->likes()->count(),
            'dislike_count' => $comment->dislikes()->count(),
            'dislike_status' => is_null($existing) ? "Add" : "Remove "  ,
            'disliked' => true,
        ]);
    }
    
}