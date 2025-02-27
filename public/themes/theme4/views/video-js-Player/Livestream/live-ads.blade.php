<?php 

    $current_time = Carbon\Carbon::now()->format('H:i:s');
    $advertisement_plays_24hrs = App\Setting::pluck('ads_play_unlimited_period')->first();

    $video_js_mid_advertisement_sequence_time = $Livestream_details->video_js_mid_advertisement_sequence_time != null ? Carbon\Carbon::parse( $Livestream_details->video_js_mid_advertisement_sequence_time )->secondsSinceMidnight()  : '300';

    $pre_advertisement  = null ;
    $mid_advertisement  = null ;
    $post_advertisement = null ;

    if(  plans_ads_enable() == 1 ){

            // Pre-advertisement 

        $pre_advertisement = App\Advertisement::select('advertisements.*','ads_events.ads_id','ads_events.status','ads_events.end','ads_events.start')
                                        ->join('ads_events', 'ads_events.ads_id', '=', 'advertisements.id')
                                        ->where('advertisements.status', 1)

                                        ->when( $Livestream_details->pre_ads == 'random_ads', function ($query) {

                                            return $query->inRandomOrder();

                                        }, function ($query) use ($Livestream_details) {

                                            return $query->where('advertisements.id', $Livestream_details->pre_ads );

                                        })

                                        ->when( $advertisement_plays_24hrs == 0, function ($query) use ($current_time) {

                                            return $query->where('ads_events.status', 1)
                                                ->whereTime('ads_events.start', '<=', $current_time)
                                                ->whereTime('ads_events.end', '>=', $current_time);
                                        })

                                        ->groupBy('advertisements.id')
                                        ->pluck('ads_path')
                                        ->first();


            // Mid-advertisement 

        $mid_advertisement = App\Advertisement::select('advertisements.*', 'ads_events.ads_id', 'ads_events.status', 'ads_events.end', 'ads_events.start')
                                    ->join('ads_events', 'ads_events.ads_id', '=', 'advertisements.id')
                                    ->where('advertisements.status', 1)
                                    ->groupBy('advertisements.id')

                                    ->when( $Livestream_details->mid_ads == 'random_category', function ($query) {

                                            return $query ;

                                        }, function ($query) use ($Livestream_details) {

                                            return $query->where('advertisements.ads_category', $Livestream_details->mid_ads);

                                        })

                                        ->when( $advertisement_plays_24hrs == 0 , function ($query) use ($current_time) {

                                            return $query->where('ads_events.status', 1)
                                                ->whereTime('ads_events.start', '<=', $current_time)
                                                ->whereTime('ads_events.end', '>=', $current_time);
                                            })
                                    
                                    ->pluck('ads_path');

            // Post-advertisement 

        $post_advertisement = App\Advertisement::select('advertisements.*','ads_events.ads_id','ads_events.status','ads_events.end','ads_events.start')
                                        ->join('ads_events','ads_events.ads_id','=','advertisements.id')
                                        ->where('advertisements.status', 1 )

                                        ->when( $Livestream_details->post_ads == 'random_ads', function ($query) {

                                            return $query->inRandomOrder();

                                            }, function ($query) use ($Livestream_details) {

                                            return $query->where('advertisements.id', $Livestream_details->post_ads);

                                            })

                                        ->when( $advertisement_plays_24hrs == 0, function ($query) use ($current_time) {

                                            return $query->where('ads_events.status', 1)
                                                ->whereTime('ads_events.start', '<=', $current_time)
                                                ->whereTime('ads_events.end', '>=', $current_time);
                                            })

                                        ->groupBy('advertisements.id')
                                        ->pluck('ads_path')
                                        ->first();


    }

        if($setting->default_ads_status == 1 && !is_null($setting->default_ads_url) && is_null($pre_advertisement) ){
            $pre_advertisement  = $setting->default_ads_url;
        }

        if($setting->default_ads_status == 1 && !is_null($setting->default_ads_url)  && is_null($mid_advertisement) ){
            $mid_advertisement[]  = $setting->default_ads_url;
            $video_js_mid_advertisement_sequence_time = 1800 ;
        }

        if($setting->default_ads_status == 1 && !is_null($setting->default_ads_url)  && is_null($post_advertisement) ){
            $post_advertisement = $setting->default_ads_url;
        }

?>