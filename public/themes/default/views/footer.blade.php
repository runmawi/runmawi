<?php $settings = App\Setting::first(); 
       use Carbon\Carbon;
       $user = App\User::where('id','=',1)->first(); 
       $app_setting = App\AppSetting::where('id','=',1)->where('status','hidden')->first();
       $session = session()->all();
?>
<footer class="mb-0">
         <div class="container-fluid">
            <div class="block-space">
               <div class="row justify-content-between">
                   <div class="col-lg-4 col-md-4 col-sm-12 r-mt-15">
                       <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" alt="Flicknexs"> </a>
                     <div class="d-flex mt-2">

                      <?php if(!empty($settings->facebook_page_id)){?>
                        <a href="https://www.facebook.com/<?php echo FacebookId();?>" target="_blank"  class="s-icon">
                          <i class="ri-facebook-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->skype_page_id)){?>
                        <a href="https://www.skype.com/en/<?php echo SkypeId();?>" target="_blank"  class="s-icon">
                          <i class="ri-skype-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->twitter_page_id)){?>
                        <a href="https://twitter.com/<?php echo TwiterId();?>" target="_blank"  class="s-icon">
                          <i class="ri-twitter-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->instagram_page_id)){?>
                        <a href="https://www.instagram.com/<?php echo InstagramId();?>" target="_blank"  class="s-icon">
                          <i class="ri-instagram-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->linkedin_page_id)){?>
                        <a href="https://www.linkedin.com/<?php echo linkedinId();?>" target="_blank"  class="s-icon">
                          <i class="ri-linkedin-fill"></i>
                          </a>
                      <?php } ?>


                      <?php if(!empty($settings->whatsapp_page_id)){?>
                        <a href="https://www.whatsapp.com/<?php echo YoutubeId();?>" target="_blank"  class="s-icon">
                          <i class="ri-whatsapp-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->youtube_page_id)){?>
                        <a href="https://www.youtube.com/<?php echo YoutubeId();?>" target="_blank"  class="s-icon">
                          <i class="ri-youtube-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->google_page_id)){?>
                        <a href="https://www.google.com/<?php echo GoogleId();?>" target="_blank" class="s-icon">
                          <i class="fa fa-google-plus"></i>
                          </a>
                      <?php } ?>

                     </div>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-12 p-0">
                     <ul class="f-link list-unstyled mb-0">

                        <?php
                        if(1 == 2){
                            $language = App\Language::get();
                            foreach($language as $key => $lan){
                              $language_href = 'language/'.$lan->id.'/'.$lan->name;
                        ?>
                        <li><a href="<?php echo URL::to($language_href) ?>"><?php echo $lan->name; ?> </a></li>

                        <?php }}?>

                        <?php $column2_footer = App\FooterLink::where('column_position',2)->orderBy('order')->get();  
                          foreach ($column2_footer as $key => $footer_link){ ?>

                            <li><a href="<?php echo URL::to('/'.$footer_link->link) ?>">
                                    <?php echo  $footer_link->name ; ?>
                                </a>
                            </li>
                        
                        <?php  } ?>

                        <?php if($user->package == 'Pro' && empty($session['password_hash']) || empty($session['password_hash']) ){ ?> 
                          <li><a href="<?php echo URL::to('/cpp/signup') ;?>">Content Partner Portal</a></li>
                          <li><a href="<?php echo URL::to('/advertiser/register') ;?>">Advertiser Portal</a></li>
                          <li><a href="<?php echo URL::to('/channel/register') ;?>">Channel Portal</a></li>

                        <?php }else{ }?>
                     </ul>
                  </div>                  
                 
                      
                    
				<!-- </div> -->
                  <div class="col-lg-2 col-md-4 p-0">
                      <ul class="f-link list-unstyled mb-0">

                        <?php $column3_footer = App\FooterLink::where('column_position',3)->orderBy('order')->get();  
                        foreach ($column3_footer as $key => $footer_link){ ?>
                          <li><a href="<?php echo URL::to('/'.$footer_link->link) ?>">
                                  <?php echo  $footer_link->name ; ?>
                              </a>
                          </li>
                        <?php  } ?>
                         
				              </ul>
			            </div>

                   <div class="col-lg-3 col-md-2 p-0">
                       <div >
                       <img class="" height="80" width="140" src="<?php echo  URL::to('/assets/img/apps1.png')?>" style="margin-top:-20px;">
                       <img class="" height="80" width="140" src="<?php echo  URL::to('/assets/img/apps.png')?>" style="margin-top:-20px;">
                       <img class="" height="100" width="150" src="<?php echo  URL::to('/assets/img/and.png')?>" style="margin-top:-20px;">
                   </div></div>
                  
                   </div>
               </div>
            </div>
         <div class="copyright py-2">
            <div class="container-fluid">
               <p class="mb-0 text-center font-size-14 text-body bb"><?php echo $settings->website_name ; ?> - <?php echo Carbon::now()->year ; ?> All Rights Reserved</p>
            </div>
         </div>
      </footer>

           <!-- back-to-top End -->
     <!-- back-to-top End -->
      <!-- jQuery, Popper JS -->
      <script src="<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>
      <script src="<?= URL::to('/'). '/assets/js/popper.min.js';?>"></script>
      <!-- Bootstrap JS -->
      <script src="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>"></script>
      <!-- Slick JS -->
      <script src="<?= URL::to('/'). '/assets/js/slick.min.js';?>"></script>
      <!-- owl carousel Js -->
      <script src="<?= URL::to('/'). '/assets/js/owl.carousel.min.js';?>"></script>
      <!-- select2 Js -->
      <script src="<?= URL::to('/'). '/assets/js/select2.min.js';?>"></script>
      <!-- Magnific Popup-->
      <script src="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <script src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <script src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>
       <script>
    $(document).ready(function () {
      $(".thumb-cont").hide();
      $(".show-details-button").on("click", function () {
        var idval = $(this).attr("data-id");
        $(".thumb-cont").hide();
        $("#" + idval).show();
      });
		$(".closewin").on("click", function () {
        var idval = $(this).attr("data-id");
        $(".thumb-cont").hide();
        $("#" + idval).hide();
      });
    });
  </script>
