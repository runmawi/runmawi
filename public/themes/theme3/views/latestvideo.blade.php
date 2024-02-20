@php
   include(public_path('themes/theme3/views/header.php'));
@endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($latestvideo['latest_videos']) && count($latestvideo['latest_videos']) > 0 )

            <div class="iq-main-header align-items-center justify-content-between">
               <h3 class="vid-title">Latest Videos</h3>
            </div>


            <div class="favorites-contens">
               <ul class="favorites-slider list-inline  row p-0 mb-0">
                  @foreach($latestvideo['latest_videos'] as $latest_video)
                        <li class="slide-item">
                           <a href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                       

                                       <div class="hover-buttons">
                                          <a class="" href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
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
                     @endforeach
               </ul>
            </div>
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">No Latest Video Available</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/theme3/views/footer.blade.php'));  ?>