<?php 
  $settings = App\Setting::first();
  $user = App\User::where('id','=',1)->first(); 
  $app_setting = App\AppSetting::where('id','=',1)->where('status','hidden')->first();
  $session = session()->all();
  use Carbon\Carbon;
?>

<style>
  .store-logos {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.store-logos a {
    display: inline-block;
}

.android-logo, .ios-logo, .android-tv-logo {
    /* width: 100px;
    height: 60px; */
    background-image: url(<?php echo URL::to('/assets/img/spritesheet.webp')?>);
    background-repeat: no-repeat;
}

.android-logo {
    background-position: 0 0;
    width: 120px;
    height: 60px;
    background-size: cover;
}

.ios-logo {
    background-position: -118px 0;
    width: 120px;
    height: 60px;
    background-size: cover;
}

.android-tv-logo {
    background-position: -200px 0; /* Position of Android TV logo in sprite */
}
@media(max-width:425px){
  
  .container-fluid.px-5.mt-5{
    padding:0 !important;
  }
  h5.font-weight-bold.mb-0 {
      font-size: 12px;
  }
  footer p {
      font-size: 15px;
  }
}

</style>
<footer class="py-4 mt-auto">
  <div class="container-fluid px-5 mt-5">
     <!-- <p class="text-white text-center mb-4">Chat-box will be sent later.</p>-->
      <div class="row justify-content-center align-items-center">
         
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <?php $app_settings = App\AppSetting::where('id','=',1)->first(); ?>

            <?php if(!empty($app_settings->android_url) || !empty($app_settings->ios_url) || !empty($app_settings->android_tv)){ ?>  
                <p class="font-weight-bold mb-0  ">Download App</p>
            <?php } ?>
            <div class=" small m-0 text-white ">
              <div class="store-logos"> 
                <?php if(!empty($app_settings->android_url)){ ?>
                    <a href="<?= $app_settings->android_url ?>" aria-label="android">
                        <div class="android-logo"></div>
                    </a>
                <?php } ?>
                <?php if(!empty($app_settings->ios_url)){ ?>
                    <a href="<?= $app_settings->ios_url ?>" aria-label="ios">
                        <div class="ios-logo"></div>
                    </a>
                <?php } ?>
                <?php if(!empty($app_settings->android_tv)){ ?>
                    <div class="android-tv-logo"></div>
                <?php } ?>
            </div>

              
            <!--  <p class="p-0 mr-3 mt-3">Questions? Call 000-800-123-123</p>-->
          </div>
          </div>
      </div>
      
      
      <div class="row  justify-content-center ">
        
          <!--<div class="col-sm-7 small m-0 text-white exp p-0">
              <div class="mt-2 ">
                  <p class="nem mb-4 col-md-9" id="ikm" style="">Hours of Infotaiment 
edutainment and
entertainment.</p>
                  <ul class="d-flex p-0 wrap">
                      <li>  <a href="" target="_blank" class="">FAQ</a></li>
                      <li><a href="" target="_blank" class="">HELP</a></li>
                      <li><a href="" target="_blank" class="">ACCOUNT</a></li>
                      <li><a href="" target="_blank" class="">TERMS OF USE</a></li>
                      <li><a href="" target="_blank" class="">CONTACT US</a></li>
                  </ul>
                  <div class="small m-0 text-white"></div>
                 </div>
          </div>-->

         
          <div class="col-sm-3. small m-0 text-white text-right">
               <div class="map1">
                    <div class="d-flex p-0 text-white icon align-items-baseline bmk">
                      <p>Follow us :</p>
                           <?php if(!empty($settings->instagram_page_id)){?>
                      <a href="https://www.instagram.com/<?php echo InstagramId();?>" target="_blank" class="ml-1" aria-label="insta">
                        <img class="web-image" width="35px" height="35px" src="<?php echo URL::to('/assets/img/lan/i.webp'); ?>" alt="instagram"/>
                      </a>
                      <?php } ?>
                         <?php if(!empty($settings->twitter_page_id)){?>
                      <a href="https://twitter.com/<?php echo TwiterId();?>" target="_blank" class="ml-1" aria-label="twitter">
                          <img class="web-image" width="35px" height="35px" src="<?php echo  URL::to('/assets/img/lan/t.webp')?>" alt="twitter"/>
                      </a>
                      <?php } ?>
                      <?php if(!empty($settings->facebook_page_id)){?>
                      <a href="https://www.facebook.com/<?php echo FacebookId();?>" target="_blank" class="ml-1" aria-label="face">
                          <img class="web-image" width="35px" height="35px" src="<?php echo  URL::to('/assets/img/lan/f.webp')?>" alt="facebook" />
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->skype_page_id)){?>
                      <a href="https://www.skype.com/en/<?php echo SkypeId();?>" target="_blank" class="ml-1" aria-label="skype">
                          <i class="fa fa-skype"></i>
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->linkedin_page_id)){?>
                      <a href="https://www.linkedin.com/<?php echo linkedinId();?>" target="_blank" class="ml-1" aria-label="linkedIN">
                          <img class="web-image" width="35px" height="35px" src="<?php echo  URL::to('/assets/img/link.webp')?>" alt="linkedin"/>
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->whatsapp_page_id)){?>
                     <!-- <a href="https://www.whatsapp.com/<?php echo YoutubeId();?>" target="_blank" class="">
                          <i class="fa fa-whatsapp"></i>
                      </a>-->
                      <?php } ?>

                      <?php if(!empty($settings->youtube_page_id)){?>
                      <a href="https://www.youtube.com/<?php echo YoutubeId();?>" target="_blank" class="ml-1" aria-label="tube">
                          <img class="web-image" width="35px" height="35px" src="<?php echo  URL::to('/assets/img/lan/y.webp')?>" alt="youtube"/>
                      </a>
                      <?php } ?>

                      <?php if(!empty($settings->google_page_id)){?>
                      <!--<a href="https://www.google.com/<?php echo GoogleId();?>" target="_blank" class="ml-1">
                          <i class="fa fa-google-plus"></i>
                      </a>-->
                      <?php } ?>
                        
                  </div>
             
              </div>
                 
          </div>
         
      </div>
      
  </div>

    <div class="container-fluid">
        <p class="mb-0 text-center font-size-14 text-body" style="color: #2DB8B8 !important;">
          <?php
                    // CMS Pages
            $cmspages = App\Page::where('active', 1)->get();

            foreach($cmspages as $key => $page) {?>
              <a href="<?= URL::to('page/'.$page->slug ) ?>" target="_blank" class="ml-1"> <?= $page->title ?> </a> 
          <?php } ?>

          <?php echo $settings->website_name .' - '. Carbon::now()->year ; ?>  All Rights Reserved
        </p>
    </div>

