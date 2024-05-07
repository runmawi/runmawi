<!-- Header -->
<?php 
$currency = App\CurrencySetting::first();
// include('header.php'); 
?><!-- Header End -->
    @php
    include(public_path('themes/theme3/views/header.php'));
@endphp

<!-- MainContent -->
<?php if(!empty($data['password_hash'])) { $id = Auth::user()->id ; } else { $id = 0 ; } ?>

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
                                    foreach($live_videos  as $category_video) { ?>
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid w-100" alt="" width="">
                                                
                                                </div>
                                             

                                            <div class="block-description">
                                                <div class="hover-buttons">
                                                    <a class="" href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                                        <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                            <span class="text pr-2"> {{ (__('Play')) }} </span>
                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                            
 <?php } } else { ?>
                                   
                                    <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                               <p ><h2 style="position: absolute;top: 50%;left: 50%;color: white;">No video Available</h2>
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
    include(public_path('themes/theme3/views/footer.blade.php'));
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