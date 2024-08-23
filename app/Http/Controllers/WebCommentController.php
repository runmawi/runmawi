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
        
        WebComment::create($inputs);

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

    public function like(Request $request, $id)
{
    $userId = auth()->id(); // Get the authenticated user's ID

    try {
        // Find the comment
        $comment = WebComment::find($id);
        if (!$comment) {
            return response()->json(['status' => false, 'message' => 'Comment not found.']);
        }

        // Determine current like and dislike states
        $hasLiked = $comment->has_liked; // Check if the user has liked the comment
        $hasDisliked = $comment->has_disliked; // Check if the user has disliked the comment

        // Update like and dislike counts based on current state
        if ($hasLiked) {
            // Remove like
            $comment->comment_like -= 1;
            $comment->has_liked = false;
        } else {
            // Add like
            $comment->comment_like += 1;
            $comment->has_liked = true;

            // Remove dislike if exists
            if ($hasDisliked) {
                $comment->comment_dislike -= 1;
                $comment->has_disliked = false;
            }
        }

        // Ensure counts are not negative
        $comment->comment_like = max($comment->comment_like, 0);
        $comment->comment_dislike = max($comment->comment_dislike, 0);

        // Save the updated comment
        $comment->save();

        return response()->json([
            'status' => true,
            'message' => 'Like toggled.',
            'new_like_count' => $comment->comment_like,
            'new_dislike_count' => $comment->comment_dislike,
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

public function dislike(Request $request, $id)
{
    $userId = auth()->id(); // Get the authenticated user's ID

    try {
        // Find the comment
        $comment = WebComment::find($id);
        if (!$comment) {
            return response()->json(['status' => false, 'message' => 'Comment not found.']);
        }

        // Determine current like and dislike states
        $hasLiked = $comment->has_liked; // Check if the user has liked the comment
        $hasDisliked = $comment->has_disliked; // Check if the user has disliked the comment

        // Update like and dislike counts based on current state
        if ($hasDisliked) {
            // Remove dislike
            $comment->comment_dislike -= 1;
            $comment->has_disliked = false;
        } else {
            // Add dislike
            $comment->comment_dislike += 1;
            $comment->has_disliked = true;

            // Remove like if exists
            if ($hasLiked) {
                $comment->comment_like -= 1;
                $comment->has_liked = false;
            }
        }

        // Ensure counts are not negative
        $comment->comment_like = max($comment->comment_like, 0);
        $comment->comment_dislike = max($comment->comment_dislike, 0);

        // Save the updated comment
        $comment->save();

        return response()->json([
            'status' => true,
            'message' => 'Dislike toggled.',
            'new_like_count' => $comment->comment_like,
            'new_dislike_count' => $comment->comment_dislike,
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

}