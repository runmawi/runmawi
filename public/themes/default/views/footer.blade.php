<?php

  use Carbon\Carbon;

  $settings = App\Setting::first();
  $user    = App\User::where('id',1)->first();
  $app_setting = App\AppSetting::where('id',1)->where('status','hidden')->first();
  $session = session()->all();

  $css = App\Css::pluck('custom_css')->toArray();

  $theme = App\SiteTheme::first();
  $theme_mode = $theme->theme_mode;
  $videocipher = $theme->enable_video_cipher_upload;
?>

<footer class="py-4 mt-5">
  <div class="container-fluid px-5 mt-5">
     <!-- <p class="text-white text-center mb-4">Chat-box will be sent later.</p>-->
      <div class="row justify-content-center align-items-center">

          <div class="down-apps col-lg-12 d-flex align-items-center justify-content-center">
          <?php $app_settings = App\AppSetting::where('id','=',1)->first(); ?>

          <?php if(!empty($app_settings->android_url) || !empty($app_settings->ios_url) || !empty($app_settings->android_tv)){ ?>
              <p class="font-weight-bold mb-0"><?php echo (__('Download App')); ?></p>
          <?php } ?>

          <div class=" small m-0 text-white ">
             <div class="map1 ml-3">
              <?php if(!empty($app_settings->android_url)){ ?>
                <a href="<?= $app_settings->android_url ?>" aria-label="Download the Android app"><img class="lazy" height="60" width="150" style="object-fit:contain;" data-src="<?php echo  URL::to('/assets/img/android.webp')?>" src="<?php echo  URL::to('/assets/img/android.webp')?>" alt="android" /></a>
              <?php } ?>
              <?php if(!empty($app_settings->ios_url)){ ?>
                 <a href="<?= $app_settings->ios_url ?>" aria-label="Download the Ios app"><img class="lazy" height="60" width="150" style="object-fit:contain;" data-src="<?php echo  URL::to('/assets/img/ios.webp')?>" src="<?php echo  URL::to('/assets/img/ios.webp')?>" alt="ios" /></a>
              <?php } ?>
              <?php if(!empty($app_settings->android_tv)){ ?>
                  <a href="<?= $app_settings->android_tv ?>" aria-label="Download the Androidtv app">
                      <img class="lazy" height="60" width="150" style="object-fit:contain;" data-src="<?php echo  URL::to('/assets/img/android-tv-1.webp')?>" src="<?php echo  URL::to('/assets/img/android-tv-1.webp')?>" alt="android-tv" /></a>
              <?php } ?>
              <?php if(!empty($app_settings->Firetv_url)){ ?>
                  <a href="<?= $app_settings->Firetv_url ?>" aria-label="Download the firetv app">
                      <img class="lazy" height="60"  width="150" style="object-fit:contain;" data-src="<?php echo  URL::to('/assets/img/firetv-1.webp')?>" src="<?php echo  URL::to('/assets/img/firetv-1.webp')?>" alt="firetv" /></a>
              <?php } ?>
              <?php if(!empty($app_settings->samsungtv_url)){ ?>
                  <a href="<?= $app_settings->samsungtv_url ?>" aria-label="Download the samsung app">
                      <img class="lazy" height="60" width="150" style="object-fit:contain;" data-src="<?php echo  URL::to('/assets/img/samsng.webp')?>" src="<?php echo  URL::to('/assets/img/samsng.webp')?>" alt="samsng" /></a>
              <?php } ?>
              <?php if(!empty($app_settings->Lgtv_url)){ ?>
                  <a href="<?= $app_settings->Lgtv_url ?>" aria-label="Download the lgtv app">
                      <img class="lazy" height="60" width="150" style="object-fit:contain;" data-src="<?php echo  URL::to('/assets/img/lg.webp')?>" src="<?php echo  URL::to('/assets/img/lg.webp')?>" alt="lg" /></a>
              <?php } ?>
              <?php if(!empty($app_settings->Rokutv_url)){ ?>
                  <a href="<?= $app_settings->Rokutv_url ?>" aria-label="Download the rokutv app">
                      <img class="lazy" height="60" width="150" style="object-fit:contain;" data-src="<?php echo  URL::to('/assets/img/roku-1.webp')?>" src="<?php echo  URL::to('/assets/img/roku-1.webp')?>" alt="roku" /></a>
              <?php } ?>
              </div>

          </div>
          </div>
      </div>


      <div class="row  justify-content-center mb-3">
          <div class="col-sm-3. small m-0 text-white text-right">
               <div class="map1" style="height: 40px;">
                    <div class="d-flex p-0 text-white icon align-items-baseline bmk">
                      <p><?php echo (__('Follow us')) .' :'; ?> </p>
                           <?php if(!empty($settings->instagram_page_id)){?>
                      <a href="https://www.instagram.com/<?php echo InstagramId();?>" aria-label="Instagram" target="_blank" class="ml-2">
                          <img class="lazy" width="40" height="40" data-src="<?php echo  URL::to('/assets/img/lan/inst.webp')?>" src="<?php echo  URL::to('/assets/img/lan/inst.webp')?>" alt="inst" loading="lazy"  />
                      </a>
                      <?php } ?>
                         <?php if(!empty($settings->twitter_page_id)){?>
                      <a href="https://twitter.com/<?php echo TwiterId();?>" aria-label="twitter" target="_blank" class="ml-2">
                          <img class="lazy" width="40" height="40" data-src="<?php echo  URL::to('/assets/img/lan/twitter-x.webp')?>" src="<?php echo  URL::to('/assets/img/lan/twitter-x.webp')?>" alt="t" loading="lazy"  />
                      </a>
                      <?php } ?>
                      <?php if(!empty($settings->facebook_page_id)){?>
                      <a href="https://www.facebook.com/<?php echo FacebookId();?>" aria-label="facebook" target="_blank" class="ml-2">
                          <img class="lazy" width="40" height="40" src="<?php echo  URL::to('/assets/img/lan/fb.webp')?>" data-src="<?php echo  URL::to('/assets/img/lan/fb.webp')?>" alt="fb" loading="lazy"  />
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->skype_page_id)){?>
                      <a href="https://www.skype.com/en/<?php echo SkypeId();?>" aria-label="skype" target="_blank" class="ml-2">
                          <i class="fa fa-skype"></i>
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->linkedin_page_id)){?>
                      <a href="https://www.linkedin.com/<?php echo linkedinId();?>" aria-label="linkedin" target="_blank" class="ml-2">
                          <img class="lazy" width="40" height="40" data-src="<?php echo  URL::to('/assets/img/link.webp')?>" src="<?php echo  URL::to('/assets/img/link.webp')?>" alt="link" loading="lazy"  />
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->whatsapp_page_id)){?>
                     <!-- <a href="https://www.whatsapp.com/<?php echo YoutubeId();?>" target="_blank" class="">
                          <i class="fa fa-whatsapp"></i>
                      </a>-->
                      <?php } ?>

                      <?php if(!empty($settings->youtube_page_id)){?>
                      <a href="https://www.youtube.com/<?php echo YoutubeId();?>" aria-label="youtube" target="_blank" class="ml-2">
                          <img class="lazy" width="40" height="40" data-src="<?php echo  URL::to('/assets/img/lan/youtube.webp')?>" src="<?php echo  URL::to('/assets/img/lan/youtube.webp')?>" alt="youtube" loading="lazy"  />
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->google_page_id)){?>
                      <!--<a href="https://www.google.com/<?php echo GoogleId();?>" target="_blank" class="ml-1">
                          <i class="fa fa-google-plus"></i>
                      </a>-->
                      <?php } ?>

                      <?php if(!empty($settings->tiktok_page_id)){?>
                        <a href="https://www.tiktok.com/<?php echo $settings->tiktok_page_id;?>" aria-label="tiktok" target="_blank" class="ml-2">
                          <img class="lazy" width="40" height="40" data-src="<?php echo  URL::to('/assets/img/lan/tiktok.webp')?>" src="<?php echo  URL::to('/assets/img/lan/tiktok.webp')?>" alt="tiktok" loading="lazy"  />
                        </a>
                        <?php } ?>

                  </div>

              </div>

          </div>

      </div>

  </div>

  <div class="container-fluid">
      <div class="footer_links_container text-center">
          <?php
              $cmspages = App\Page::where('footer_active', 1)->get();
              foreach ($cmspages as $page) { ?>
                  <a href="<?= URL::to(($page->slug == 'contact-us') ? '/'.$page->slug : 'page/'.$page->slug ) ?>"
                    target="_blank"
                    class="ml-1 footer_link">
                    <?= __($page->title) ?>
                  </a>
          <?php } ?>
      </div>
  </div>
