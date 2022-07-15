
<?php 

  $Mid_tyming =App\PlayerAnalytic::where('videoid',$video->id)->groupBy('videoid')
                ->orderBy('created_at', 'desc')->pluck('duration')->first();

  $Mid_tym = $Mid_tyming / 2 ;

  $current_time = Carbon\Carbon::now()->format('H:i:s');

  $AdsVideosMid = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
    ->Join('videos','advertisements.ads_category','=','videos.ads_category')
    ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
    // ->whereTime('start', '<=', $current_time)
    // ->whereTime('end', '>=', $current_time)
    ->where('ads_events.status',1)
    ->where('advertisements.status',10)
    ->where('advertisements.ads_position','mid')
    ->where('videos.ads_category',$video->ads_category)
    ->get();


    if( count($AdsVideosMid) >= 1){
      $AdsVideossMid = $AdsVideosMid->random();

      $AdsvideoFileMid = URL::to('public/uploads/AdsVideos/'.$AdsVideossMid->ads_video);

      if($AdsVideossMid->ads_video != null ){

        $getID3               = new getID3;
        $Ads_store_path_mid   = public_path('uploads/AdsVideos/'.$AdsVideossMid->ads_video);       
        $Ads_duration_mid     = $getID3->analyze($Ads_store_path_mid);
        $Ads_duration_Sec_mid = $Ads_duration_mid['playtime_seconds'];
        $ads_path_tag          = null ;
        
      }else{
        $Ads_duration_Sec_mid = null;
        $ads_path_tag     = $AdsVideossMid->ads_path ;
      }
      
      $advertiser_id_mid    =  $AdsVideossMid->advertiser_id ; 
      $ads_id_mid           =  $AdsVideossMid->ads_id ;
      $ads_position_mid     =  $AdsVideossMid->ads_position ;
      $ads_path_tag         =  $AdsVideossMid->ads_path;
      $ads_type_mid         =  $AdsVideossMid->ads_video ;
    }else{

      $AdsvideoFileMid        = null ;
      $Ads_duration_Sec_mid  = null ;
      $advertiser_id_mid   =  null ; 
      $ads_id_mid          =  null ; 
      $ads_position_mid    =  null ;
      $ads_path_tag        =  null ;
      $ads_type_mid         =  null ;

    }


    if( $ads_position_mid !=null && $ads_position_mid == 'mid'){

        $ads_start_tym_mid = $Mid_tym;

    }else{
        $ads_start_tym_mid = ' ';
    }

  $normalvideoFileMid =  URL::to('storage/app/public/'.$video->path);

?>

  <input type="hidden" id="ads_start_tym_mid" class="ads_start_tym_mid"  value='<?php  echo $ads_start_tym_mid  ; ?>'>
  <input type="hidden" id="" class="ads_show_status_mid"  value='1'>
  <input type="hidden" id="Ads_vies_count_mid" onclick="Ads_vies_count()"> 

<script>

  var videoads_tym_mid    =  document.getElementById(videotypeId);
  var Ads_videos_mid      = <?php echo json_encode($AdsvideoFileMid)  ;?>;
  var normal_videos_mid   = <?php  echo json_encode($normalvideoFileMid)  ;?>;
  var ads_end_tym_mid     =  <?php  echo json_encode($Ads_duration_Sec_mid)  ;?>;
  var Ads_count_mid       = <?php echo count($AdsVideosMid); ?> ;
  var Ads_type_mid        = <?php echo json_encode($ads_type_mid); ?> ;
  var Mid_tym             = <?php echo json_encode($Mid_tym); ?> ;
  var ads_mid_videoplayer_id  = <?php echo json_encode($video_type_id); ?> ;


  if( Ads_count_mid >= 1 &&  Ads_type_mid != null ){

  this.videoads_tym_mid.addEventListener('timeupdate', (e) => {

        var ads_start_tym_mid   =  $('.ads_start_tym_mid').val();
        var ads_show_status_mid  = $('.ads_show_status_mid').val();

          if (ads_start_tym_mid <= e.target.currentTime) {

          if(ads_show_status_mid == 1){
            
                $('.adstime_url').attr('src', Ads_videos_mid);

                document.getElementById(ads_mid_videoplayer_id).addEventListener('loadedmetadata', function() {
                    this.currentTime = 0;
                }, true);
                
                videoId.play();
                  $('#ads_start_tym_mid').replaceWith('<input type="hidden" id="ads_start_tym_mid" class="ads_start_tym_mid" value="'+ ads_end_tym_mid+'">');
                  $('.ads_show_status_mid').replaceWith('<input type="hidden" id="" class="ads_show_status_mid"  value="0">');
                  document.getElementById("Ads_vies_count_mid").click();
                 
                  $(".plyr__controls__item ").css("display", "none");
                  $(".plyr__time ").css("display", "block");
            }
            else if(ads_show_status_mid == 0){
                  $('.ads_show_status_mid').replaceWith('<input type="hidden" id="" class="ads_show_status_mid"  value="5">');
                  $('.adstime_url').attr('src', normal_videos_mid);

                  $(".plyr__controls__item").css("display", "block");
                  $(".plyr__volume").removeAttr("style");

                  document.getElementById(ads_mid_videoplayer_id).addEventListener('loadedmetadata', function() {
                      this.currentTime = Mid_tym;
                    }, true);

                videoId.play();
            }
          }
        });
      }

    function Ads_vies_count_mid(){

      $.ajax({
      url: '<?php echo URL::to("admin/ads_viewcount_mid") ;?>',
      method: 'post',
      data: 
          {
            "_token"      :  "<?php echo csrf_token(); ?>",
            advertiser_id :  <?php echo $advertiser_id_mid ; ?> , 
            ads_id        :  <?php echo $ads_id_mid ; ?> ,
            video_id      :  <?php echo $video->id ; ?> ,
          },
          success: (response) => {
            console.log(response);
          },
      })  
		}

</script>
