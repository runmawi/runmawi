<?php 

$current_time = Carbon\Carbon::now()->format('H:i:s');
$adveristment_plays_24hrs = App\Setting::pluck('ads_play_unlimited_period')->first();

if(  plans_ads_enable() == 1 ){
  
    $video_tag_url = App\AdsEvent::select('videos.ads_tag_url_id','videos.id as video_id','advertisements.*','ads_events.ads_id','ads_events.status','ads_events.end','ads_events.start')
                    ->Join('advertisements','advertisements.id','=','ads_events.ads_id')
                    ->Join('videos', 'advertisements.id', '=', 'videos.ads_tag_url_id');
                     // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
       
                    if($adveristment_plays_24hrs == 0){
                        $video_tag_url =  $video_tag_url->whereTime('ads_events.start', '<=', $current_time)->whereTime('ads_events.end', '>=', $current_time);
                    }

                    $video_tag_url =  $video_tag_url->where('ads_events.status',1)
                    ->where('advertisements.status',1)
                    // ->where('advertisements.ads_upload_type','tag_url')
                    ->where('advertisements.id',$video->ads_tag_url_id)
                    ->where('videos.id', $video->id)
                    ->groupBy('advertisements.id')
                    ->pluck('ads_path')
                    ->first();
            }
            else
            {
                    $video_tag_url = null ;
            }
?>

<input type="hidden" id="video_tag_url" name="video_tag_url" value="<?= $video_tag_url ?>">
<input type="hidden" id="ads_tag_url_id" name="ads_tag_url_id" value="<?= $video->ads_tag_url_id ?>">