<!-- Ads -->

<?php 

  $current_time = Carbon\Carbon::now()->format('H:i:s');

  $AdsVideos = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
    ->Join('videos','advertisements.ads_category','=','videos.ads_category')
    ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
    // ->whereTime('start', '<=', $current_time)
    // ->whereTime('end', '>=', $current_time)
    ->where('ads_events.status',1)
    ->where('advertisements.status',1)
    ->where('videos.ads_category',$video->ads_category)
    ->where('ads_position','pre')
    ->get();


    if( count($AdsVideos) >= 1){
      $AdsVideoss = $AdsVideos->random();

      $AdsvideoFile = URL::to('public/uploads/AdsVideos/'.$AdsVideoss->ads_video);


      if($AdsVideoss->ads_video != null ){

        $getID3           = new getID3;
        $Ads_store_path   = public_path('/uploads/AdsVideos/'.$AdsVideoss->ads_video);       
        $Ads_duration     = $getID3->analyze($Ads_store_path);
        $Ads_duration_Sec = $Ads_duration['playtime_seconds'];
        $ads_path_tag     = null ;
      }
      else{
        $Ads_duration_Sec = null;
        $ads_path_tag     = $AdsVideoss->ads_path ;
      }

      $advertiser_id    =  $AdsVideoss->advertiser_id ; 
      $ads_id           =  $AdsVideoss->ads_id ;
      $ads_position     =  $AdsVideoss->ads_position ;
      $ads_path_tag     =  $AdsVideoss->ads_path;
      $ads_type         =  $AdsVideoss->ads_video ;

    }else{

      $AdsvideoFile     =  null ;
      $Ads_duration_Sec =  null ;
      $advertiser_id    =  null ; 
      $ads_id           =  null ; 
      $ads_position     =  null ;
      $ads_path_tag     =  null ;
      $ads_type         =  null ;
    }


    if($ads_position !=null && $ads_position == 'pre'){

        $ads_start_tym = '0.1';

    }else{
      $ads_start_tym = ' ';
    }

  $normalvideoFile =  URL::to('storage/app/public/'.$video->path);

?>

  <input type="hidden" name="ads_path_tag" id="ads_path_tag" value="<?php echo  $ads_path_tag;?>">
  <input type="hidden" id="ads_start_tym" class="ads_start_tym"  value='<?php  echo $ads_start_tym  ; ?>'>
  <input type="hidden" id="" class="ads_show_status"  value='1'>
  <input type="hidden" id="Ads_vies_count" onclick="Ads_vies_count()"> 

<script>

  var videoads_tym    =  document.getElementById(videotypeId);
  var Ads_videos      = <?php echo json_encode($AdsvideoFile)  ;?>;
  var normal_videos   = <?php  echo json_encode($normalvideoFile)  ;?>;
  var ads_end_tym     = <?php  echo json_encode($Ads_duration_Sec)  ;?>;
  var Ads_count       = <?php echo count($AdsVideos); ?> ;
  var Ads_type        = <?php echo json_encode($ads_type); ?> ;


  if( Ads_count >= 1 && Ads_type != null){

  this.videoads_tym.addEventListener('timeupdate', (e) => {

        var ads_start_tym   =  $('.ads_start_tym').val();
        var ads_show_status  = $('.ads_show_status').val();

          if (ads_start_tym <= e.target.currentTime) {

          if(ads_show_status == 1){
            
                $('.adstime_url').attr('src', Ads_videos);

                  document.getElementById('videoPlayer').addEventListener('loadedmetadata', function() {
                      this.currentTime = 0;
                  }, true);
                  
                  videoId.play();
                  $('#ads_start_tym').replaceWith('<input type="hidden" id="ads_start_tym" class="ads_start_tym" value="'+ ads_end_tym+'">');
                  $('.ads_show_status').replaceWith('<input type="hidden" id="" class="ads_show_status"  value="0">');
                
                  $(".plyr__controls__item ").css("display", "none");
                  $(".plyr__time ").css("display", "block");

                  document.getElementById("Ads_vies_count").click();
            }
            else if(ads_show_status == 0){
                  $('.ads_show_status').replaceWith('<input type="hidden" id="" class="ads_show_status"  value="5">');
                  $('.adstime_url').attr('src', normal_videos);

                  $(".plyr__controls__item").css("display", "block");
                  $(".plyr__volume").removeAttr("style");
                  

                  document.getElementById('videoPlayer').addEventListener('loadedmetadata', function() {
                      this.currentTime = 0;
                    }, true);

                videoId.play();
            }
          }
        });
      }

    function Ads_vies_count(){

      $.ajax({
      url: '<?php echo URL::to("admin/ads_viewcount") ;?>',
      method: 'post',
      data: 
          {
            "_token"      :  "<?php echo csrf_token(); ?>",
            advertiser_id :  <?php echo $advertiser_id ; ?> , 
            ads_id        :  <?php echo $ads_id ; ?> ,
            video_id      :  <?php echo $video->id ; ?> ,
          },
          success: (response) => {
            console.log(response);
          },
      })  
		}

</script>