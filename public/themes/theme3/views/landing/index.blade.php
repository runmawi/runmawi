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

        {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest-videos', ['data' => $latest_video, ])->content() !!}
        
    </head>

    <body>

                        {{-- Banner --}}

            <div class="banner" style="background: url('{{ URL::to('assets/img/cad-landing.png') }}');background-repeat: no-repeat;background-size: cover; height:calc(100vh - 164px);">
                <!-- <h4 class="postition-relative">{{ 'Not Your Ordinary streaming service' }}</h4> -->
            </div>
                       

                {{-- About section --}}

                <div class="container-fluid mt-4">
                    <p class="container-fluid text-center mt-5"> {{ 'CADENCE gives you access to one of the largest resources dedicated to music on film; “live” and studio performance, movies, interviews, documentaries, tutors, professional advice and more... Around the world, from Afghanistan to Zimbabwe; with every instrument, from the Accordion to the Zurna. It is a unique streaming service, created and curated by music fans for music fans' }}</p>

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

                <div class="container-fluid">
                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline p-0 mb-0">
                            @foreach ($data as $key => $latest_video)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        
                                        <a href="">

                                            <div class="img-box">
                                                <img src="{{ @$latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                

                                                <div class="hover-buttons">
                                                    <a class="" href="">
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
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                    {{-- Section 4  --}}
        @foreach ($sections_4 as $section_4)

            @php echo html_entity_decode($section_4) @endphp
            
        @endforeach

        <script>
            document.write("<?php echo ( $script_content); ?>");
        </script>

                {{-- Footer --}}
        @if ( $footer == 1)
          @php include(public_path('themes/theme3/views/footer.blade.php')); @endphp 
        @endif

    </body>
</html>