</footer>
      <link rel="preload" href="<?= URL::to('assets/js/jquery.3.4.1.js') ?>" as="script">
      <script src="<?= URL::to('assets/js/jquery.3.4.1.js') ?>"></script>
      <script  src="<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>
      <script  src="<?= URL::to('/'). '/assets/js/jquery.lazy.min.js';?>"></script>
      <!-- Popper js -->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/popper.min.js';?>" as="script">
      <script  src="<?= URL::to('/'). '/assets/js/popper.min.js';?>"></script>
      <!-- Bootstrap JS -->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>" as="script">
      <script src="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>"></script>
      <!-- select2 Js -->
      <script defer src="<?= URL::to('/'). '/assets/js/select2.min.js';?>"></script>
      <!-- Magnific Popup-->
      <script defer src="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Custom JS-->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/custom.js';?>" as="script">
      <script  src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>

      <link rel="preload" href="<?= URL::to('/'). '/assets/admin/dashassets/js/google_analytics_tracking_id.js';?>" as="script">
      <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/google_analytics_tracking_id.js';?>"></script>


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
</script>

<?php  $search_dropdown_setting = $theme->search_dropdown_setting ; ?>
<input type="hidden" value="<?= $search_dropdown_setting ?>" id="search_dropdown_setting" >

