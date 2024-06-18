<?php 

    $current_time = Carbon\Carbon::now()->format('H:i:s');
    $advertisement_plays_24hrs = App\Setting::pluck('ads_play_unlimited_period')->first();

    $video_js_mid_advertisement_sequence_time ='300';

    $pre_advertisement  = null ;
    $mid_advertisement  = null ;
    $post_advertisement = null ;

    if(  plans_ads_enable() == 1 ){

            // Pre-advertisement 

        $pre_advertisement = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id');
                            if($advertisement_plays_24hrs == 0){
                                $pre_advertisement =  $pre_advertisement->whereTime('start', '<=', $current_time)->whereTime('end', '>=', $current_time);
                            }

                            $pre_advertisement =  $pre_advertisement->where('ads_events.status',1)
                                                    ->where('advertisements.status',1)
                                                    ->where('advertisements.id',$Livestream_details->live_ads)
                                                    ->where('advertisements.ads_position','pre')
                                                    ->pluck('ads_path')
                                                    ->first();


            // Mid-advertisement 

        $mid_advertisement = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id');
                                if($advertisement_plays_24hrs == 0){
                                    $mid_advertisement =  $mid_advertisement->whereTime('start', '<=', $current_time)->whereTime('end', '>=', $current_time);
                                }

                                $mid_advertisement =  $mid_advertisement->where('ads_events.status',1)
                                                                        ->where('advertisements.status',1)
                                                                        ->groupBy('advertisements.id')
                                                                        ->where('advertisements.id',$Livestream_details->live_ads)
                                                                        ->where('advertisements.ads_position','mid')
                                                                        ->pluck('ads_path');

            // Post-advertisement 

        $post_advertisement =  App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id');

                                if($advertisement_plays_24hrs == 0){
                                    $post_advertisement =  $post_advertisement->whereTime('start', '<=', $current_time)->whereTime('end', '>=', $current_time);
                                }

                                $post_advertisement =  $post_advertisement->where('ads_events.status',1)
                                                                        ->where('advertisements.status',1)
                                                                        ->where('advertisements.id',$Livestream_details->live_ads)
                                                                        ->where('advertisements.ads_position','post')
                                                                        ->pluck('ads_path')
                                                                        ->first();
    }
?>