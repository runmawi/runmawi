<?php 

    $current_time = Carbon\Carbon::now()->format('H:i:s');
    $advertisement_plays_24hrs = App\Setting::pluck('ads_play_unlimited_period')->first();

    $video_js_mid_advertisement_sequence_time = $episode_details->video_js_mid_advertisement_sequence_time != null ? Carbon\Carbon::parse( $episode_details->video_js_mid_advertisement_sequence_time )->secondsSinceMidnight()  : '300';

    $pre_advertisement  = null ;
    $mid_advertisement  = null ;
    $post_advertisement = null ;

    if(  plans_ads_enable() == 1 ){

            // Pre-advertisement 

        $pre_advertisement = App\Advertisement::select('advertisements.*','ads_events.ads_id','ads_events.status','ads_events.end','ads_events.start')
                                        ->join('ads_events', 'ads_events.ads_id', '=', 'advertisements.id')
                                        ->where('advertisements.status', 1)

                                        ->when( $episode_details->pre_ads == 'random_ads', function ($query) {

                                            return $query->inRandomOrder();

                                        }, function ($query) use ($episode_details) {

                                            return $query->where('advertisements.id', $episode_details->pre_ads );

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

                                    ->when( $episode_details->mid_ads == 'random_category', function ($query) {

                                            return $query ;

                                        }, function ($query) use ($episode_details) {

                                            return $query->where('advertisements.ads_category', $episode_details->mid_ads);

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

                                        ->when( $episode_details->post_ads == 'random_ads', function ($query) {

                                            return $query->inRandomOrder();

                                            }, function ($query) use ($episode_details) {

                                            return $query->where('advertisements.id', $episode_details->post_ads);

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
    

?>