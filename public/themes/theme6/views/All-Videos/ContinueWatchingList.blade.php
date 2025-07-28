@php
      include(public_path('themes/theme6/views/header.php'));
   @endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($respond_data['videos']) && count($respond_data['videos']) > 0 )


            <div class="iq-main-header align-items-center justify-content-between">
               <h4 class="main-title"> {{ __('Continue Watching List') }} </h4>
            </div>

            <div class="favorites-contens">
               <ul class="favorites-slider list-inline  row p-0 mb-0">
                  @forelse($respond_data['videos'] as $key => $video_details)
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video_details->slug ?>">
                              <div class="block-images position-relative">
                                 <a href="{{ URL::to('category/videos/'.$video_details->slug ) }}">
                                     <div class="img-box">
                                         <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                     </div>

                                     <div class="block-description">
                                         <p> {{ strlen($video_details->title) > 17 ? substr($video_details->title, 0, 18) . '...' : $video_details->title }}</p>
                                         
                                         <div class="movie-time d-flex align-items-center my-2">

                                             {{-- <div class="badge badge-secondary p-1 mr-2">
                                                 {{ optional($video_details)->age_restrict.'+' }}
                                             </div> --}}

                                             <span class="text-white">
                                                 @if($video_details->duration != null)
                                                     @php
                                                         $duration = Carbon\CarbonInterval::seconds($video_details->duration)->cascade();
                                                         $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                         $minutes = $duration->format('%imin');
                                                     @endphp
                                                     {{ $hours }}{{ $minutes }}
                                                 @endif
                                               </span>
                                         </div>

                                         <div class="hover-buttons">
                                             <span class="btn btn-hover">
                                                 <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                 Play Now
                                             </span>
                                         </div>
                                     </div>
                                 </a>

                                 {{-- WatchLater & wishlist --}}

                                 {{-- @php
                                     $inputs = [
                                         'source_id'     => $video_details->id ,
                                         'type'          => 'channel',  // for videos - channel
                                         'wishlist_where_column'    => 'video_id',
                                         'watchlater_where_column'  => 'video_id',
                                     ];
                                 @endphp

                                 {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!} --}}

                             </div>
                           </a>
                        </li>
                        @empty
                           <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                              <p ><h3 class="text-center">{{ __('No video Available') }}</h3>
                           </div>
                     @endforelse
               </ul>
               <div class="col-md-12 pagination justify-content-end" >
                  {!!  $respond_data['videos']->links() !!}
               </div>
            </div>
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">{{ __('No video Available') }}</h3>
            </div>
         @endif

      </div>
   </div>
</div>
<?php include(public_path('themes/theme6/views/footer.blade.php'));  ?>