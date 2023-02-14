<?php 

if(  plans_ads_enable() == 1 ){
  
    $live_ads = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
        // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
        // ->whereTime('start', '<=', $current_time)
        // ->whereTime('end', '>=', $current_time)
        ->where('ads_events.status',1)
        ->where('advertisements.status',1)
        ->where('advertisements.id',$video->live_ads)
        ->where('advertisements.ads_position',$video->ads_position)
        ->pluck('ads_path')->first();
  }
  else
  {
        $live_ads = null ;
  }

?>