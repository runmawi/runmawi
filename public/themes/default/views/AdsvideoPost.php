
<?php 

$current_time = Carbon\Carbon::now()->format('H:i:s');

$post_tyming =App\PlayerAnalytic::where('videoid',$video->id)->groupBy('videoid')
->orderBy('created_at', 'desc')->pluck('duration')->first();

$post_tym = $post_tyming - 5 ;


$AdsVideosPost = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
  ->Join('videos','advertisements.ads_category','=','videos.ads_category')
  ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
  // ->whereTime('start', '<=', $current_time)
  // ->whereTime('end', '>=', $current_time)
  ->where('ads_events.status',1)
  ->where('advertisements.status',10)
  ->where('advertisements.ads_position','post')
  ->where('videos.ads_category',$video->ads_category)
  ->get();


  if( count($AdsVideosPost) >= 1){
    $AdsVideossPost = $AdsVideosPost->random();

    $AdsvideoFilePost = URL::to('public/uploads/AdsVideos/'.$AdsVideossPost->ads_video);

    if($AdsVideossPost->ads_video != null ){

      $getID3               = new getID3;
      $Ads_store_path_Post   = public_path('/uploads/AdsVideos/'.$AdsVideossPost->ads_video);       
      $Ads_duration_Post     = $getID3->analyze($Ads_store_path_Post);
      $Ads_duration_Sec_Post = $Ads_duration_Post['playtime_seconds'];
      $ads_path_tag          = null ;
      
    }else{
      $Ads_duration_Sec_Post = null;
      $ads_path_tag     = $AdsVideossPost->ads_path ;
    }
    
    $advertiser_id_Post    =  $AdsVideossPost->advertiser_id ; 
    $ads_id_Post           =  $AdsVideossPost->ads_id ;
    $ads_position_Post     =  $AdsVideossPost->ads_position ;
    $ads_path_tag         =  $AdsVideossPost->ads_path;
    $ads_type_Post         =  $AdsVideossPost->ads_video ;
  }else{

    $AdsvideoFilePost        = null ;
    $Ads_duration_Sec_Post  = null ;
    $advertiser_id_Post   =  null ; 
    $ads_id_Post          =  null ; 
    $ads_position_Post    =  null ;
    $ads_path_tag        =  null ;
    $ads_type_Post         =  null ;

  }


  if( $ads_position_Post !=null && $ads_position_Post == 'post'){

      $ads_start_tym_Post = $post_tym;

  }else{
      $ads_start_tym_Post = ' ';
  }

$normalvideoFilePost =  URL::to('storage/app/public/'.$video->path);

?>

<input type="hidden" id="ads_start_tym_Post" class="ads_start_tym_Post"  value='<?php  echo $ads_start_tym_Post  ; ?>'>
<input type="hidden" id="" class="ads_show_status_Post"  value='1'>
<input type="hidden" id="Ads_vies_count_Post" onclick="Ads_vies_count()"> 

<script>

var videoads_tym_Post    =  document.getElementById(videotypeId);
var Ads_videos_Post      = <?php echo json_encode($AdsvideoFilePost)  ;?>;
var normal_videos_Post   = <?php  echo json_encode($normalvideoFilePost)  ;?>;
var ads_end_tym_Post     =  <?php  echo json_encode($Ads_duration_Sec_Post)  ;?>;
var Ads_count_Post       = <?php echo count($AdsVideosPost); ?> ;
var Ads_type_Post        = <?php echo json_encode($ads_type_Post); ?> ;
var post_tym             = <?php echo json_encode($post_tym); ?> ;
var ads_post_videoplayer_id  = <?php echo json_encode($video_type_id); ?> ;


if( Ads_count_Post >= 1 &&  Ads_type_Post != null ){

this.videoads_tym_Post.addEventListener('timeupdate', (e) => {

      var ads_start_tym_Post   =  $('.ads_start_tym_Post').val();
      var ads_show_status_Post  = $('.ads_show_status_Post').val();

        if (ads_start_tym_Post <= e.target.currentTime) {

        if(ads_show_status_Post == 1){
          
              $('.adstime_url').attr('src', Ads_videos_Post);

                document.getElementById(ads_post_videoplayer_id).addEventListener('loadedmetadata', function() {
                    this.currentTime = 0;
                }, true);

               videoId.play();
                $('#ads_start_tym_Post').replaceWith('<input type="hidden" id="ads_start_tym_Post" class="ads_start_tym_Post" value="'+ ads_end_tym_Post+'">');
                $('.ads_show_status_Post').replaceWith('<input type="hidden" id="" class="ads_show_status_Post"  value="0">');
                document.getElementById("Ads_vies_count_Post").click();
              
                $(".plyr__controls__item ").css("display", "none");
                $(".plyr__time ").css("display", "block");
          }
          else if(ads_show_status_Post == 0){
                $('.ads_show_status_Post').replaceWith('<input type="hidden" id="" class="ads_show_status_Post"  value="5">');
                $('.adstime_url').attr('src', normal_videos_Post);

                $(".plyr__controls__item").css("display", "block");
                $(".plyr__volume").removeAttr("style");

                document.getElementById(ads_post_videoplayer_id).addEventListener('loadedmetadata', function() {
                    this.currentTime = post_tym;
                  }, true);


              videoId.play();
          }
        }
      });
    }

  function Ads_vies_count_Post(){

    $.ajax({
    url: '<?php echo URL::to("admin/ads_viewcount_Post") ;?>',
    method: 'post',
    data: 
        {
          "_token"      :  "<?php echo csrf_token(); ?>",
          advertiser_id :  <?php echo $advertiser_id_Post ; ?> , 
          ads_id        :  <?php echo $ads_id_Post ; ?> ,
          video_id      :  <?php echo $video->id ; ?> ,
        },
        success: (response) => {
          console.log(response);
        },
    })  
  }

</script>
