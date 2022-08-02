<?php
$current_time = Carbon\Carbon::now()->format('H:i:s');

$pre_ads_url = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
    ->Join('videos','advertisements.ads_category','=','videos.ads_category')
    ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
    ->whereTime('start', '<=', $current_time)
    ->whereTime('end', '>=', $current_time)
    ->where('ads_events.status',1)
    ->where('advertisements.status',1)
    ->where('advertisements.ads_position','pre')
    ->where('videos.ads_category',$video->ads_category)
    ->pluck('ads_path');
    if(count($pre_ads_url) > 0){
        $pre_ads_url =  $pre_ads_url->random();
    }
?>

<input type="hidden" id="pre_ads_url" name="pre_ads_url" value="<?= $pre_ads_url ; ?>">