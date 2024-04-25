<!DOCTYPE html>
<html lang="en">
    <head>
            {{-- Header --}}

        @php
            include public_path('themes/theme3/views/header.php');
        @endphp
        

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{  $meta_title ? $meta_title.' | '.GetWebsiteName() : 'Landing-page'.' | '.GetWebsiteName() }}</title>
        
        <meta name="title" content="{{  $meta_title ? $meta_title : GetWebsiteName() }}">
        <meta name="description" content="{{  $meta_description ? $meta_description : Getwebsitedescription() }}" />
        <meta name="keywords" content="{{  $meta_keywords ? $meta_keywords : $meta_keywords }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

                            {{-- Boostrap --}}
         <?php  echo  $bootstrap_link ;  ?>
         
                            {{--Google fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800&display=swap" rel="stylesheet">
                
                            {{-- Favicon icon --}}
        <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">

                            {{-- custom css --}}
        <?php  echo  ( $custom_css);  ?>

                        {{-- Style css --}}
        <link rel="stylesheet" href="<?= URL::to('public\themes\theme3\assets\css\landingpage.css') ?>">

        
    </head>

    <body>

                        {{-- Banner --}}

            <div class="banner" style="background: url('{{ URL::to('assets/img/cad-landing.png') }}');background-repeat: no-repeat;background-size: cover; height:calc(100vh - 164px);">
                <!-- <h4 class="postition-relative">{{ 'Not Your Ordinary streaming service' }}</h4> -->
            </div>
                       

        <section class="video-sections pb-5">
                {{-- About section --}}

                <div class="container-fluid pt-4">
                    <p class="container-fluid text-center m-0"> {{ "CADENCE gives you access to one of the largest resources dedicated to music on film; “live” and studio performance, " }}</p>
                    <p class="container-fluid text-center m-0"> {{ "movies, interviews, documentaries, tutors, professional advice and more... Around the world, from Afghanistan to " }}</p>
                    <p class="container-fluid text-center m-0"> {{ "Zimbabwe; with every instrument, from the Accordion to the Zurna. It is a unique streaming service, created and curated" }}</p>
                    <p class="container-fluid text-center m-0"> {{ "by music fans for music fans  " }}</p>

                    <div class="mail-address">
                        <h5 class="font-weight-bold text-center text-primary mt-5" style="color: var(--iq-primary) !important;">{{ 'Create or restart your CadEnce membership to unlock a world of music on film' }}</h5>
                    
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="input-group mt-3 mb-3">
                                    <div class="col-9 p-0">
                                        <input type="text" class="form-control" placeholder="Email address" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    </div>
                                    <div class="col-3 pl-1">
                                        <button class="btn btn-outline-secondary text-white font-weight-bold w-100" type="button">GO</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


      

                {{-- Videos section --}}

                <?php 
                    $check_Kidmode = 0 ;

                    $data = App\VideoCategory::query()->whereHas('category_videos', function ($query) use ($check_Kidmode) {
                        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

                        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                            $query->whereNotIn('videos.id', Block_videos());
                        }

                        if ($check_Kidmode == 1) {
                            $query->whereBetween('videos.age_restrict', [0, 12]);
                        }
                    })

                    ->with(['category_videos' => function ($videos) use ($check_Kidmode) {
                        $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','description','videos.trailer','videos.trailer_type')
                            ->where('videos.active', 1)
                            ->where('videos.status', 1)
                            ->where('videos.draft', 1);

                        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                            $videos->whereNotIn('videos.id', Block_videos());
                        }

                        if ($check_Kidmode == 1) {
                            $videos->whereBetween('videos.age_restrict', [0, 12]);
                        }

                        $videos->latest('videos.created_at')->get();
                    }])
                    ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
                    ->where('video_categories.in_home', 1)
                    ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
                        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

                        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                            $query->whereNotIn('videos.id', Block_videos());
                        }

                        if ($check_Kidmode == 1) {
                            $query->whereBetween('videos.age_restrict', [0, 12]);
                        }
                    })
                    ->orderBy('video_categories.order')
                    ->get()
                    ->map(function ($category) {
                        $category->category_videos->map(function ($video) {
                            $video->image_url = URL::to('/public/uploads/images/'.$video->image);
                            $video->Player_image_url = URL::to('/public/uploads/images/'.$video->player_image);
                            return $video;
                        });
                        $category->source =  "category_videos" ;
                        return $category;
                    });
                ?>

                @if (!empty($data) && $data->isNotEmpty())
                    @foreach( $data as $key => $video_category )
                        <section id="iq-favorites">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12 overflow-hidden">


                                        <div class="favorites-contens">
                                            <ul class="favorites-slider list-inline p-0 mb-0">
                                                @foreach ($video_category->category_videos as $key => $latest_video)
                                                    <li class="slide-item">
                                                            <div class="block-images position-relative">
                                                                <a href="{{ $latest_video->image ? URL::to('category/videos/'.$latest_video->slug ) : default_vertical_image_url() }}">
                                                                
                                                                    <div class="img-box">
                                                                        <img src="{{  URL::to('public/uploads/images/'.$latest_video->image) }}" class="img-fluid" alt="">
                                                                    </div>
                                                                    <div class="block-description">
                                                                        

                                                                        <div class="hover-buttons">
                                                                            <a>
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
                                                                </a>

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
                    @endforeach
                @endif
                                    


        </section>

                    {{-- Section 4  --}}
        <div class="container-fluid ">
            <div class="row justify-content-center">
                <div class="col-12 mt-5">
                    <h6 class="text-center">{{ "“Music - the art of arranging sounds in time to produce a composition through the elements of melody," }}</h6>
                    <h6 class="text-center">{{ "harmony, rhythm, and timbre." }}</h6>
                    <h6 class="text-center">{{ "It is one of the universal cultural aspects of all human societies.”" }}</h6>
                </div>

                <div class="col-lg-6 col-12 together-img mt-5">
                    <img src="<?php echo URL::to('/assets/img/togethers.webp'); ?>" width="100%" alt="together">
                </div>
            </div>

            <!-- faq -->

            <div class="row justify-content-center">
                <div class="col-lg-6 col-12">
                    <span>
                        <h3 class="vid-title mt-4 pb-2">{{ __('Frequently asked questions?') }}</h3>
                    </span>
                    <details>
                        <summary>
                            <span class="d-flex justify-content-between">
                                <p>{{ "What is Cadence?" }}</p>
                                <span class="material-symbols-outlined"><i class="fa fa-caret-down" aria-hidden="true"></i></span>  
                            </span>
                        </summary>
                        <p>We think of Raycast as a productivity layer that everybody should use to get work done faster. To make it accessible, we don't charge for the individual plan. The plan covers all built-in extensions, such as Clipboard History, Calendar or Window Management and provides access to all public extensions built by our community.</p>
                    </details>
                    
            
                    
                    <details>
                        <summary>
                            <span class="d-flex justify-content-between">
                                <p>{{ "Where can i watch Cadence?" }}</p>
                                <span class="material-symbols-outlined"><i class="fa fa-caret-down" aria-hidden="true"></i></span>  
                            </span>
                        </summary>
                        <p>We don't have an exact date right now, but we will launch Raycast for Teams in 2022. You can sign up to get early access above, and be the first to hear when we're launching it.</p>
                    </details> 
                    
                    
                    
                    <details>
                        <summary>
                            <span class="d-flex justify-content-between">
                                <p>{{ "How do i sign up to the Cadence project?" }}</p>
                                <span class="material-symbols-outlined"><i class="fa fa-caret-down" aria-hidden="true"></i></span>  
                            </span>
                        </summary>
                        <p>We don't have an exact date right now, but we will launch Raycast for Teams in 2022. You can sign up to get early access above, and be the first to hear when we're launching it.</p>
                    </details>
                    
                    
                    
                    <details>
                        <summary>
                            <span class="d-flex justify-content-between">
                                <p>{{ "What can i expect from cadence?" }}</p>
                                <span class="material-symbols-outlined"><i class="fa fa-caret-down" aria-hidden="true"></i></span>  
                            </span>
                        </summary>
                        <p>Yes, you can create personal Extensions that are personalized to you, and speed up your productivity, and have team Extensions that can be shared around in your organization for everyone to use. Team Extensions will be available in the Store command, behind a filter for your Team. This is where all of your Team Extensions will live, and where you can install them.</p>
                    </details>
                    
                    
                    
                    <details>
                        <summary>
                            <span class="d-flex justify-content-between">
                                <p>{{ "Could i license film to the cadence project?"}}</p>
                                <span class="material-symbols-outlined"><i class="fa fa-caret-down" aria-hidden="true"></i></span>  
                            </span>
                        </summary>
                        <p>Team features will cost $10 per user, per month.</p>
                    </details>

                    <details>
                        <summary>
                            <span class="d-flex justify-content-between">
                                <p>{{ "Can I receive news about the latest from Cadence?"}}</p>
                                <span class="material-symbols-outlined"><i class="fa fa-caret-down" aria-hidden="true"></i></span>  
                            </span>
                        </summary>
                        <p>Team features will cost $10 per user, per month.</p>
                    </details>

                    <details>
                        <summary>
                            <span class="d-flex justify-content-between">
                                <p>{{ "How and when can I cancel my Candence subscription?"}}</p>
                                <span class="material-symbols-outlined"><i class="fa fa-caret-down" aria-hidden="true"></i></span>  
                            </span>
                        </summary>
                        <p>Team features will cost $10 per user, per month.</p>
                    </details>
                    
                </div>
            </div>

            <div class="virtually">
                <h6 class="font-weight-bold text-center">{{ "From the Familiar to the virtually unknown, from the classic to the obscure, you will find it on CADENCE" }}</h6>
            </div>
            

            <div class="row justify-content-center">
                <div class="col-lg-6 col-12 together-img mt-5">
                    <img src="<?php echo URL::to('/assets/img/Characters.webp'); ?>" width="100%" alt="together">
                </div>
                <div class="virtually1 mt-3">
                    <h6 class="font-weight-bold text-center">{{ "Mississippi John Hurt performing at the 1963 Newport Folk Festival (Ann Characters)" }}</h6>
                </div>
            </div>

            <div class="flim-wanted">
                <h5 class="text-center font-weight-bold mb-5">{{ "Films Wanted" }}</h5>
                <h6 class="text-center font-weight-bold">{{ "Do you own the copyright to music related film?" }}</h6>
                <h6 class="text-center font-weight-bold">{{ "Would you be interested in licensing them for the CADENCE projects?" }}</h6>
                <h6 class="text-center font-weight-bold">{{ "If you own music related film, Such as “Live” Performance," }}</h6>
                <h6 class="text-center font-weight-bold">{{ "Studio Performance, Documentaries, Interviews, Movies, Tutors, Educational..." }}</h6>
                <h6 class="text-center font-weight-bold">{{ "then we are interested." }}</h6>
                <h6 class="text-center font-weight-bold">{{ "Whether you have just one video, tens, hundreds or thousands in good quality" }}</h6>
            </div>
        </div>

        <script>
            document.write("<?php echo ( $script_content); ?>");
        </script>

                {{-- Footer --}}
        @if ( $footer == 1)
          @php include(public_path('themes/theme3/views/footer.blade.php')); @endphp 
        @endif

    </body>

    @php
        include public_path('themes/theme3/views/footer.blade.php');
    @endphp
</html>