<script type="text/javascript">

  $(document).ready(function () {

    $('.searches').on('keyup',function() {
      var query = $(this).val();

       if (query !=''){

          $.ajax({
          url:"<?php echo URL::to('/search');?>",
          type:"GET",
          data:{
                'country':query
              },
            success:function (data) {
              $(".home-search").hide();
              $('.search_list').html(data);
            }
          })
       } else {
            $('.search_list').html("");
       }
    });

    $(document).on('click', 'li', function(){

      var value = $(this).text();
      let search_dropdown_setting = $('#search_dropdown_setting').val() ;

      $('.search').val(value);
      $('.search_list').html("");

      if( search_dropdown_setting == 1 ){
        $(".home-search").show();
      }else{
        $(".home-search").hide();
      }
    });
  });

</script>

<?php
      $footer_script = App\Script::pluck('footer_script')->toArray();
      if(count($footer_script) > 0){
        foreach($footer_script as $Scriptfooter){ ?>
        <!-- // echo $Scriptfooter; -->
        <?= $Scriptfooter ?>

      <?php }
    }
     ?>

<?php
  if(count($css) > 0){
    foreach($css as $customCss){   ?>
        <?= $customCss ?>
    <?php }
  } 
?>
 <script async src="<?= URL::to('/'). '/assets/js/ls.bgset.min.js';?>"></script>
 <script async src="<?= URL::to('/'). '/assets/js/plyr.polyfilled.js';?>"></script>

 <?php if( $videocipher == 0) { ?>

 <script async src="<?= URL::to('/'). '/assets/js/hls.min.js';?>"></script>
 <script async src="<?= URL::to('/'). '/assets/js/hls.js.map';?>"></script>

 <script>
    function loadScriptWithTimeout(url, timeout = 50000) {
      return new Promise((resolve, reject) => {
          const script = document.createElement('script');
          script.src = url;

          const timer = setTimeout(() => {
              reject(new Error(`Timed out while loading ${url}`));
              script.remove();
          }, timeout);

          script.onload = () => {
              clearTimeout(timer);
              resolve();
          };

          script.onerror = () => {
              clearTimeout(timer);
              reject(new Error(`Failed to load ${url}`));
          };

          document.body.appendChild(script);
      });
  }

  // Specify the URL for your hls.min.js file
  const hlsJsUrl = "<?= URL::to('/'). '/assets/js/hls.js';?>";
  const timeoutMilliseconds = 50000; // Adjust timeout as needed (in milliseconds)

  // Load HLS.js with a timeout
  loadScriptWithTimeout(hlsJsUrl, timeoutMilliseconds)
      .then(() => {
          console.log(`HLS.js loaded successfully.`);
          // You can now use HLS.js functionalities safely
      })
      .catch((error) => {
          console.error(`Error loading HLS.js:`, error);
          // Handle the error (e.g., show a message to the user)
      });

 </script>
<?php } ?>

<script>
    function loadJS(u) {
        var r = document.getElementsByTagName("script")[0],
            s = document.createElement("script");
        s.src = u;
        r.parentNode.insertBefore(s, r);
    }
    // if (!window.HTMLPictureElement) {
    // loadJS("https://afarkas.github.io/lazysizes/plugins/respimg/ls.respimg.min.js");
    // }
</script>

