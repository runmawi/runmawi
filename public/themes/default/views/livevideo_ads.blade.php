<?php 

    $live_ads = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
        // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
        // ->whereTime('start', '<=', $current_time)
        // ->whereTime('end', '>=', $current_time)
        ->where('ads_events.status',1)
        ->where('advertisements.status',1);

        if( $video->pre_ads != null){
            $live_ads = $live_ads->where('ads_position','pre')
                        ->where('advertisements.id',$video->pre_ads);
        }
        elseif ( $video->mid_ads != null ){
            $live_ads = $live_ads->where('ads_position','mid')
                        ->where('advertisements.id',$video->mid_ads);
        }
        elseif( $video->post_ads != null ){
            $live_ads = $live_ads->where('ads_position','post')
                        ->where('advertisements.id',$video->post_ads);
        }else{
            $live_ads = $live_ads->where('ads_position','null');
        }

        $live_ads = $live_ads->pluck('ads_path')->first();
?>