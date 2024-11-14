<?php
include public_path('themes/theme6/views/header.php');

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
$order_settings_list = App\OrderHomeSetting::get();
$continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();
?>

<link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<section>
    {{-- <h4 class="text-center mb-4 mt-4">Channel List</h4> --}}
    
    @foreach ($channel as $ch)
        <div class="container">
            <div class="channel">
                <h3>{{ $ch->channel_name }}</h3> <!-- Display channel name -->
                
                {{-- Display merged videos, livestreams, and episodes for each channel --}}
                @if($ch->all_data->isNotEmpty())
                    <div class="media-list">
                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline">
                                @foreach ($ch->all_data as $media)
                                        @if ($media instanceof App\Video)
                                        
                                            <!-- Display Video Details -->
                                            <li class="slide-item">
                                                <div class="block-images position-relative">
                                                    
                                                    <a href="{{ URL::to('category/videos/'.$media->slug ) }}">
            
                                                        <div class="img-box">
                                                            <img src="{{ $media->image ?  URL::to('public/uploads/images/'.$media->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                        </div>
            
                                                        <div class="block-description">
                                                            <span> {{ strlen($media->title) > 17 ? substr($media->title, 0, 18) . '...' : $media->title }}
                                                            </span>
                                                            <div class="movie-time d-flex align-items-center my-2">
            
                                                                <!-- <div class="badge badge-secondary p-1 mr-2">
                                                                    {{ optional($media)->age_restrict.'+' }}
                                                                </div> -->
            
                                                                <span class="text-white">
                                                                    @if($media->duration != null)
                                                                        @php
                                                                            $duration = Carbon\CarbonInterval::seconds($media->duration)->cascade();
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
                                                                    {{ __('Play Now')}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
            
                                                            {{-- WatchLater & wishlist --}}
            
                                                    {{-- @php
                                                        $inputs = [
                                                            'source_id'     => $media->id ,
                                                            'type'          => 'channel',  // for videos - channel
                                                            'wishlist_where_column'    => 'video_id',
                                                            'watchlater_where_column'  => 'video_id',
                                                        ];
                                                    @endphp
            
                                                    {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!} --}}
            
                                                </div>
                                            </li>

                                        @elseif ($media instanceof App\LiveStream)
                                            <li class="slide-item">
                                                <div class="block-images position-relative">
                                                    <a href="{{ URL::to('live/'.$media->slug ) }}">
            
                                                        <div class="img-box">
                                                            <img src="{{ $media->image ? URL::to('public/uploads/images/'.$media->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                        </div>
            
                                                        <div class="block-description">
                                                            <p> {{ strlen($media->title) > 17 ? substr($media->title, 0, 18) . '...' : $media->title }}</p>
                                                            
                                                            <div class="movie-time d-flex align-items-center my-2">
                                                                {{-- <div class="badge badge-secondary p-1 mr-2">
                                                                    {{ optional($media)->age_restrict.'+' }}
                                                                </div> --}}
            
                                                                <span class="text-white">
                                                                    @if($media->duration != null)
                                                                        @php
                                                                            $duration = Carbon\CarbonInterval::seconds($media->duration)->cascade();
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
                                                                    {{ __('Play Now')}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>

                                        @elseif ($media instanceof App\Episode)
                                            <li class="slide-item">
                                                {{-- <a href="{{ URL::to('episode/'. $media->series_title->slug.'/'.$media->slug ) }}"> --}}
                                                    <div class="block-images position-relative">
                                                        <div class="img-box">
                                                            <img src="{{ $media->image ? URL::to('public/uploads/images/'.$media->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                        </div>
                                                        <div class="block-description">
                                                            <p> {{ strlen($media->title) > 17 ? substr($media->title, 0, 18) . '...' : $media->title }}
                                                            </p>
                                                            <div class="movie-time d-flex align-items-center my-2">
            
                                                                <span class="text-white">
                                                                    @if($media->duration != null)
                                                                        @php
                                                                            $duration = Carbon\CarbonInterval::seconds($media->duration)->cascade();
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
                                                                    {{ __('Play Now')}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="block-social-info">
                                                            <ul class="list-inline p-0 m-0 music-play-lists">
                                                                <li><span><i class="ri-heart-fill"></i></span></li>
                                                                <li><span><i class="ri-add-line"></i></span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                {{-- </a> --}}
                                            </li>
                                        @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <p>No media available for this channel.</p>
                @endif
            </div>
        </div>
    @endforeach

</section>

