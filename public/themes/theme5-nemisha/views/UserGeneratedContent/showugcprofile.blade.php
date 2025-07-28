@php
    include public_path('themes/theme5-nemisha/views/header.php');
    $settings = App\Setting::first();
@endphp

<style>
      .ugc-button{
        margin: 5px;
        padding: 3px 30px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    ul.ugc-tabs{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}

	ul.ugc-tabs li{
		background: #848880;
		color: #fff;
		display: inline-block;
        margin: 5px;
        padding: 3px 30px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
		cursor: pointer;
	}

    ul.ugc-tabs li.ugc-current{
		background: #ed1c24;
		color: #fff;
	}

    .ugc-tab-content{
		display: none;
	}

	.ugc-tab-content.ugc-current{
		display: inherit;
	}

    .ugc-videos img{
        width: 100%;
        height: 180px;
        border-radius: 15px;
    }

#submit_about {
    color: green;
}

#submit_facebook {
    color: green;
}

#submit_instagram {
    color: green;
}

#submit_twitter {
    color: green;
}

.video-form-control{
        width:100%;
        background-color: #c9c8c888 ;
        border:none;
        padding: 3px 10px;
        border-radius: 7px;
    }

        .input-container {
            position: relative;
            width: 100%;
            max-width: 100%;
            border-radius: 10px;
        }

        .input-container textarea {
            background-color: #848880;
            color: white;
            border-radius: 10px;
            width: 100%;
            height: 100px;
            padding: 15px;
            border: none;
            resize: none;
            font-size: 16px;
        }

        .input-container button {
            position: absolute;
            right: 10px; /* Aligns button to the right */
            bottom: 10px; /* Aligns button to the bottom */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 24px;
            display: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

         .input-container button:hover {
            background-color: #45a049;
        }

        .ugc-social-media {
            width: 100%;
            max-width: 100%;
            border-radius: 10px;
        }

        .ugc-social-media textarea {
            background-color:transparent;
            color: white;
            width: 100%;
            border: none;
            resize: none;
            font-size: 16px;
        }

        .ugc-social-media button {
            position: absolute;
            right: 10px; /* Aligns button to the right */
            bottom: 10px; /* Aligns button to the bottom */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 24px;
            display: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .ugc-social-media button:hover {
            background-color: #45a049;
        }

        .ugc-actions {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
        }

        .ugc-videos:hover .ugc-actions {
            display: block;
        }
</style>

<div class="">
    <section class="m-profile setting-wrapper pt-0">
        <div class="container">


            <div class="row justify-content-center m-1">
                <a class="Text-white" href="javascript:;">
                    <img
                    src="<?= $user->ugc_banner ? URL::to('/') . '/public/uploads/ugc-banner/' . $user->ugc_banner : '' ?>"  style="border-radius: 30px; height:auto; width:100%; cursor:auto;" alt="banner" >
                </a>
            </div>

            <div class="row justify-content-start mx-3">
                <div >
                <a class="Text-white" href="javascript:;">
                <img class="rounded-circle img-fluid text-center mb-3 mt-4"
                src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile-bg" style="height: 80px; width: 80px; cursor:auto; ">
                </a>
                </div>
               <div class="col" style="padding-top: 40px;" >
                <div>
                <h6>{{$user->username}}</h6>
                </div>
                <div class="py-2" >
                    @if($user->subscribers_count == 0 )
                    <p style="color: white; font-size:18px;" >No Subscribers</p>
                    @elseif($user->subscribers_count == 1 )
                    <p style="color: white; font-size:18px;" >1 Member Subscribed</p>
                    @else
                    <p style="color: white; font-size:18px;" >
                     <span class="subscriber-count"> {{ $user->subscribers_count }} </span> Members Subscribed
                    </p>
                    @endif
                </div>
               </div>
            </div>
           
            <ul class="ugc-tabs mx-3">
                <li class="tab-link ugc-current" data-tab="ugc-tab-1">Bio</li>
                <li class="tab-link" data-tab="ugc-tab-2">Videos</li>
                <li class="tab-link" data-tab="ugc-tab-3">Playlist</li>
            </ul>

            <div id="ugc-tab-1" class="ugc-tab-content ugc-current">
                <div class="col-12 pt-3">
                    <div>
                        <h2>About</h2>

                        <div class="input-container" style="position: relative" >
                            <form>
                                <textarea id="ugc-about" name="ugc-about" value=""  disabled placeholder="-">{{ $user->ugc_about ? $user->ugc_about : '' }}</textarea>
                            </form>
                        </div>
                    </div>
                    <div class="pt-4" >
                        <h2>Links</h2>
                        <div class="py-2">
                        <h5>Facebook</h5>
                        <p style="color: white">
                            <div class="ugc-social-media" style="position: relative" >
                                <form>
                                    <textarea id="ugc-facebook" disabled name="ugc-instagram" value="" placeholder="-" rows="1" >{{ $user->ugc_facebook ? $user->ugc_facebook : '' }}</textarea>
                                </form>
                            </div>
                        </p>
                        </div>
                        <div class="py-2">
                        <h5>Instagram</h5>
                        <p style="color: white">
                            <div class="ugc-social-media" style="position: relative" >
                                <form>
                                    <textarea id="ugc-instagram" disabled name="ugc-instagram" placeholder="-" rows="1" >{{ $user->ugc_instagram ? $user->ugc_instagram : '' }}</textarea>
                                </form>
                            </div>
                        </p>
                        </div>
                        <div class="py-2">
                        <h5>Twitter</h5>
                        <p style="color: white">
                            <div class="ugc-social-media" style="position: relative" >
                                <form>
                                    <textarea id="ugc-twitter" disabled name="ugc-twitter" placeholder="-" rows="1" >{{ $user->ugc_twitter ? $user->ugc_twitter : '' }}</textarea>
                                </form>
                            </div>
                        </p>
                        </div>
                    </div>
                    <div class="row pt-4" >
                        <div class="col-lg-6 col-md-12 mb-4"> 
                            <h2>Profile Details</h2>
                            <div class="text-white pt-4">
                            <p style="font-weight: 600; font-size: 18px;">Profile link: <span style="font-weight: 100; font-size:15px;" >
                                <a href="{{ route('profile.show', ['username' => $user->username]) }}"> {{ route('profile.show', ['username' => $user->username]) }} </a>    
                            </span></p> 
                            </div>
                            <div class=" text-white">
                            <p style="font-weight: 600; font-size: 18px;">Total videos: <span style="font-weight: 100; font-size:15px;" >{{ $totalVideos ? $totalVideos : 0 }}</span></p> 
                            </div>
                            <div class=" text-white">
                            <p style="font-weight: 600; font-size: 18px;" >Total views: <span style="font-weight: 100; font-size:15px;" >{{ $totalViews ? $totalViews : 0 }} views</span></p> 
                            </div>
                            <div class=" text-white">
                            <p style="font-weight: 600; font-size: 18px;" >Joined: <span style="font-weight: 100; font-size:15px;" >{{ $user->created_at ? $user->created_at->format('d F Y') : '' }}</span></p> 
                            </div>
                            <div class=" text-white">
                            <p style="font-weight: 600; font-size: 18px;" >Location: <span style="font-weight: 100; font-size:15px;" >{{ $user->location ? $user->location : '' }}</span></p> 
                            </div>
                            <div>
                            <button style="background:#ed1c24!important;color: #ffff!important; padding: 5px 100px !important; margin:0%; cursor:pointer; border:none; "  class="ugc-button" >Share Profile</button>
                            </div>
                            <div class="shareprofile">
                                <div class="d-flex bg-white p-2" style="width: 100px; border-radius:10px;  "> 
                                    <div class="d-flex">
                                    <div class="px-1">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('profile.show', ['username' => $user->username]) }}" target="_blank">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                    </div>
                                    <div class="px-1">
                                    <a href="https://twitter.com/intent/tweet?text={{ route('profile.show', ['username' => $user->username]) }}" target="_blank">
                                        <i class="ri-twitter-fill"></i>
                                    </a>
                                    </div>
                                    <div class="px-1">
                                       <a href="#" onclick="Copy();" class="share-ico"><i class="ri-links-fill" ></i></a>
                                       <input type="hidden" id="profile_url" value="{{ route('profile.show', ['username' => $user->username]) }}">
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    
                </div>
            </div>

         <div id="ugc-tab-2" class="ugc-tab-content">
              
            <div class="row mx-3">
            @foreach ($ugcvideos as $eachugcvideos)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                
                 <a href="{{ url('ugc/video-player/' . $eachugcvideos->slug) }}" class="m-1">
                            <div class="ugc-videos" style="position: relative;" >
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
                            </div>
                

                            <div class="text-white pt-3">
                                <h6>{{$eachugcvideos->title}}</h6>
                                <p style="margin:5px 0px;">{{$user->username}}</p>
                                <p> {{$eachugcvideos->created_at->diffForHumans()}} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} views
                                    | {{$eachugcvideos->like_count}} Likes</p>
                            </div>
                </a>
            </div>
            @endforeach
            </div>

            <div class="mt-3 pull-right" >
                {{ $ugcvideos->links() }}
            </div>
        </div>

        <div id="ugc-tab-3" class="ugc-tab-content">
              
            <div class="row mx-3">
            @foreach ($ugcvideos as $eachugcvideos)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                
                 <a href="{{ url('ugc/video-player/' . $eachugcvideos->slug) }}" class="m-1">
                            <div class="ugc-videos" style="position: relative;" >
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
                            </div>
                

                            <div class="text-white pt-3">
                                <h6>{{$eachugcvideos->title}}</h6>
                                <p style="margin:5px 0px;">{{$user->username}}</p>
                                <p> {{$eachugcvideos->created_at->diffForHumans()}} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} views
                                    | {{$eachugcvideos->like_count}} Likes</p>
                            </div>
                </a>
            </div>
            @endforeach
            </div>

            <div class="mt-3 pull-right" >
                {{ $ugcvideos->links() }}
            </div>
        </div>

        
        </div>
        </div>


    </section>
</div>

@php
include (public_path('themes/theme5-nemisha/views/footer.blade.php'))
@endphp



<script>
    function Copy() {
    var profile_url = $('#profile_url').val();
    var url =  navigator.clipboard.writeText(window.location.href);
    var profile =  navigator.clipboard.writeText(profile_url);
    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
           setTimeout(function() {
            $('.add_watch').slideUp('fast');
           }, 3000);
    }
  
</script>  

<script>
    $(document).ready(function(){
        
        $('ul.ugc-tabs li').click(function(){
            var tab_id = $(this).attr('data-tab');
    
            $('ul.ugc-tabs li').removeClass('ugc-current');
            $('.ugc-tab-content').removeClass('ugc-current');
    
            $(this).addClass('ugc-current');
            $("#"+tab_id).addClass('ugc-current');
        })
    
    })
</script>

<script>
    $('.shareprofile').hide()
    jQuery('.ugc-button').on('click',function(){
    jQuery('.shareprofile').toggle();
})    
</script>
