{{-- Header --}}
@php 
    include(public_path('themes/theme3/views/header.php')); 
    include(public_path('themes/theme7/views/ChannelPartner/channelpartner_style.blade.php')); 
@endphp

    <section class="sign-in-page" style="background: linear-gradient(86.02deg, #04152C 12.81%, rgba(0, 0, 0, 0) 95.61%), url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover; ">
        
           
                    <div class="cpp">
                        <div class="container-fluid">
                            <p class="text-white"> {{ __('Subscription Plans') }}</p>
                            <div class="col-lg-8 p-0">
                                <h1 class="">{{ __('Introducing bundled subscription plans at special introductory prices') }}</h1>
                            </div>
 
                            <div class="col-lg-4 p-0">
                                <img class="w-100" src="<?php echo  URL::to('/assets/img/pink.png')?>" >
                            </div>

                            <div class="row justify-content-between mt-4">
                                @forelse ($channel_partner_list as  $key => $channel_partners)
                                <div class="col-lg-6 p-0">
                                    
                                    <div class="row dm align-items-center">
                                        <div class="col-md-6">
                                        <h2>{{ __('Power Play') }}</h2>
                                        <p>{{ __('All 5 OTTs in one pack') }}</p>
                                        <h2 class="per mt-4">$ 1999per yr <br><span>{{ __('Save upto') }} $12500</span></h2>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 p-0">
                                                <img class="col-md-12 bg-white"  src="<?php echo  URL::to('/assets/img/s1.png')?>" >
                                                <img class="bg-white"   src="<?php echo  URL::to('/assets/img/s3.png')?>" >
                                                <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s4.png')?>" >
                                            </div>

                                            <div class="col-md-4 p-0">
                                                <img class="bg-white" src="<?php echo  URL::to('/assets/img/s2.png')?>" >
                                                <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s5.png')?>" >
                                            </div>
                                            <a class="cpp-btn" href="https://www.w3schools.com">{{ __('Start') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                   @empty
                        </div>
                    </div>
         

                <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                    <p ><h2 style="position: absolute;top: 50%;left: 50%;color: white;">{{ __('No Channels Available Now') }} </h2>
                </div>
                
            @endforelse
    </section>

{{-- Footer --}}
@php include(public_path('themes/theme3/views/footer.blade.php')); @endphp