<script>
function about(evt , id) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    
  }
	
  document.getElementById(id).style.display = "block";
 
}
// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>

<script type="text/javascript">
  $(document).ready(function () {
    $('.searches').on('keyup',function() {
      var query = $(this).val();
      
       if (query !=''){
      $.ajax({
        url:"<?php echo URL::to('/search');?>",
        type:"GET",
        data:{
          'country':query}
        ,
        success:function (data) {
          $(".home-search").hide();
          $('.search_list').html(data);
        }
      }
            )
       } else {
            $('.search_list').html("");
       }
    }
                     );
    $(document).on('click', 'li', function(){
      var value = $(this).text();
      $('.search').val(value);
      $('.search_list').html("");
      $(".home-search").show();

    }
                  );
  }
                   );
</script>
<!--<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>-->

<script src="https://afarkas.github.io/lazysizes/plugins/bgset/ls.bgset.min.js"></script>
<script src="https://afarkas.github.io/lazysizes/lazysizes.min.js"></script>
 <script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>
 <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
          

 <script src="plyr-plugin-capture.js"></script>
 <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/plyr-plugin-capture.js';?>"></script>
 <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
      <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
<script>
    function loadJS(u) {
        var r = document.getElementsByTagName("script")[0],
            s = document.createElement("script");
        s.src = u;
        r.parentNode.insertBefore(s, r);
    }

    if (!window.HTMLPictureElement) {
    loadJS("https://afarkas.github.io/lazysizes/plugins/respimg/ls.respimg.min.js");
    }
</script>

<scrip>
  
</scrip>
      <script>
    var type = $('#video_type').val();
    // var type = $('#hls_m3u8').val();
    var request_url = $('#request_url').val();
    var live = $('live').val();
    // var live = $('live').val();
    var video_video = $('video_video').val();
    var user_logged_out =  $('#user_logged_out').val();
    var hls =  $('#hls').val();
    var ads_path_tag =  $('#ads_path_tag').val();
    var processed_low =  $('#processed_low').val();
    // alert(ads_path_tag)


    // alert(ads_path_tag);
    // alert(user_logged_out)


   if(type != "" &&  video_video == 'video'){
    // alert('video_video')

        const player = new Plyr('#videoPlayer',{
          controls: ['play-large',
                      'restart',
                      'rewind',
                      'play',
                      'fast-forward',
                      'progress',
                      'current-time',
                      'mute',
                      'volume',
                      'captions',
                      'settings',
                      'pip',
                      'airplay',
                      'fullscreen',
                      'capture'
		                ],
              i18n:{
                   capture: 'capture'
              },

              ads:{ 
                      enabled: true, 
                      publisherId: '', 
                      tagUrl: ads_path_tag 
                    }
        });
   }else if(type != "" && request_url != 'm3u8'){
    // alert('m3u8')

        const player = new Plyr('#videoPlayer',{
          controls: [

      'play-large',
			'restart',
			'rewind',
			'play',
			'fast-forward',
			'progress',
			'current-time',
			'mute',
			'volume',
			'captions',
			'settings',
			'pip',
			'airplay',
			'fullscreen',
			'capture'
		],
    i18n:{
    // your other i18n
    capture: 'capture'
},
                ads:{ 
                      enabled: true, 
                      publisherId: '', 
                      tagUrl: ads_path_tag 
                    }
        });
   }
  else if(user_logged_out == 1 && type == '' && processed_low != 100 || user_logged_out == 1 && type == '' && processed_low == ""){
        const player = new Plyr('#videoPlayer',{
          controls: [

      'play-large',
			'restart',
			'rewind',
			'play',
			'fast-forward',
			'progress',
			'current-time',
			'mute',
			'volume',
			'captions',
			'settings',
			'pip',
			'airplay',
			'fullscreen',
			'capture'
		],
    i18n:{
    // your other i18n
    capture: 'capture'
},
                  ads:{ 
                      enabled: true, 
                      publisherId: '', 
                      tagUrl: ads_path_tag 
                    }
        });
   }
   else if(hls == "hls"){
     
        const player = new Plyr('#videoPlayer',{
          controls: [  'play-large',
                      'restart',
                      'rewind',
                      'play',
                      'fast-forward',
                      'progress',
                      'current-time',
                      'mute',
                      'volume',
                      'captions',
                      'settings',
                      'pip',
                      'airplay',
                      'fullscreen',
                      'capture'],
          i18n:{
                capture: 'capture'
              },

          ads:{ 
                  enabled: true, 
                  publisherId: '', 
                  tagUrl: ads_path_tag 
                }
        });
   }
