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
          
 <script>
  // alert($('#hls_m3u8').val());

   document.addEventListener('DOMContentLoaded', () => {
	// const source = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
  const source = $('#hls_m3u8').val();
  // alert(source);
	const video = document.querySelector('video');
	
	// For more options see: https://github.com/sampotts/plyr/#options
	// captions.update is required for captions to work with hls.js
	const player = new Plyr(video, {captions: {active: true, update: true, language: 'en'}});
	
	if (!Hls.isSupported()) {
		video.src = source;
	} else {
		// For more Hls.js options, see https://github.com/dailymotion/hls.js
		const hls = new Hls();
		hls.loadSource(source);
		hls.attachMedia(video);
		window.hls = hls;
		
		// Handle changing captions
		player.on('languagechange', () => {
			// Caption support is still flaky. See: https://github.com/sampotts/plyr/issues/994
			setTimeout(() => hls.subtitleTrack = player.currentTrack, 50);
		});
	}
	
	// Expose player so it can be used from the console
	window.player = player;

});
// const player = new Plyr('#trailor-videos');

</script>
 <script src="plyr-plugin-capture.js"></script>
 <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/plyr-plugin-capture.js';?>"></script>

 <script>
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

      </script>
</body>
</html>
