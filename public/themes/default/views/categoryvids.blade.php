    @partial('category_header')
<!-- Header End -->

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

                    {{-- filter Option --}}

                    {{-- <div class="row d-flex ">

                        <div class="col-md-3">
                            <select class="selectpicker" multiple title="Refine" data-live-search="true">
                                <option value="videos">Movie</option>
                                <option value="tv_Shows">TV Shows</option>
                                <option value="live_stream">Live stream</option>
                                <option value="audios">Audios</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select class="selectpicker" multiple title="Age" name="age" id="age" data-live-search="true">
                                @foreach($data['age_categories'] as $age)
                                    <option value="{{ $age->age  }}">{{ $age->slug }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select class="selectpicker" multiple title="Rating" id="rating" data-live-search="true">
                                <option value="1" >1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>

                        
                        <div class="col-md-3">
                            <select class="selectpicker " multiple  title="Newly added First" id="sorting" data-live-search="true">
                                <option value="1">Latest Videos</option>
                                <option value="2">oldest videos</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary filter">Filter</button>
                        </div>
                    </div>   --}}


                   
                     <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
                            <?php if (count($data['categoryVideos']) > 0) { ?>         
                                    @foreach($data['categoryVideos']  as $category_video) 
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid" alt="" width="">
                                                
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

{{--Multiple Select  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">


<script>

$(".filter").click(function(){
    var age = [];
    var rating = [];
    var sorting = [];

    for (var option of document.getElementById('age').options)
    {
        if (option.selected) {
            age.push(option.value);
        }
    }

    for (var option of document.getElementById('rating').options)
    {
        if (option.selected) {
            rating.push(option.value);
        }
    }

    for (var option of document.getElementById('sorting').options)
    {
        if (option.selected) {
            sorting.push(option.value);
        }
    }

    $.ajax({
            type: "get", 
            dataType: "json", 
            url: "{{ url('/category/other_category') }}",
             data: {
                 _token  : "{{csrf_token()}}" ,
                 age: age,
                 rating: rating,
                 sorting: sorting,
            },
            success: function(data) {
                console.log('ss');
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