<!-- Header -->

@php
    include(public_path('themes/default/views/header.php'));
@endphp

<link href="<?php echo URL::to('public/themes/theme2/assets/css/style.css') ?>" rel="stylesheet">

<!-- Header End -->
<!-- MainContent -->
<?php if(!empty($data['password_hash'])) { $id = Auth::user()->id ; } else { $id = 0 ; }
$category_id = App\VideoCategory::where('name',$categoryVideos['category_title'])->pluck('id')->first();
$category_slug = App\VideoCategory::where('name',$categoryVideos['category_title'])->pluck('slug')->first();
?>

      <div class="main-content">
         <section id="iq-favorites">
              <h2 class="text-center  mb-3"><?php echo __($categoryVideos['category_title']);?></h2>
            <div class="container-fluid" >
                <div class="row pageheight">
                  <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header align-items-center"> </div>

                        {{-- filter Option --}}

                        <div class="row d-flex ">

                            {{-- <div class="col-md-3">
                                <select class="selectpicker" multiple title="Refine" data-live-search="true">
                                    <option value="videos">Movie</option>
                                    <option value="tv_Shows">TV Shows</option>
                                    <option value="live_stream">Live stream</option>
                                    <option value="audios">Audios</option>
                                </select>
                            </div> --}}

                            <div class="col-md-3">
                                <select class="selectpicker" multiple title="Age" name="age[]" id="age" data-live-search="true">
                                    @foreach($categoryVideos['age_categories'] as $age)
                                        <option value="{{ $age->age  }}">{{ $age->slug }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select class="selectpicker" multiple title="Rating" id="rating" name="rating[]" data-live-search="true">
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
                                <select class="selectpicker " multiple  title="Newly added First" id="sorting" name="sorting" data-live-search="true">
                                    <option value="latest_videos">Latest Videos</option>
                                </select>
                            </div>

                            <input type="hidden" id="category_id" value={{ $category_id  }} name="category_id">

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary filter">Filter</button>
                            </div>
                        </div>
                        
                        <div class="data">
                            @partial('categoryvids_section')
                        </div>
                    </div>
                  </div>
                </div>
<?php /*
<!-- Modal Starts -->
<div class="modal fade bd-example-modal-xl<?= $category_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
        
       
    <div class="modal-content" style="background-color: transparent !important;">
       
         
          <div class="modal-body playvid">
                             <?php if($category_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <?= $category_video->embed_code ?>
                                        </div>
                                    <?php  elseif($category_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"   onplay="playstart()"  class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/public/') . '/uploads/images/' . $category_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $category_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$category_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$category_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $category_video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                                    <?php  else: ?>
                                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                        <video id="videojs-seek-buttons-player" onplay="playstart()"  class="video-js vjs-default-skin" controls  poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                        <source src="<?= $category_video->trailer; ?>" type='video/mp4' label='auto' >

                                        </video>


                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                             <?php endif; ?>
                        </div>
        <div class="modal-footer" align="center" >
                <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
 onclick="document.getElementById('framevid').pause();" id="<?= $category_video->id;?>"  ><span aria-hidden="true">X</span></button>
                  
                    </div>
         
  </div>
</div>
</div>
             <div class="modal fade thumb-cont" id="myModal<?= $category_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                     <button type="button" class="btn btn-danger closewin" data-dismiss="modal"><span aria-hidden="true">X</span></button>
                                        </div>
                                <div class="tab-sec">
                                    <div class="tab-content">
                                    <div id="overview<?= $category_video->id;?>" class="container tab-pane active"><br>
                                           <h1 class="movie-title-thumb"><?php echo __($category_video->title); ?></h1>
                                                   <p class="movie-rating">
                                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $category_video->rating;?></span>
                                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $category_video->views;?>)</span>
                                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $category_video->duration); ?></span>
                                                    </p>
                                                  <p>Welcome</p>
                                         <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $category_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
		
		<a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $category_video->slug ?>" >

		
				<?php if (!empty($category_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $category_video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
			            <div class="play-button-trail" >
				
<!--			<a  href="<? URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>-->
                <div class="detail-block">
<!--					<a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                <p class="movie-title"><?php echo __($category_video->title); ?></p>
					</a>-->
					
                <!--<p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $category_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $category_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $category_video->duration); ?></span>
					</p>-->

				</div>
		</div>
		</a>
		<div class="block-contents">
			<!--<p class="movie-title padding"><?php echo __($category_video->title); ?></p>-->
        </div>
	</div> 
	            
    </div>
    <div id="like<?= $category_video->id;?>" class="container tab-pane "><br>
     
           <h2>More Like This</h2>
    </div>
     <div id="details<?= $category_video->id;?>" class="container tab-pane "><br>
        <h2>Description</h2>

    </div>
	</div>
    <div align="center">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $category_video->id;?>">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $category_video->id;?>">TRAILER AND MORE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#like<?= $category_video->id;?>">MORE LIKE THIS</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#details<?= $category_video->id;?>">DETAILS </a>           
                    </li>
              </ul>
        </div>
	</div>
</div>   */ ?>                     
</section>
</div>
    <!-- Modal Starts -->
<!-- MainContent End-->

@php
    include(public_path('themes/theme1/views/footer.blade.php'));
@endphp

{{--Multiple Select  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">


<script>

$(".filter").click(function(){
    var age = [];
    var rating = [];
    var sorting = [];
    var Category_id = $('#category_id').val();


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
            url: "{{ url('/categoryfilter') }}",
             data: {
                 _token  : "{{csrf_token()}}" ,
                 age: age,
                 rating: rating,
                 sorting: sorting,
                 category_id: Category_id,
            },
            success: function(data) {
                $(".data").html(data);
                },
                });
        });

</script>

     <script>
    //    $('.mywishlist').click(function(){
    //    if($(this).data('authenticated')){
    //      $.post('<?= URL::to('mywishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
    //      $(this).toggleClass('active');
    //      $(this).html("");
    //          if($(this).hasClass('active')){
    //           $(this).html('<i class="ri-heart-fill"></i>');
    //          }else{
    //            $(this).html('<i class="ri-heart-line"></i>');

    //          }
             
    //    } else {
    //      window.location = '<?= URL::to('login') ?>';
    //    }
    //  });

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