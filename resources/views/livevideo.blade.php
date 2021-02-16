@include('header')

<meta name="csrf-token" content="{{ csrf_token() }}">


<style type="text/css">
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
    #video_container{height: auto;overflow: auto;padding: 15px 0 !important;width: 80%;margin: 0 auto;z-index: 9999;}
/*    #video_bg_dim {background: #1a1b20;}*/
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
  <link href="https://vjs.zencdn.net/7.8.3/video-js.css" rel="stylesheet" />

  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
  <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <style>
    
        .vjs-skin-hotdog-stand { color: #FF0000; }
        .vjs-skin-hotdog-stand .vjs-control-bar { background: #FFFF00; }
        .vjs-skin-hotdog-stand .vjs-play-progress { background: #FF0000; }
    
    </style>



	<div id="video_title">
		<div class="container">
			<h1><?= $video->title ?></h1>
		</div>
	</div>
   <input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
<?php if ( $ppv_exist > 0  || Auth::user()->subscribed()  ) { ?>
	<div id="video_bg">
		<!-- <div id="video_bg_dim" <?php if($video->access == 'guest' || ($video->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div> -->
		<div class="container">
		
            
						<div id="video_container" class="fitvid">
						<video id="video_player" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

							<source src="<?= $video->mp4_url; ?>" type='video/mp4' label='auto' >
							<source src="<?= $video->webm_url; ?>" type='video/webm' label='auto' >
							<source src="<?= $video->ogg_url; ?>" type='video/ogg' label='auto' >
							<?php /* foreach ($videosubtitles as $key => $videosubtitles_file) { ?>
							<track kind="captions" src="<?= $videosubtitles_file->url; ?>" srclang="<?= $videosubtitles_file->sub_language; ?>" label="<?= $videosubtitles_file->shortcode; ?>" default>
							<?php } */?>
							<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
						</video>
						<div class="playertextbox hide">
						<h2>Up Next</h2>
						<p><?php if(isset($videonext)){ ?>
						<?= App\LiveStream::where('id','=',$videonext->id)->pluck('title'); ?>
						<?php }elseif(isset($videoprev)){ ?>
						<?= App\LiveStream::where('id','=',$videoprev->id)->pluck('title'); ?>
						<?php } ?>

						<?php if(isset($videos_category_next)){ ?>
						<?= App\LiveStream::where('id','=',$videos_category_next->id)->pluck('title');  ?>
						<?php }elseif(isset($videos_category_prev)){ ?>
						<?= App\LiveStream::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
						<?php } ?></p>
						</div>
						</div>
					
				

			<?php }  else {?>       
            <div id="subscribers_only" style="background-image: url('<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>'); margin-top: 20px;">
				<div class="row justify-content-center">
					<div class="col-md-8 col-sm-offset-2">
						<div class="ppv-block">
							<h2>Pay now to watch the video</h2>
							<div class="clear"></div>
							<button class="btn btn-success btn-block" onclick="pay(<?php echo $ppv_price;?>)">Pay <?php echo '$'.$ppv_price;?></button>
						</div>
					</div>
				</div>
			</div>
            <?php } ?>
            
            

	<input type="hidden" class="videocategoryid" data-videocategoryid="<?= $video->video_category_id ?>" value="<?= $video->video_category_id ?>">

	<div class="container video-details">
		<div class="row">
			<div class="col-sm-9 col-md-9 col-xs-12">     
				
				<div class="social_share">
				  <p><i class="fa fa-share-alt"></i> Share: </p>
				  <div id="social_share">
					<?php //include ('partials/social-share.php'); ?>
				  </div>
				</div>
			</div>
			<div class="col-sm-3 col-md-3 col-xs-12">
				<!-- Views -->
				 <div class="btn btn-default views">
					 <span class="view-count" style="margin-right:10px";><i class="fa fa-eye"></i> <?php if(isset($view_increment) && $view_increment == true ): ?><?= $video->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> Views </span>
				</div>
			</div> 
       </div>
	 <!--	<div style="text-align:right;padding:5px 0";>
           <span class="view-count" style="margin-right:10px";><i class="fa fa-eye"></i> <?php if(isset($view_increment) && $view_increment == true ): ?><?= $video->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> Views </span>
			
            
			<div class="favorite btn btn-default <?php if(isset($favorited->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i class="fa fa-heart"></i> Favorite</div>

			

        </div> -->
        
        <div class="row">
			<div class="vid-details col-sm-12 col-md-12 col-xs-12">
				<p class="cat-name">
					<span><?= $video->title; ?></span> <span><?= $video->year;?></span>
				</p>
			</div>
		</div>
        
		<div class="row">
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="video-details-container"><?= $video->details ?></div>
			</div>
		</div>
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
<!--
		<div id="tags">Tags: 
		<php foreach($video->tags as $key => $tag): ?>

			<span><a href="/videos/tag/<= $tag->name ?>"><= $tag->name ?></a></span><php if($key+1 != count($video->tags)): ?>,<php endif; ?>

		<php endforeach; ?>
		</div>
-->

		<div class="clear"></div>
		<div id="social_share">
<!--            <php include('partials/social-share.php'); ?>-->
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
					$.post('<?= URL::to('ppvWatchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
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
					$.post('<?= URL::to('ppvWishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
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
	
	<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>


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
        console.log(token);
        $('#token_response').html(JSON.stringify(token));
 
        $.ajax({
          url: '{{ URL::to("/purchase-live") }}',
          method: 'post',
          data: { tokenId: token.id, amount: amount , video_id: video_id },
          success: (response) => {
            swal("You have done  Payment !");
            setTimeout(function() {
                     location.reload();
                }, 2000);
 
          },
          error: (error) => {
            swal('error');
            //swal("Oops! Something went wrong");
              /* setTimeout(function() {
                   location.reload();
                }, 2000);*/
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
 <script src="https://vjs.zencdn.net/7.8.3/video.js"></script>

@extends('footer')