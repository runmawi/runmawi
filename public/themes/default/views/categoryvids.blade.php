<!-- Header -->
    @partial('category_header')
<!-- Header End -->
<style>
    .dropdown-menu{
        background-color: Gray!important;
        color: #000!important;
    }
</style>
<!-- MainContent -->
<?php if(!empty($data['password_hash'])) { $id = Auth::user()->id ; } else { $id = 0 ; } ?>

      <div class="main-content">
         <section id="iq-favorites">
            <div class="container">
               <div class="row pageheight">
                  <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header align-items-center d-flex justify-content-between">
                        <h2 class=""><?php echo __($data['category_title']);?></h2>
                    </div>

                    <div class="form-group">
                        <select id="refine" class="refine" name="refine[]" multiple="multiple" class="form-control" >
                            <option value="movies" >Movies</option>
                            <option value="tv_shows">Tv Shows</option>
                            <option value="age">Age</option>
                            <option value="rating">Ratings</option>
                            <option value="new_added">Newly added First</option>
                        </select>
                    </div>

                     <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
                            <?php if (count($data['categoryVideos']) > 0) { ?>         
                                    @foreach($data['categoryVideos']  as $category_video) 
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid loading" alt="" width="">
                                                
                                          <?php  if(!empty($category_video->ppv_price)){?>
                                          <p class="p-tag1" ><?php echo $data['currency']->symbol.' '.$category_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $category_video->global_ppv.' '.$data['currency']->symbol; ?></p>
                                                    <?php }elseif($category_video->global_ppv == null && $category_video->ppv_price == null ){ ?>
                                                    <p class="p-tag"><?php echo "Free"; ?></p>
                                                    <?php } ?>
                                               
                                        </div>
                                                <!-- </div> -->

                                            <div class="block-description">
                                                    
                                                <?php if($data['ThumbnailSetting']->title == 1) { ?>            <!-- Title -->
                                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                                             <h6><?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?></h6>
                                                    </a>
                                                <?php } ?>  
                                                    
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                        <?php if($data['ThumbnailSetting']->age == 1) { ?>
                                                        <!-- Age -->
                                                            <div class="badge badge-secondary p-1 mr-2"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                                                        <?php } ?>
                
                                                        <?php if($data['ThumbnailSetting']->duration == 1) { ?>
                                                        <!-- Duration -->
                                                            <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $category_video->duration); ?></span>
                                                        <?php } ?>
                                                </div>


                                                <?php if(($data['ThumbnailSetting']->published_year == 1) || ($data['ThumbnailSetting']->rating == 1)) {?>
                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        <?php if($data['ThumbnailSetting']->rating == 1) { ?>
                                                            <!--Rating  -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                    <?php echo __($category_video->rating); ?>
                                                                </span>
                                                            </div>
                                                        <?php } ?>
                    
                                                        <?php if($data['ThumbnailSetting']->published_year == 1) { ?>
                                                            <!-- published_year -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                              <span class="text-white">
                                                                  <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                  <?php echo __($category_video->year); ?>
                                                              </span>
                                                            </div>
                                                        <?php } ?>
                    
                                                        <?php if($data['ThumbnailSetting']->featured == 1 &&  $category_video->featured == 1) { ?>
                                                            <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                              <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                              </span>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>

                                                    <div class="movie-time my-2">
                                                        <!-- Category Thumbnail  setting -->
                                                        <?php
                                                        $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                    ->where('categoryvideos.video_id',$category_video->video_id)
                                                                    ->pluck('video_categories.name');        
                                                        ?>
                                                        <?php  if ( ($data['ThumbnailSetting']->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                                        <span class="text-white">
                                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            <?php
                                                                $Category_Thumbnail = array();
                                                                    foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                                    $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                                    }
                                                                echo implode(','.' ', $Category_Thumbnail);
                                                            ?>
                                                        </span>
                                                        <?php } ?>
                                                    </div>
                                                    

                                                    <div class="hover-buttons">
                                                        <a  class="text-white"  href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                                            <span class=""><i class="fa fa-play mr-1" aria-hidden="true"></i>Watch Now</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                            @endforeach
                            <?php } else { ?>
                                    <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                               <p ><h3 class="text-center">No video Available</h3>
                            </div>
                             <?php } ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
</section>
</div>
   
@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<script>

    $(document).ready(function(){
        $('#refine').multiselect({
            nonSelectedText: 'Refine',
            buttonWidth:'400px'
        });
    });

$(".refine").change(function(){
    var selected = [];
    for (var option of document.getElementById('refine').options)
    {
        if (option.selected) {
            selected.push(option.value);
        }
    }

    var Selected = selected;

    $.ajax({
            type: "get", 
            dataType: "json", 
            url: "{{ url('/category/other_category') }}",
             data: {
                 _token  : "{{csrf_token()}}" ,
                 selected_items: Selected,
            },
            success: function(data) {
                if(data.message == 'true'){
                    alert('Clear Cached Successfully');
                    location.reload();
                    }
                },
                });
        });

</script>


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
                            $(this).html('<i class="ri-heart-fill"></i>');                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            $(this).html('<i class="ri-heart-line"></i>');
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