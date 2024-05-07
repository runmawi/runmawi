<!-- Header -->
<?php 
$currency = App\CurrencySetting::first();
// include('header.php'); 
?><!-- Header End -->
    @php
include (public_path('themes/theme7/views/header.php'));
@endphp

<!-- MainContent -->
<?php if (!empty($data['password_hash'])) {
    $id = Auth::user()->id;
} else {
    $id = 0;
} ?>

      <div class="main-content ">
         <section id="iq-favorites ">
            <div class="container-fluid">
               <div class="row pageheight">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header align-items-center">
                        <h4 class=""><?php echo __($parentCategories_name);?></h4>
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
                            <?php if (count($live_videos) > 0) {
                                foreach ($live_videos as $category_video) { ?>
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                            <div class="block-images position-relative">
                                                <div class="border-bg">
                                                    <div class="img-box">
                                                        <img src="<?php        echo URL::to('/') . '/public/uploads/images/' . $category_video->image;  ?>" class="img-fluid w-100" alt="" width="">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php    }
                            } else { ?>
                                   
                                   <div class="col-md-12 text-center mt-4">
                                        <h1 class="text-white text-center med">Coming Soon......</h1>
                                        <img class="text-center" src="<?php echo URL::to('/assets/img/watch.png'); ?>" style="height:500px;">
                                    </div>
                            <?php } ?>
                    
                                                              
                           
                        </ul>
                         
                     </div>
                      
                  </div>
               </div>
            </div>
<?php ?>
            
</section>
</div>
    <!-- Modal Starts -->
<!-- MainContent End-->
@php
include (public_path('themes/theme7/views/footer.blade.php'));
@endphp
<script>
$('.mywishlist').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/mywishlist');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Wishlist"){
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Wishlist');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
                          setTimeout(function() {
                          $('.remove_watch').slideUp('fast');
                          }, 3000);
                          }               
                    }
                });
            }                
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });

</script>