<?php if( $videocipher == 0) { ?>
<link rel="preload" href="https://cdn.jsdelivr.net/hls.js/latest/hls.js" as="script">
<script defer src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
<?php } ?>

<?php
    try {

      if( Route::currentRouteName() == "LiveStream_play" ){
        // include(public_path('themes/default/views/video-js-Player/Livestream/live-player.blade.php'));
      }
      elseif ( Route::currentRouteName() == "play_episode"){
        include('episode_player_script.blade.php');
      }elseif( Route::currentRouteName() == "video-js-fullplayer"){
              //
      }
      else{
        include('footerPlayerScript.blade.php');
      }

    } catch (\Throwable $th) {
      //throw $th;
    }
?>

<script>
  // if ('loading' in HTMLImageElement.prototype) {
  //   const images = document.querySelectorAll('img[loading="lazy"]');
  //   images.forEach(img => {
  //     img.src = img.dataset.src;
  //   });
  // } else {
  //      const script = document.createElement('script');
  //   script.src =
  //     'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
  //   document.body.appendChild(script);
  // }
</script>
<?php
  $Prevent_inspect = $theme->prevent_inspect ;
  if( $Prevent_inspect == 1){
?>
<script>
        $(document).keydown(function (event) {
            if (event.keyCode == 123) {
                alert("This function has been disabled"); // Prevent F12
                return false;
            }
            else if(event.ctrlKey && event.shiftKey && event.keyCode == 'I'.charCodeAt(0)){
                alert("This function has been disabled ");   // Prevent Ctrl + Shift + I
                return false;
            }
            else if(event.ctrlKey && event.shiftKey && event.keyCode == 'J'.charCodeAt(0)){
                alert("This function has been disabled ");   // Prevent Ctrl + Shift + J
                return false;
            }
            else if(event.ctrlKey && event.shiftKey && event.keyCode == 'C'.charCodeAt(0)){
                alert("This function has been disabled ");   // Prevent Ctrl + Shift + c
                return false;
            }
            else if(event.ctrlKey && event.keyCode == 'U'.charCodeAt(0)){
                alert("This function has been disabled ");  // Prevent  Ctrl + U
                return false;
            }
        });

        $(document).on("contextmenu", function (e) {
            alert("This function has been disabled");
            e.preventDefault();
        });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {var lazyloadImages = document.querySelectorAll("img.lazy");var lazyloadThrottleTimeout;function lazyload () {if(lazyloadThrottleTimeout) {clearTimeout(lazyloadThrottleTimeout);}lazyloadThrottleTimeout = setTimeout(function() {var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;lazyloadImages.forEach(function(img) {if (img.offsetTop < (document.documentElement.clientHeight + scrollTop)) {img.src = img.dataset.src;img.classList.remove('lazy');}});if (lazyloadImages.length == 0) {document.removeEventListener("scroll", lazyload);document.body.removeEventListener("resize", lazyload);globalThis.matchMedia("(orientation: portrait)").removeListener(lazyload);}}, 20);}document.addEventListener("scroll", lazyload);document.body.addEventListener("resize", lazyload);globalThis.matchMedia("(orientation: portrait)").addListener(lazyload);});
</script>
<?php } ?>
  <?php if( get_image_loader() == 1) { ?>
 <script>
        const loaderEl = document.getElementsByClassName('fullpage-loader')[0];
        document.addEventListener('readystatechange', (event) => {
        const readyState = "complete";
          if(document.readyState == readyState) {
            loaderEl.classList.add('fullpage-loader--invisible');
            setTimeout(()=>{
              loaderEl.parentNode.removeChild(loaderEl);
            }, 100)
          }
        });
    </script>
<?php } ?>

<style>
  @media(max-width:720px){
    .down-apps{display:block !important;margin-bottom: 2rem;}
    .down-apps img{width:100%;}
    p.font-weight-bold.mb-0{font-size: 1.5rem;text-align: center;}
    .map1.ml-3 {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 10px; /* Adjust the gap between items */
      }

      .map1.ml3 a {
          text-align: center;
      }
  }

  .footer_links_container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        min-height: 20px;
    }

    .footer_link {
        margin: 5px;
    }



  /* Default (Dark Theme) */
  footer a,
  footer p {
      color: #fff !important; /* White text for dark theme */
  }

  /* Light Theme */
  body.light-theme footer a,
  body.light-theme footer p {
      color: #000 !important; /* Black text for light theme */
  }
  .footer_link{border-right: 2px solid #fff;padding: 0 5px;}
  .footer_link:last-child{border-right:none;}
</style>
</body>
