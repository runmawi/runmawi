<section id="iq-favorites">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title">Live Category Video</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline p-0 mb-0">
                      <?php if(isset($LiveCategory)) {
                        foreach($LiveCategory as $livestream_videos){ ?>
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <div class="block-images position-relative">
                                        <a href="{{ URL::to('live/'.$livestream_videos->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <p> {{ strlen($livestream_videos->title) > 17 ? substr($livestream_videos->title, 0, 18) . '...' : $livestream_videos->title }}</p>
                                                
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <span class="text-white">
                                                        @if($livestream_videos->duration != null)
                                                            @php
                                                                $duration = Carbon\CarbonInterval::seconds($livestream_videos->duration)->cascade();
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
                            
                           <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


