<?php include('header.php'); ?>
<link href="<?php echo URL::to('/').'/assets/dist/videojs-watermark.css';?>" rel="stylesheet">
<link href="<?php echo URL::to('/').'/assets/dist/videojs-resolution-switcher.css';?>" rel="stylesheet">
<link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.css" rel="stylesheet">
<style type="text/css">
   /* #home-content{margin-top:560px;padding: 30px 0 0;}
    #home-content .row{margin-top:30px;}*/
    ul.video_list{margin:0px;padding:0px;}
    .video_list li{display:inline;list-style: none;}
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
.social_share {
display: inline-block !important;
border-radius: 5px !important;
vertical-align: middle !important;
}
.rrssb-buttons.tiny-format li {
padding-right: 7px;
}
.rrssb-buttons li {
float: left;
height: 100%;
line-height: 13px;
list-style: none;
margin: 0;
padding: 0 2.5px;
}
.video-details {
margin: 0 auto !important;
padding-bottom: 30px !important;
padding-left: 40px !important;
}
.social_share p {
display: inline-block;
font-weight: 700;
font-family: 'Roboto', sans-serif;
font-size: 16px;
}
#social_share {
display: inline-block;
vertical-align: middle;
}
#video_title h1 {
color: #fff;
font-size: 30px;
margin: 20px 0px;
line-height: 22px;
}
.btn.watchlater, .btn.mywishlist {
font-weight: 600;
font-family: 'Roboto', sans-serif;
font-size: 15px;
background: #000;
border: 1px solid #000;
color: #fff;
}
a.ytp-impression-link {
display: none !important;
}
.ytp-impression-link {
display: none !important;
}
.vjs-texttrack-settings { display: none; }
.video-js .vjs-big-play-button{ border: none !important; }
#video_container{height: auto;padding-top: 120px !important;;width: 95%;margin: 0 auto;}
/*    #video_bg_dim {background: #1a1b20;}*/
.video-js .vjs-tech {outline: none;}
.video-details h1{margin: 0 0 10px;color: #fff;}
.vid-details{margin-bottom: 20px;}
#tags{margin-bottom: 10px;}
.share{display: flex;align-items: center;}
.share span, .share a{display: inline-block;text-align: center;font-size: 20px;padding-right: 20px;color: #fff;}
.share a{padding: 0 20px;}
.cat-name span{margin-right: 10px;}
.video-js .vjs-seek-button.skip-back.skip-10::before,
.video-js.vjs-v6 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before,
.video-js.vjs-v7 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before {
content: '\e059'
}
.btn.btn-default.views {
color: #fff !important;
}

</style>


<?php include('partials/latest-videoloop.php');?>


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

  //My Wishlist
    $('.mywishlist').click(function(){
      if($(this).data('authenticated')){
        var getid = $(this).data('url');
        if(getid == 'video'){
          id = 'video_id';
        } else if(getid == 'play_movie'){
          id = 'movie_id';
        }else if(getid == 'episodes'){
          id = 'episode_id';
        }
        var data = {   _token: '<?= csrf_token(); ?>' };
        data[id] = $(this).data('videoid');
        $.post('<?php URL::to('/') ?>mywishlist', data, function(data){});
        $(this).toggleClass('active');
        $(this).html("");
        if($(this).hasClass('active')){
          $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
        }else{
          $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
        }

      } else {
        window.location = '<?php URL::to('/') ?>signup';
      }
    });


    var $myGroup = $('.video-list');

    $myGroup.on('show.bs.collapse','.collapse', function() {
      $myGroup.find('.in').collapse('hide');
    }).on('hidden.bs.collapse', function (e) {

    });

/*    $('.new-art').hover(function(){
      var movie_id = $(this).attr('data-id');
      $('.new-art').removeClass('active');
      $(this).addClass('active');
      $(".block-overlap").css('display','none');
      $(".block-class_"+movie_id).css('display','block');
    }); */
</script>



<?php //include('includes/footer-above.php'); ?>
<!--<php include('includes/footer.php'); ?>-->
<?php include('footer.blade.php'); ?>