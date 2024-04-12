<?php 
    include(public_path('themes/theme7/views/header.php'));
?>

 <!-- MainContent -->
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">Live Artist Event</h3>                     
                </div>

                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">

                            @if(isset($artist_live_event['artist_live_event'])) 
                            @foreach($artist_live_event['artist_live_event'] as $artist_live_events)

                           <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a  href="{{ route('live_event_play',$artist_live_events->slug ) }}" >	
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_live_events->image;  ?>" class="img-fluid w-100" alt="">
                                           
                                             @if(!empty($artist_live_events->ppv_price))
                                                <p class="p-tag1" ><?php echo $artist_live_event['currency']->symbol.' '.$artist_live_events->ppv_price; ?></p>
                                            @elseif( !empty($artist_live_events->global_ppv || !empty($artist_live_events->global_ppv) && $artist_live_events->ppv_price == null))
                                                <p class="p-tag1"><?php echo $artist_live_events->global_ppv.' '. $artist_live_event['currency']->symbol; ?></p>
                                            @elseif($artist_live_events->global_ppv == null && $artist_live_events->ppv_price == null )
                                                <p class="p-tag" ><?php echo "Free"; ?></p>
                                           @endif

                                    </div>
                                 
                                    <div class="block-description">
                                        @if( $artist_live_event['ThumbnailSetting']->title == 1)            <!-- Title -->
                                            <a  href="{{ route('live_event_play',$artist_live_events->slug ) }}" >	
                                                <h6><?php  echo (strlen($artist_live_events->title) > 17) ? substr($artist_live_events->title,0,18).'...' : $artist_live_events->title; ?></h6>
                                            </a>
                                        @endif  

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            @if($artist_live_event['ThumbnailSetting']->age == 1)
                                            <!-- Age -->
                                                <div class="badge badge-secondary p-1 mr-2">{{ $artist_live_events->age_restrict.' '.'+' }}</div>
                                            @endif

                                            @if($artist_live_event['ThumbnailSetting']->duration == 1) 
                                            <!-- Duration -->
                                                <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $artist_live_events->duration); ?></span>
                                            @endif
                                        </div>


                                    @if(($artist_live_event['ThumbnailSetting']->published_year == 1) || ($artist_live_event['ThumbnailSetting']->rating == 1)) 
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            @if($artist_live_event['ThumbnailSetting']->rating == 1) 
                                                <!--Rating  -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                             {{  ($artist_live_events->rating) }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if($artist_live_event['ThumbnailSetting']->published_year == 1)
                                            <!-- published_year -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        {{ ($artist_live_events->year) }}
                                                </span>
                                                </div>
                                            @endif

                                            @if($artist_live_event['ThumbnailSetting']->featured == 1 &&  $artist_live_events->featured == 1) 
                                            <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                </span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="hover-buttons">
                                        <a  href="{{ route('live_event_play',$artist_live_events->slug ) }}" >	
                                          <span class="text-white"><i class="fa fa-play mr-1" aria-hidden="true"></i>Live Now</span>
                                        </a>
                                    <div>
                                        </div>
                                       </div>
                                       <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $artist_live_events->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                             @endforeach
		                          @endif
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

<?php include(public_path('themes/theme7/views/footer.blade.php'));  ?>
