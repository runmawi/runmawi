@php
   include(public_path('themes/theme7/views/header.php'));
@endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($latestvideo['latest_videos']) && count($latestvideo['latest_videos']) > 0 )

            <div class="iq-main-header row align-items-center justify-content-between mt-3">
               <h4 class="vid-title">Latest Videos</h4>
            </div>


            <div class="favorites-contens">
               <ul class="favorites-slider list-inline  row p-0 mb-0">
                  @foreach($latestvideo['latest_videos'] as $latest_video)
                     <li class="slide-item">
                        <div class="block-images position-relative">
                              <div class="img-box">
                                 <a href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                 </a>
                              </div>
                        </div>
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
<?php include(public_path('themes/theme7/views/footer.blade.php'));  ?>