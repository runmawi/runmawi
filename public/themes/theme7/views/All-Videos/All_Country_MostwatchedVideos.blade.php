   @php
      include(public_path('themes/theme6/views/header.php'));
   @endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($respond_data['videos']) && count($respond_data['videos']) > 0 )


            {{-- <div class="iq-main-header align-items-center justify-content-between">
               <h3 class="vid-title"> Videos</h3>
            </div>
             --}}

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
             
            
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">No Video Available</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/theme6/views/footer.blade.php'));  ?>