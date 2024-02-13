<style>
    .playvid {
        display: block;
        width: 280%;
        height: auto !important;
        margin-left: -410px;
    }

    .btn.btn-primary.close {
        margin-right: -17px;
        background-color: #4895d1 !important;
    }

    button.close {
        padding: 9px 30px !important;
        border: 0;
        -webkit-appearance: none;
    }

    .close {
        margin-right: -429px !important;
        margin-top: -1461px !important;
    }

    .modal-footer {
        border-bottom: 0px !important;
        border-top: 0px !important;

    }
    

</style>




<?php 

$setting= \App\HomeSetting::first();
// dd($live_videos);
$currency = App\CurrencySetting::first();

 ?>
<?php  if(count($live_videos) > 0) : ?>


<div class="mb-5">
    <div class="row">
        <div class="col-sm-12 overflow-hidden">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?= URL::to('/') ?><?= '/LiveCategory'.'/' . $category->slug ?>" class="category-heading"
                    style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php 
                          echo __($category->name);?>
                    </h4>
                </a>
            </div>

            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
                            $id = Auth::user()->id ; } else { $id = 0 ; } ?>
                        <?php  if(isset($videos)) :
                        foreach($live_videos as $category_video):
                            
                        ?>
                            <li class="slide-item">
                                <a href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid" alt="">
                                        </div>
                                        <div class="block-description">
                                            

                                            <div class="hover-buttons">
                                                <a class="" href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                                    <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                        <span class="text pr-2"> Play </span>
                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                        </svg>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php           
                        endforeach; 
                    endif; ?>
                </ul>
            </div>
            
        </div>
    </div>
</div>
<?php endif; ?>

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