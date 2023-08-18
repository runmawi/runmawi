<?php $settings = App\Setting::first();
 $user = App\User::where('id','=',1)->first(); 
 $app_setting = App\AppSetting::where('id','=',1)->where('status','hidden')->first();
 $session = session()->all();
 use Carbon\Carbon;

?>
<footer class=" py-4 mt-auto">
        <div class="container-fluid px-5">
            <div class="row  justify-content-between flex-column flex-sm-row">
                <div class="col-sm-3">
                    <div class="small m-0 text-white"><p>The Best Streaming Platform</p></div>
                    <div class="d-flex p-0 text-white icon mt-4">

                    <?php if(!empty($settings->facebook_page_id)){?>
                      <a href="https://www.facebook.com/<?php echo FacebookId();?>" target="_blank"  class="">
                        <i class="fa fa-facebook" aria-hidden="true" style="padding: 0px 10px;"></i>
                        </a>
                    <?php } ?>

                    <?php if(!empty($settings->skype_page_id)){?>
                      <a href="https://www.skype.com/en/<?php echo SkypeId();?>" target="_blank"  class="">
                        <i class="fa fa-skype"></i>
                        </a>
                    <?php } ?>

                    <?php if(!empty($settings->twitter_page_id)){?>
                      <a href="https://twitter.com/<?php echo TwiterId();?>" target="_blank"  class="">
                        <i class="fa fa-twitter" aria-hidden="true"style="padding: 0px 10px;"></i>
                        </a>
                    <?php } ?>

                    <?php if(!empty($settings->instagram_page_id)){?>
                      <a href="https://www.instagram.com/<?php echo InstagramId();?>" target="_blank"  class="">
                        <i class="fa fa-instagram" aria-hidden="true"style="padding: 0px 10px;"></i>
                        </a>
                    <?php } ?>

                    <?php if(!empty($settings->linkedin_page_id)){?>
                      <a href="https://www.linkedin.com/<?php echo linkedinId();?>" target="_blank"  class="">
                        <i class="fa fa-linkedin" aria-hidden="true" style="padding: 0px 10px;"></i>
                        </a>
                    <?php } ?>


                    <?php if(!empty($settings->whatsapp_page_id)){?>
                      <a href="https://www.whatsapp.com/<?php echo YoutubeId();?>" target="_blank"  class="">
                        <i class="fa fa-whatsapp"></i>
                        </a>
                    <?php } ?>

                    <?php if(!empty($settings->youtube_page_id)){?>
                      <a href="https://www.youtube.com/<?php echo YoutubeId();?>" target="_blank"  class="">
                        <i class="fa fa-youtube"></i>
                        </a>
                    <?php } ?>

                    <?php if(!empty($settings->google_page_id)){?>
                      <a href="https://www.google.com/<?php echo GoogleId();?>" target="_blank" class="">
                        <i class="fa fa-google-plus"></i>
                        </a>
                    <?php } ?>

                </div>
                </div>
                <div class="col-sm-3 small m-0 text-white exp"><p class="ml-2">Explore</p>
                    <ul class="text-white p-0 mt-3 ">
                      
                      <?php $column2_footer = App\FooterLink::where('column_position',2)->orderBy('order')->get();  
                        foreach ($column2_footer as $key => $footer_link){ ?>

                          <li><a href="<?php echo URL::to('/'.$footer_link->link) ?>">
                                  <?php echo  $footer_link->name ; ?>
                              </a>
                          </li>
                      
                      <?php  } ?>

                     <!--   <li><a href="<?php echo URL::to('/contact-us/') ;?>">Contact us</a></li> -->

                    </ul>
                </div>
                <div class="col-sm-3 small m-0 text-white exp"><p class="ml-2">Company</p>
                    <ul class="text-white p-0 mt-3">

                        <?php
                        
                            if( Auth::user() != null && Auth::user()->package == "Business" ):

                            $column3_footer = App\FooterLink::where('column_position',3)->orderBy('order')->get(); 

                            else:

                            $column3_footer = App\FooterLink::where('column_position',3)->whereNotIn('link', ['/cpp/signup','/advertiser/register','/channel/register'])
                                            ->orderBy('order')->get();  
                            endif;
                          
                          foreach ($column3_footer as $key => $footer_link){ ?>
                              <li><a href="<?php echo URL::to('/'.$footer_link->link) ?>">
                                      <?php echo  $footer_link->name ; ?>
                                  </a>
                              </li>
                              
                        <?php  } ?>
                    </ul>
                </div>
                <?php $app_settings = App\AppSetting::where('id','=',1)->first();  ?>     
                <div class="col-sm-3 small m-0 text-white"><p>Download App</p>
                    <p>Available on Play Store</p>
                    <!-- <img src="<?php //echo URL::to('assets/img/gplay.png') ?> " alt="Play store" class=""> -->
                    <?php if(!empty($app_settings->android_url)){ ?> 
                    <img class="" height="80" width="140" src="<?php echo  URL::to('/assets/img/apps1.png')?>" style="margin-top:-20px;">
                    <?php } ?>
                    <?php if(!empty($app_settings->ios_url)){ ?> 
                    <img class="" height="80" width="140" src="<?php echo  URL::to('/assets/img/apps.png')?>" style="margin-top:-20px;">
                    <?php } ?>
                    <?php if(!empty($app_settings->android_tv)){ ?> 
                    <img class="" height="100" width="150" src="<?php echo  URL::to('/assets/img/and.png')?>" style="margin-top:-20px;">
                    <?php } ?>
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
               <p class="mb-0 text-center font-size-14 text-body" style="color:#fff!important;"><?php echo $settings->website_name ; ?> - <?php echo Carbon::now()->year ; ?> All Rights Reserved</p>
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

      <script type="text/javascript" src="<?php echo URL::to('public/themes/theme1/assets/js/custom.js'); ?>"></script>
      <?php 
      $footer_script = App\Script::pluck('footer_script')->toArray();
      if(count($footer_script) > 0){
        foreach($footer_script as $Scriptfooter){ ?>
        <!-- // echo $Scriptfooter; -->
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


<?php  $search_dropdown_setting = App\SiteTheme::pluck('search_dropdown_setting')->first(); ?>
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

<script src="<?= URL::to('/'). '/assets/js/ls.bgset.min.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/lazysizes.min.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/plyr.polyfilled.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/hls.min.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/plyr.js';?>"></script>
 <!-- <script src="<? //URL::to('/'). '/assets/js/plyr-3-7.js';?>"></script> -->
 <script src="<?= URL::to('/'). '/assets/js/hls.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/.js';?>"></script>
<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
        
<?php

    try {
    
      if(Route::currentRouteName() == "LiveStream_play"):

        include('livevideo_player_script.blade.php');
      elseif ( Route::currentRouteName() == "play_episode"):

        include('episode_player_script.blade.php');
      else:

        include('footerPlayerScript.blade.php');
      endif;

    } catch (\Throwable $th) {
      //throw $th;
    }
  
?>
  <script type="text/javascript">
	$("img").lazyload({
	    effect : "fadeIn"
	});
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
