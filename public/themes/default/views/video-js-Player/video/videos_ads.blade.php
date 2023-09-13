<?php 

    $current_time = Carbon\Carbon::now()->format('H:i:s');
    $advertisement_plays_24hrs = App\Setting::pluck('ads_play_unlimited_period')->first();

    $video_js_mid_advertisement_sequence_time = $videodetail->video_js_mid_advertisement_sequence_time != null ? Carbon\Carbon::parse( $videodetail->video_js_mid_advertisement_sequence_time )->secondsSinceMidnight()  : '300';

    $pre_advertisement  = null ;
    $mid_advertisement  = null ;
    $post_advertisement = null ;

    if(  plans_ads_enable() == 1 ){

            // Pre-advertisement 

        $pre_advertisement = App\Advertisement::select('advertisements.*','ads_events.ads_id','ads_events.status','ads_events.end','ads_events.start')
                                        ->join('ads_events', 'ads_events.ads_id', '=', 'advertisements.id')
                                        ->where('advertisements.status', 1)

                                        ->when( $videodetail->video_js_pre_position_ads == 'Random', function ($query) {

                                            return $query->inRandomOrder();

                                        }, function ($query) use ($videodetail) {

                                            return $query->where('advertisements.id', $videodetail->video_js_pre_position_ads );

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

                                    ->when( $videodetail->video_js_mid_position_ads_category == 'Random', function ($query) {

                                            return $query ;

                                        }, function ($query) use ($videodetail) {

                                            return $query->where('advertisements.ads_category', $videodetail->video_js_mid_position_ads_category);

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

                                        ->when( $videodetail->video_js_pre_position_ads == 'Random', function ($query) {

                                            return $query->inRandomOrder();

                                            }, function ($query) use ($videodetail) {

                                            return $query->where('advertisements.id', $videodetail->video_js_post_position_ads);

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