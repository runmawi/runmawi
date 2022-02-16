<?php $settings = App\Setting::first();
 $user = App\User::where('id','=',1)->first(); 
 $app_setting = App\AppSetting::where('id','=',1)->first();
 $session = session()->all();

?>
<footer class=" py-4 mt-auto">
        <div class="container-fluid px-5">
            <div class="row  justify-content-between flex-column flex-sm-row">
                <div class="col-sm-3">
                    <div class="small m-0 text-white"><p>The Best Streaming Platform</p></div>
                    <div class="d-flex p-0 text-white icon mt-4">
                    <i class="fa fa-facebook" aria-hidden="true" style="padding: 0px 10px;"></i>
                    <i class="fa fa-twitter" aria-hidden="true"style="padding: 0px 10px;"></i>
                    <i class="fa fa-instagram" aria-hidden="true"style="padding: 0px 10px;"></i>
                    <i class="fa fa-linkedin" aria-hidden="true" style="padding: 0px 10px;"></i>

                </div>
                </div>
                <div class="col-sm-3 small m-0 text-white exp"><p>Explore</p>
                    <ul class="text-white p-0 mt-3">
                        <li>Home</li>
                        <li>Movies</li>
                    </ul>
                </div>
                <div class="col-sm-3 small m-0 text-white exp"><p>Company</p>
                    <ul class="text-white p-0 mt-3">
                        <li>Company</li>
                        <li>Privacy Policy</li>
                        <li>Terms & condition</li>
                        <li>Contact us</li>
                    </ul>
                </div>
                <div class="col-sm-3 small m-0 text-white"><p>Download App</p>
                    <p>Available on Play Store</p>
                    <img src="assets/img/gp.png" alt="gp" class="">
                </div>

            </div>
        </div>
    </footer>