</footer>

      <!-- jQuery, Popper JS -->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>

      <link rel="preload" href="<?= URL::to('/'). '/assets/js/popper.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/popper.min.js';?>"></script>
      <!-- Bootstrap JS -->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>"></script>
      <!-- Slick JS -->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/slick.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/slick.min.js';?>"></script>
      <!-- owl carousel Js -->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/owl.carousel.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/owl.carousel.min.js';?>"></script>
      <!-- select2 Js -->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/select2.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/select2.min.js';?>"></script>
      <!-- Magnific Popup-->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <link rel="preload" href="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>" as="script">
      <script defer src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <link rel="preload" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/js/custom.js'); ?>" as="script">
      <script defer type="text/javascript" src="<?php echo URL::to('public/themes/theme5-nemisha/assets/js/custom.js'); ?>"></script>
      
      <link rel="preload" href="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" as="script">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <?php 
      $footer_script = App\Script::pluck('footer_script')->toArray();
      if(count($footer_script) > 0){
        foreach($footer_script as $Scriptfooter){ ?>
        <?= $Scriptfooter ?>

      <?php } 
    }
     ?>
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

<link rel="preload" href="<?= URL::to('/'). '/assets/js/ls.bgset.min.js';?>" as="script">
<script defer src="<?= URL::to('/'). '/assets/js/ls.bgset.min.js';?>"></script>

<link rel="preload" href="<?= URL::to('/'). '/assets/js/lazysizes.min.js';?>" as="script">
<script defer src="<?= URL::to('/'). '/assets/js/lazysizes.min.js';?>"></script>
 
<link rel="preload" href="<?= URL::to('/'). '/assets/js/hls.min.js';?>" as="script">
<script defer src="<?= URL::to('/'). '/assets/js/hls.min.js';?>"></script>

<script defer src="<?= URL::to('/'). '/assets/js/hls.js';?>"></script>
<script defer src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>        

<?php

try {
  
  if(Route::currentRouteName() == "LiveStream_play"){

    include('livevideo_player_script.blade.php');
  }
  elseif ( Route::currentRouteName() == "play_episode"){

    include('episode_player_script.blade.php');
  }
  else{
    // include('footerPlayerScript.blade.php');
  }

} catch (\Throwable $th) {
  //throw $th;
}

?>

<script type="text/javascript">
    $(document).ready(function() {
        $("img").lazyload({
            effect: "fadeIn"
        });
    });
</script>

<script>
  if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
      img.src = img.dataset.src;
    });
  } else {
    const script = document.createElement('script');
    script.src =
      'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
    document.body.appendChild(script);
  }
</script>


<?php  
                  //  Prevent Inspect 
  $Prevent_inspect = App\SiteTheme::pluck('prevent_inspect')->first();
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

<?php } ?>
<?php if( get_image_loader() == 1) { ?>
<script>
    const loaderEl = document.getElementsByClassName('fullpage-loader')[0];
document.addEventListener('readystatechange', (event) => {
	// const readyState = "interactive";
	const readyState = "complete";
    
	if(document.readyState == readyState) {
		// when document ready add lass to fadeout loader
		loaderEl.classList.add('fullpage-loader--invisible');
		
		// when loader is invisible remove it from the DOM
		setTimeout(()=>{
			loaderEl.parentNode.removeChild(loaderEl);
		}, 100)
	}
});


</script>
<?php } ?>

</body>
</html>