@php
      include(public_path('themes/theme3/views/header.php'));
   @endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($respond_data['videos']) && count($respond_data['videos']) > 0 )


            <div class="iq-main-header align-items-center justify-content-between">
               <h4 class="vid-title"> Continue Watching List </h4>
            </div>

            <div class="favorites-contens">
               <ul class="favorites-slider list-inline  row p-0 mb-0">
                     @foreach ($respond_data['videos'] as $key => $video)
                        <li class="slide-item">
                           <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                       <p> {{ strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : $video->title }}
                                       </p>
                                       <div class="movie-time d-flex align-items-center my-2">

                                             <div class="badge badge-secondary p-1 mr-2">
                                                {{ optional($video)->age_restrict.'+' }}
                                             </div>

                                             <span class="text-white">
                                                {{ $video->duration != null ? gmdate('H:i:s', $video->duration) : null }}
                                             </span>
                                       </div>

                                       <div class="hover-buttons">
                                             <span class="btn btn-hover">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                Play Now
                                             </span>
                                       </div>
                                    </div>
                                    <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                             {{-- <li><span><i class="ri-volume-mute-fill"></i></span></li> --}}
                                             <li><span><i class="ri-heart-fill"></i></span></li>
                                             <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>
                                 </div>
                           </a>
                        </li>
                     @endforeach
               </ul>
            </div>





             
             
            <!-- <div class="favorites-contens">
               <ul class="category-page list-inline row p-0 mb-0">
                     @forelse($respond_data['videos'] as $key => $video)

                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                              <div class="block-images position-relative">
                                 <div class="img-box">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid w-100" alt="">
                                       @if(!empty($video->ppv_price))
                                          <p class="p-tag1" ><?php echo $respond_data['currency']->symbol.' '.$video->ppv_price; ?></p>
                                       @elseif( !empty($video->global_ppv || !empty($video->global_ppv) && $video->ppv_price == null)) 
                                          <p class="p-tag1"><?php echo $video->global_ppv.' '. $respond_data['currency']->symbol; ?></p>
                                       @elseif($video->global_ppv == null && $video->ppv_price == null )
                                          <p class="p-tag" ><?php echo "Free"; ?></p>
                                       @endif
                                 </div>

                                 <div class="block-description">
                                    @if( $respond_data['ThumbnailSetting']->title == 1)  
                                       <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                          <h6><?php  echo (strlen($video->title) > 17) ? substr($video->title,0,18).'...' : $video->title; ?></h6>
                                       </a>
                                    @endif  

                                    <div class="movie-time d-flex align-items-center pt-1">
                                       @if($respond_data['ThumbnailSetting']->age == 1) 
                                                  
                                          <div class="badge badge-secondary p-1 mr-2"><?php echo $video->age_restrict.' '.'+' ?></div>
                                       @endif

                                       @if($respond_data['ThumbnailSetting']->duration == 1) 
                                                   
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $video->duration); ?></span>
                                       @endif
                                    </div>

                                    @if(($respond_data['ThumbnailSetting']->published_year == 1) || ($respond_data['ThumbnailSetting']->rating == 1))
                                       <div class="movie-time d-flex align-items-center pt-1">
                                          @if($respond_data['ThumbnailSetting']->rating == 1) 
                                             <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                   <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                      {{ $video->rating }}
                                                </span>
                                             </div>
                                          @endif

                                          @if($respond_data['ThumbnailSetting']->published_year == 1)   
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                                         {{ ($video->year) }}
                                                   </span>
                                                </div>
                                          @endif

                                          @if($respond_data['ThumbnailSetting']->featured == 1 &&  $video->featured == 1) 
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                   </span>
                                                </div>
                                          @endif
                                       </div>
                                    @endif

                                    <div class="hover-buttons">
                                       <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">	
                                          <span class="text-white">
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Now
                                          </span>
                                       </a>
                                    <div>
                                 </div>
                              </div>

                              <div>
                                 <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $video->id;?>">
                                    <span class="text-center thumbarrow-sec">
                                       <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                    </span>
                                 </button>
                              </div>
                              </div>
                              </div>
                           </a>
                        </li>
                     @empty
                        <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                           <p ><h3 class="text-center">No video Available</h3>
                        </div>
                     @endforelse
               </ul>

               <div class="col-md-12 pagination justify-content-end" >
                  {!!  $respond_data['videos']->links() !!}
               </div>

            </div> -->
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">No Video Available</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/theme3/views/footer.blade.php'));  ?>