<!--<footer class="mb-0">
         <div class="container-fluid">
            <div class="block-space">
               <div class="row align-items-center">
                   <div class="col-lg-3 col-md-4 col-sm-12 r-mt-15">
                       <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" alt="<?php echo $settings->website_name; ?>"> </a>
                     <div class="d-flex mt-2">
                       <?php if(!empty($settings->facebook_page_id)){?>
                        <a href="<?php echo $settings->facebook_page_id; ?>" target="_blank"  class="s-icon">
                        <i class="ri-facebook-fill"></i>
                        </a>
                        <?php } ?>
                        <?php  if(!empty($settings->skype_page_id)){?>
                        <a href=" <?php echo $settings->skype_page_id; ?>" class="s-icon">
                        <i class="ri-skype-fill"></i>
                        </a>
                        <?php } ?>
                        <?php   if(!empty($settings->instagram_page_id)){?>
                        <a href="<?php echo $settings->instagram_page_id; ?>" class="s-icon">
                        <i class="fa fa-instagram"></i>
                        </a>
                        <?php } ?>
                        <?php  if(!empty($settings->twitter_page_id)){?>
                        <a href="<?php echo $settings->twitter_page_id; ?>" class="s-icon">
                        <i class="fa fa-twitter"></i>
                        </a>
                        <?php } ?>
                        <?php if(!empty($settings->linkedin_page_id)){?>
                        <a href="<?php echo $settings->linkedin_page_id; ?>" class="s-icon">
                        <i class="ri-linkedin-fill"></i>
                        </a>
                        <?php } ?>
                        <?php if(!empty($settings->whatsapp_page_id)){ ?>
                        <a href="<?php echo $settings->whatsapp_page_id; ?>" class="s-icon">
                        <i class="ri-whatsapp-fill"></i>
                        </a>
                        <?php } ?>
                        <?php if(!empty($settings->youtube_page_id)){ ?>
                        <a href="<?php echo $settings->youtube_page_id; ?>" class="s-icon">
                        <i class="fa fa-youtube"></i>
                        </a>
                        <?php } ?>
                        <?php if(!empty($settings->google_page_id)){ ?>
                        <a href="<?php echo $settings->google_page_id; ?>" class="s-icon">
                        <i class="fa fa-google-plus"></i>
                        </a>
                        <?php } ?>
                        
                        <?php if(!empty($app_setting->android_url) || !empty($app_setting->ios_url)){ ?>
                          <!-- <label for="">Mobile App</label> -->
                        <?php } ?>
                        <?php if(!empty($app_setting->android_url)){ ?>
                        <a href="<?php echo$app_setting->android_url; ?>" class="s-icon">
                        <i class="fa fa-android"></i>
                        </a>
                        <?php } ?>
                        <?php if(!empty($app_setting->ios_url)){ ?>
                        <a href="<?php echo$app_setting->android_url; ?>" class="s-icon">
                        <i class="fa fa-apple"></i>
                        </a>
                        <?php } ?>
                        <!-- //  <a href="https://www.google.com/<?php //echo GoogleId();?>" target="_blank" class="s-icon">
                        // <i class="fa fa-google-plus"></i>
                        // </a> 
                     </div>
                  </div>
                  
                  <div class="col-lg-3 col-md-4 col-sm-12 p-0">
                     <ul class="f-link list-unstyled mb-0">
                        <!-- <li><a href="<?php echo URL::to('home') ?>">Movies</a></li> -->
                        <!-- <li><a href="<?php echo URL::to('tv-shows') ?>">Tv Shows</a></li> -->
                        <!-- <li><a href="<?php echo URL::to('home') ?>">Coporate Information</a></li>
                        <?php if($user->package == 'Pro' && empty($session['password_hash']) || empty($session['password_hash']) ){ ?> 
                          <li><a href="<?php echo URL::to('/cpp/signup') ;?>">Content Partner Portal</a></li>
                          <li><a href="<?php echo URL::to('/advertiser/register') ;?>">Advertiser Portal</a></li>
                        <?php }else{ }?>
                     </ul>
                  </div>
                  <!--<div class="col-lg-3 col-md-4">
                     <ul class="f-link list-unstyled mb-0">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Help</a></li>
                     </ul>
                  </div>
                  <?php $video_category = App\VideoCategory::where('footer',1)->get(); ?>
                  <div class="col-lg-3 col-md-4">
                      <div class="row">

                     <ul class="f-link list-unstyled mb-0 catag">
                     <?php foreach($video_category as $key => $category) { ?>
                        <li><a href="<?php echo  URL::to('category').'/'.$category->slug ;?>"><?php echo $category->name ;?></a></li>
                        <?php } ?>
                          </ul>
                          <ul class="f-link list-unstyled mb-0">
                        
                         <!-- <li><a href="<?php echo URL::to('category/horror'); ?>">Horror</a></li>
                         <li><a href="<?php echo URL::to('category/mystery'); ?>">Mystery</a></li>
                         <li><a href="<?php echo URL::to('category/Romance'); ?>">Romance</a></li> 
                          </ul>
                      </div>
				</div>
                   <div class="col-lg-3 col-md-4 p-0">
                      <ul class="f-link list-unstyled mb-0">    
						<?php 
                        $pages = App\Page::all();
                        foreach($pages as $page): ?>
							<li><a href="<?php echo URL::to('page'); ?><?= '/' . $page->slug ?>"><?= __($page->title) ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
                  
                   </div>
               </div>
            </div>-->
         <div class="copyright py-2">
            <div class="container-fluid">
               <p class="mb-0 text-center font-size-14 text-body" style="color:#fff!important;"><?php echo $settings->website_name ; ?> - 2021 All Rights Reserved</p>
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
      //alert(query);
      // alert(query);
       if (query !=''){
      $.ajax({
        url:"<?php echo URL::to('/search');?>",
        type:"GET",
        data:{
          'country':query}
        ,
        success:function (data) {
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


 <script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>
 <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
          

 <script src="plyr-plugin-capture.js"></script>
 <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/plyr-plugin-capture.js';?>"></script>
 <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
      <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
 <script>
    var type = $('#video_type').val();

   if(type != ""){
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
}

        });
   }
else{
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
  } else {
    // default options with no quality update in case Hls is not supported
    const player = new Plyr(video, defaultOptions);
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
</body>
</html>
