<?php


namespace App\Helpers;
use Request;
use App\LogActivity as LogActivityModel;


class LogActivity
{


    public static function addToLog($subject)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }

    public static function addVideoLog($subject,$video_id)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
		$log['video_id'] = $video_id;
    	LogActivityModel::create($log);
    }

	public static function addVideoUpdateLog($subject,$video_id)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
		$log['video_id'] = $video_id;
    	LogActivityModel::create($log);
    }

	public static function addVideodeleteLog($subject,$video_id)
    {
		// dd($video_id);
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
		$log['video_id'] = $video_id;
    	LogActivityModel::create($log);
    }
	
	public static function addVideoCategoryLog($subject,$video_id,$value)
    {
		// dd($video_id);
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
		$log['video_id'] = $video_id;
		$log['video_category_id'] = $value;
    	LogActivityModel::create($log);
    }


	public static function addVideoLanguageLog($subject,$video_id,$value)
    {
		// dd($video_id);
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
		$log['video_id'] = $video_id;
		$log['video_language_id'] = $value;
    	LogActivityModel::create($log);
    }


	public static function addVideoArtistLog($subject,$video_id,$value)
    {
		// dd($video_id);
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
		$log['video_id'] = $video_id;
		$log['video_artist_id'] = $value;
    	LogActivityModel::create($log);
    }



}