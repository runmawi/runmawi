@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[13]->url ? URL::to($order_settings_list[13]->url) : null }} ">{{ optional($order_settings_list[13])->header_name }}</a>
                        </h4>
                    </div>

                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ($data as $channel)

                                @php
                                    $UserChannelSubscription = null ;

                                    $all_channel_redirection_url = route('ChannelHome', $channel->channel_slug);
                                    $all_channel_button =  "Visit" ;

                                    if ($settings->user_channel_plans_page_status == 1){

                                        if (!Auth::guest()) {

                                            $UserChannelSubscription = App\UserChannelSubscription::where('user_id',auth()->user()->id)
                                                                            ->where('channel_id',$channel->id)->where('status','active')
                                                                            ->where('subscription_start', '<=', Carbon\Carbon::now())
                                                                            ->where('subscription_ends_at', '>=', Carbon\Carbon::now())
                                                                            ->latest()->first();
                                        }

                                        if (!Auth::guest() && Auth::user()->role != "admin"){


                                            $all_channel_redirection_url = is_null($UserChannelSubscription) ? route('channel.all_Channel_home') : route('ChannelHome', $channel->channel_slug);
                                            $all_channel_button = is_null($UserChannelSubscription) ? "Subscribe" : "Visit" ;

                                        }elseif(!Auth::guest() && Auth::user()->role == "admin"){

                                            $all_channel_redirection_url = route('ChannelHome', $channel->channel_slug);
                                            $all_channel_button =  "Visit" ;

                                        }elseif( Auth::guest() ){

                                            $all_channel_redirection_url = route('login');
                                            $all_channel_button =  "Subscribe" ;
                                        }
                                    }
                                @endphp

                                <li class="slide-item">
                                    <a href="{{ $all_channel_redirection_url }}">
                                        <div class="block-images position-relative">
                                          
                                            <div class="img-box">
                                                <img src="{{ $channel->channel_logo ? $channel->channel_logo : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <p>{{ ucwords(optional($channel)->channel_name) }}</p>

                                                <div class="movie-time d-flex align-items-center my-2"></div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __($all_channel_button) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <!-- <li><span><i class="ri-volume-mute-fill"></i></span></li> -->
                                                    {{-- <li><span><i class="ri-heart-fill"></i></span></li>
                                                    <li><span><i class="ri-add-line"></i></span></li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif