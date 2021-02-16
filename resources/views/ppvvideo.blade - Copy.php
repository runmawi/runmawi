@include('header')
 <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<style type="text/css">
    body{background: #1a1b20;color: #fff;}
.video-js{height: 500px !important;}
.video-js *, .video-js :after, .video-js :before {box-sizing: inherit;display: grid;}
.vjs-big-play-button{
top: 50% !important;
left: 50% !important;
margin: -25px 0 0 -25px;
width: 50px !important;
height: 50px !important;
border-radius: 25px !important;
}
.vjs-texttrack-settings { display: none; }
.video-js .vjs-big-play-button{ border: none !important; }
    #video_container{height: auto;overflow: auto;padding: 15px 0 !important;width: 80%;margin: 0 auto;}
    /*#video_bg_dim {background: #1a1b20;}*/
    .video-js .vjs-tech {outline: none;}
    
    .video-details{width: 80%;margin: 0 auto;padding-bottom: 30px;}
    .video-details h1{margin: 0 0 10px;color: #fff;}
    .vid-details{margin-bottom: 20px;}
    #tags{margin-bottom: 10px;}
    .share{display: flex;align-items: center;}
    .share span, .share a{display: inline-block;text-align: center;font-size: 20px;padding-right: 20px;color: #fff;}
    .share a{padding: 0 20px;}
    .cat-name span{margin-right: 10px;}

</style>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<div class="container">

    <input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
    
<?php if ( $ppv_exist > 0 ) { ?>
    
	<div id="video_title">
		<div class="container">

			<span class="label">You're watching:</span> <h1><?= $video->title ?></h1>
		</div>
	</div>
	<div id="video_bg">
		<div id="video_bg_dim" <?php if($video->access == 'guest' || ($video->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
		<div class="container">
				
					<?php if($video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $video->embed_code ?>
						</div>
					<?php  elseif($video->type == 'file'): ?>
						<div id="video_container" class="fitvid">
						<video id="video_player" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

							<source src="<?= $video->mp4_url; ?>" type='video/mp4' label='auto' >
							<source src="<?= $video->webm_url; ?>" type='video/webm' label='auto' >
							<source src="<?= $video->ogg_url; ?>" type='video/ogg' label='auto' >
							
							<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
						</video>
						
						</div>
					<?php  else: ?>
						<div id="video_container" class="fitvid">
						<video id="video_player" onplay="playstart()" onended="autoplay1()" autoplay class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
						<source src="<?= $video->mp4_url; ?>" type='video/mp4' label='auto' >
						</video>
						
						</div>


				<div id="subscribers_only">
					<h2>Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
					<div class="clear"></div>
					<?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
						<form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
							<button id="button">Become a subscriber to watch this video</button>
						</form>
					<?php else: ?>
						<form method="get" action="<?= URL::to('signup') ?>">
							<button id="button">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
						</form>
					<?php endif; ?>
				</div>
			
			<?php endif; ?>
		</div>
	</div>

	<input type="hidden" class="videocategoryid" data-videocategoryid="<?= $video->video_category_id ?>" value="<?= $video->video_category_id ?>">

	<div class="container video-details">
		<div style="padding:5px 0";>
            <div class="row">
				<div class="col-sm-6">
					<div class="watchlater btn btn-default <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div>
					
					<div class="mywishlist btn btn-default <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>
					
					<!-- <div class="favorite btn btn-default <?php if(isset($favorited->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i class="fa fa-heart"></i> Favorite</div> -->
				</div>
				<div class="col-sm-6" style="text-align:right;">
					<span class="view-count" style="margin-right:10px";><i class="fa fa-eye"></i> <?php if(isset($view_increment) && $view_increment == true ): ?><?= $video->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> Views </span>
					
					
				</div>
			</div>
        </div>
        
        <?php } else { ?>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="card" style="margin-top: 30px;">
                    <div class="col-md-8 col-sm-offset-2">

                        <!--  <h2 style="margin-top: 12px;" class="alert alert-success">laravel Stripe Payment Gateway Integration - <a href="https://www.w3path.com" target="_blank" >BOP</a></h2><br>  -->

                    <!--  <div class="row">
                                              <div class="col-md-12"><pre id="token_response"></pre></div>
                                            </div>
                    -->
                        
                        <div class="row" style="margin-left: 30%;">                          
                          <div class="col-md-4">
                            <button class="btn btn-success btn-block" onclick="pay(<?php echo $ppv_price;?>)">Pay <?php echo '$'.$ppv_price;?></button>
                          </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
        <?php } ?>
        <h1><?= $video->title ?></h1>
        <div class="vid-details">
            <p class="cat-name">
                <span>HORROR</span> <span>2010</span>
            </p>
        </div>
        
		<div class="video-details-container"><?= $video->details ?></div>
		<?php if(isset($videonext)){ ?>
		<div class="next_video" style="display: none;"><?= $videonext->slug ?></div>
		<div class="next_url" style="display: none;"><?= $url ?></div>
		<?php }elseif(isset($videoprev)){ ?>
		<div class="prev_video" style="display: none;"><?= $videoprev->slug ?></div>
		<div class="next_url" style="display: none;"><?= $url ?></div>
		<?php } ?>

		<?php if(isset($videos_category_next)){ ?>
		<div class="next_cat_video" style="display: none;"><?= $videos_category_next->slug ?></div>
		<?php }elseif(isset($videos_category_prev)){ ?>
		<div class="prev_cat_video" style="display: none;"><?= $videos_category_prev->slug ?></div>
		<?php } ?>

		<div class="clear"></div>
		

		<div class="clear"></div>
		<div id="social_share">
            
		</div>
        <script>
            //$(".share a").hide();
            $(".share").on("mouseover", function() {
            $(".share a").show();
            }).on("mouseout", function() {
            $(".share a").hide();
            });
        </script>

		<!--<div class="clear"></div>

		<div id="comments">
			<div id="disqus_thread"></div>
		</div>-->
    
	</div>
</div>

    <noscript>Please enable JavaScript to view the comments</noscript> 

	<script src="<?= THEME_URL . '/assets/js/jquery.fitvid.js'; ?>"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			$('#video_container').fitVids();
			$('.favorite').click(function(){
				if($(this).data('authenticated')){
					$.post('<?= URL::to('favorite') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');
				} else {
					window.location = '<?= URL::to('login') ?>';
				}
			});
			//watchlater
			$('.watchlater').click(function(){
				if($(this).data('authenticated')){
					$.post('<?= URL::to('watchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');
					$(this).html("");
			        if($(this).hasClass('active')){
			          $(this).html('<a><i class="fa fa-check"></i>Watch Later</a>');
			        }else{
			          $(this).html('<a><i class="fa fa-clock-o"></i>Watch Later</a>');
			        }
				} else {
					window.location = '<?= URL::to('login') ?>';
				}
			});

			//My Wishlist
			$('.mywishlist').click(function(){
				if($(this).data('authenticated')){
					$.post('<?= URL::to('mywishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');
					$(this).html("");
			        if($(this).hasClass('active')){
			          $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
			        }else{
			          $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
			        }
			        
				} else {
					window.location = '<?= URL::to('login') ?>';
				}
			});

		});

	</script>

	<!-- RESIZING FLUID VIDEO for VIDEO JS -->
	

	<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
	<script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
	<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>


  <script>
     var player = videojs('video_player').videoJsResolutionSwitcher({
        default: '480p', // Default resolution [{Number}, 'low', 'high'],
        dynamicLabel: true
      })
	$(".playertextbox").appendTo($('#video_player'));

  // var res = player.currentResolution();
  // player.currentResolution(res);
 
    function autoplay1() {
    	
    	var playButton = document.getElementsByClassName("vjs-big-play-button")[0];
		playButton.setAttribute("id", "myPlayButton");
	    var next_video_id = $(".next_video").text();
	    var prev_video_id = $(".prev_video").text();
	    var next_cat_video = $(".next_cat_video").text();
	    var prev_cat_video = $(".prev_cat_video").text();
	    var url = $(".next_url").text();
	    if(next_video_id != ''){

	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/"+url+"/"+next_video_id;
         }, 3000);
	    }else if(prev_video_id != ''){
	    	
	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/"+url+"/"+prev_video_id;
         }, 3000);
	    
	    }

	    if(next_cat_video != ''){

	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/videos_category/"+next_cat_video;
         }, 3000);
	    }else if(prev_cat_video != ''){
	    	
	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/videos_category/"+prev_cat_video;
         }, 3000);
	    
	    }
 	}

 	/*on video Play*/
 	function playstart() {
 		if($("#video_player").data('authenticated')){
			$.post('<?= URL::to('watchhistory');?>', { video_id : '<?= $video->id ?>', _token: '<?= csrf_token(); ?>' }, function(data){});
			$.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});

		} else {
			$.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});
		}
 	}
  </script>
 <script type="text/javascript">
	$(document).ready(function(){
		$('a.block-thumbnail').click(function(){
			var myPlayer = videojs('video_player');
			var duration = myPlayer.currentTime();
			
			$.post('<?= URL::to('watchhistory');?>', { video_id : '<?= $video->id ?>', _token: '<?= csrf_token(); ?>', duration : duration }, function(data){});
		}); 
	});
  </script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
  <script>
    $(".slider").slick({

// normal options...
infinite: false,

// the magic
responsive: [{

    breakpoint: 1024,
    settings: {
        slidesToShow: 3,
        infinite: true
    }

}, {

    breakpoint: 600,
    settings: {
        slidesToShow: 2,
        dots: true
    }

}, {

    breakpoint: 300,
settings: "unslick" // destroys slick

}]
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
 
<script type="text/javascript">
  $(document).ready(function () {  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  });
 
  function pay(amount) {
      
      var video_id = $('#video_id').val();
     
      var handler = StripeCheckout.configure({
          
      key: 'pk_test_z8OQoKfyOCjAxMfPD7MbzBy200bWaBdwRI',
      locale: 'auto',
      token: function (token) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.
        console.log('Token Created!!');
        console.log(token)
        $('#token_response').html(JSON.stringify(token));
 
        $.ajax({
          url: '{{ url("stripe") }}',
          method: 'post',
          data: { tokenId: token.id, amount: amount , video_id: video_id },
          success: (response) => {
 
            swal("You have done  Payment !");
              
              setTimeout(function() {
                     location.reload();
                }, 2000);
 
          },
          error: (error) => {
            //console.log(error);
            swal("Oops! Something went wrong");
               setTimeout(function() {
                   location.reload();
                }, 2000);
          }
        })
      }
    });
  
    handler.open({
      name: 'BOP',
      description: 'PAY PAR VIEW',
      amount: amount * 100
    });
  }
</script>

@extends('footer')