else{
// alert();
          document.addEventListener("DOMContentLoaded", () => {
  const video = document.querySelector("video");
  const source = video.getElementsByTagName("source")[0].src;
  
  // For more options see: https://github.com/sampotts/plyr/#options
  // captions.update is required for captions to work with hls.js
  const defaultOptions = {};

  if (Hls.isSupported()) {
    // For more Hls.js options, see https://github.com/dailymotion/hls.js
    const hls = new Hls();
    hls.loadSource(source);

    // From the m3u8 playlist, hls parses the manifest and returns
    // all available video qualities. This is important, in this approach,
    // we will have one source on the Plyr player.
    hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      // Transform available levels into an array of integers (height values).
      const availableQualities = hls.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(video, defaultOptions);
    });
    hls.attachMedia(video);
    window.hls = hls;


    $(window).on("beforeunload", function() { 

var vid = document.getElementById("video");
  var currentTime = vid.currentTime;
  var duration = vid.duration;
var bufferedTimeRanges = vid.buffered;
var bufferedTimeRangesLength = bufferedTimeRanges.length;
var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
  // var videotype= '<? //$video->type ?>';
  var videotype= $('#video_type').val();

  var videoid = $('#video_id').val();
  $.post('<?= URL::to('player_analytics_store') ?>', { video_id : videoid,duration : duration,currentTime:currentTime,seekableEnd : seekableEnd,bufferedTimeRanges : bufferedTimeRangesLength,_token: '<?= csrf_token(); ?>' }, function(data){
});
return;
}); 
    
  } else {
    // default options with no quality update in case Hls is not supported
    // const player = new Plyr(video, defaultOptions);
    const player = new Plyr('#video',{
          controls: [
                    'play-large',
                    'restart',
                    'rewind',
                    'play',
                    'fast-forward',
                    'progress',
                    'current-time',
                    'mute',
                    'volume',
                    'captions',
                    'settings',
                    'pip',
                    'airplay',
                    'fullscreen',
                    'capture'
		              ],
            i18n:{
                capture: 'capture'
              },

            ads:{ 
                  enabled: true, 
                  publisherId: '', 
                  tagUrl: ads_path_tag 
                }
        });

        $(window).on("beforeunload", function() { 

var vid = document.getElementById("video");
  var currentTime = vid.currentTime;
  var duration = vid.duration;
var bufferedTimeRanges = vid.buffered;
var bufferedTimeRangesLength = bufferedTimeRanges.length;
var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
  // var videotype= '<? //$video->type ?>';
  var videotype= $('#video_type').val();
  
  var videoid = $('#video_id').val();
  $.post('<?= URL::to('player_analytics_store') ?>', { video_id : videoid,duration : duration,currentTime:currentTime,seekableEnd : seekableEnd,bufferedTimeRanges : bufferedTimeRangesLength,_token: '<?= csrf_token(); ?>' }, function(data){
});
return;
}); 
  }

  function updateQuality(newQuality) {
    window.hls.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hls.currentLevel = levelIndex;
      }
    });
  }
});

}

      </script>
<script>
  if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
      img.src = img.dataset.src;
    });
  } else {
    // Dynamically import the LazySizes library
    const script = document.createElement('script');
    script.src =
      'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
    document.body.appendChild(script);
  }
</script>



<?php   $Prevent_inspect = App\SiteTheme::pluck('prevent_inspect')->first();
if( $Prevent_inspect == 1){
?>

<script>
        $(document).keydown(function (event) {
            if (event.keyCode == 123) { // Prevent F12
                alert("This function has been disabled");
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I 
              alert("This function has been disabled ");       
                return false;
            }
        });

        $(document).on("contextmenu", function (e) {        
            alert("This function has been disabled");
            e.preventDefault();
        });
</script>

<?php } ?>



 
</body>
</html>
