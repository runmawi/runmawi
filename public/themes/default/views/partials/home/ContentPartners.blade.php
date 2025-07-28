    
@if (!empty($data) && $data->isNotEmpty())

<section id="iq-favorites">
    <div class="container-fluid overflow-hidden">
        <div class="row">
            <div class="col-sm-12 ">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title">
                        <a href="{{ $order_settings_list[14]->header_name ? url('/') . '/' . $order_settings_list[14]->url : '' }}">
                            {{ $order_settings_list[14]->header_name ? __($order_settings_list[14]->header_name) : '' }}
                            <?php $settings = App\Setting::first(); ?>
                        </a>
                    </h4>
                    @if($settings->homepage_views_all_button_status == 1)
                        <h4 class="main-title view-all"><a href="{{ $order_settings_list[14]->header_name ? url('/') . '/' . $order_settings_list[14]->url : '' }}">{{ __('View all') }}</a></h4>
                    @endif
                </div>

                <div class="favorites-contens">
                    <div class="content-partner home-sec list-inline row p-0 mb-0">
                        @if(isset($data))
                            @foreach($data as $content_user)
                                <div class="items">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('/contentpartner/' . $content_user->slug) }}">
                                                    <img data-flickity-lazyload="{{ $content_user->picture ? $content_user->picture : URL::to('public/uploads/images/'.$default_vertical_image_url) }}" data-src="{{ $content_user->picture ? $content_user->picture : URL::to('public/uploads/images/'.$default_vertical_image_url) }}" class="img-fluid w-100" alt="{{ $content_user->username }}">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <div class="hover-buttons text-white">
                                                <a href="{{ url('/contentpartner/' . $content_user->slug) }}">
                                                    <p class="epi-name text-left m-0">{{ __($content_user->username) }}</p>
                                                </a>
                                                <a class="epi-name mt-2 mb-0 btn" href="{{ url('/contentpartner/' . $content_user->slug) }}">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    {{ __('Visit Content Partner') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endif

<script>
    var elem = document.querySelector('.content-partner');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: 7,
    });
 </script>