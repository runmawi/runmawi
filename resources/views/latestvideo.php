<?php include('header.php'); ?>

<style type="text/css">
   /* #home-content{margin-top:560px;padding: 30px 0 0;}
    #home-content .row{margin-top:30px;}*/
    ul.video_list{margin:0px;padding:0px;}
    .video_list li{display:inline;list-style: none;}

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