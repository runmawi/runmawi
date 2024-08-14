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
		background: #ED563C;
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
        height: 150px;
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

            {{-- <img src="https://img.freepik.com/free-photo/gradient-dark-blue-futuristic-digital-grid-background_53876-129728.jpg?t=st=1720699527~exp=1720703127~hmac=009af48450d1394e58f536f81a4a956cf075db589e1d9b6cc33c6d3026708d54&w=826" style="border-radius: 30px; width:100%; height:200px; " alt="banner" > --}}

            <div class="row justify-content-center m-1">
                <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#ugc-profile-modal').modal('show');">
                    <img
                    src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  style="border-radius: 30px; height:200px; " alt="banner" >
                </a>
            </div>
            <div class="row justify-content-start mx-3">
                <div >
                <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#ugc-profile-modal').modal('show');">
                <img class="rounded-circle img-fluid text-center mb-3 mt-4"
                src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile-bg" style="height: 80px; width: 80px;">
                </a>
                </div>
               <div class="col" style="padding-top: 40px;" >
                <div>
                <h4>{{$user->username}}</h4>
                </div>
                {{-- <div>
                   <h5>Entertainmnt channel </h5>
                </div> --}}
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
                                <textarea id="ugc-about" name="ugc-about" value=""  disabled placeholder="Enter About You">{{ $user->ugc_about ? $user->ugc_about : '' }}</textarea>
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
                                    <textarea id="ugc-facebook" disabled name="ugc-instagram" value="" placeholder="Enter About You" rows="1" >{{ $user->ugc_facebook ? $user->ugc_facebook : '' }}</textarea>
                                </form>
                            </div>
                        </p>
                        </div>
                        <div class="py-2">
                        <h5>Instagram</h5>
                        <p style="color: white">
                            <div class="ugc-social-media" style="position: relative" >
                                <form>
                                    <textarea id="ugc-instagram" disabled name="ugc-instagram" placeholder="Enter About You" rows="1" >{{ $user->ugc_instagram ? $user->ugc_instagram : '' }}</textarea>
                                </form>
                            </div>
                        </p>
                        </div>
                        <div class="py-2">
                        <h5>Twitter</h5>
                        <p style="color: white">
                            <div class="ugc-social-media" style="position: relative" >
                                <form>
                                    <textarea id="ugc-twitter" disabled name="ugc-twitter" placeholder="Enter About You" rows="1" >{{ $user->ugc_twitter ? $user->ugc_twitter : '' }}</textarea>
                                </form>
                            </div>
                        </p>
                        </div>
                    </div>
                    <div class="row pt-4" >
                        <div class="col-lg-6 col-md-12 mb-4"> 
                            <h2>Profile Details</h2>
                            <div class="text-white pt-4">
                            <p style="font-weight: 600; font-size: 18px;">Profile link: <span style="font-weight: 100; font-size:15px;" >nemisa.com</span></p> 
                            </div>
                            <div class=" text-white">
                            <p style="font-weight: 600; font-size: 18px;">Total videos: <span style="font-weight: 100; font-size:15px;" >{{ $user->ugcVideos->count() ? $user->ugcVideos->count() : 0 }}</span></p> 
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
                            <button style="background:#ED563C!important;color: #ffff!important; padding: 5px 100px !important; margin:0% "  class="ugc-button" >Share Profile</button>
                            </div>
                        </div>
                        
                        {{-- <div class="col-lg-6 col-md-12 mb-4 mx-auto" > 
                                <h2>My Acount
                                    <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#add-new').modal('show');"><i class="fa fa-plus-circle"></i>
                                        <span style="font-size:15px;" >Edit</span>
                                    </a>
                                </h2>
                                <div class=" text-white pt-4">
                                <p style="font-weight: 600; font-size: 18px;">First Name: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span></p> 
                                </div>
                                <div class=" text-white">
                                <p style="font-weight: 600; font-size: 18px;">User Name: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span></p> 
                                </div>
                                <div class=" text-white">
                                <p style="font-weight: 600; font-size: 18px;">Email-id: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></span></p> 
                                </div>
                                <div class=" text-white">
                                <p style="font-weight: 600; font-size: 18px;">Cell Phone: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></span></p> 
                                </div>
                                <div class=" text-white">
                                    <p class="row">
                                        <span class="col-lg-2 text-left" style="font-weight: 600; font-size: 18px;">Gender:</span>
                                        <span class="col-lg-5 text-left"> 
                                            <select class="form-control" id="gender" name="gender">
                                                <!-- <option value="null" @if(!empty($user->gender) && $user->gender == "null" ){{ 'selected' }}@endif>   Gender </option> -->
                                                <option value="Male" @if(!empty($user->gender) && $user->gender == 'Male'){{ 'selected' }}@endif>  Male </option>
                                                <option value="Female" @if(!empty($user->gender) && $user->gender == 'Female'){{ 'selected' }}@endif> Female </option>
                                                <!-- <option value="Others" @if(!empty($user->gender) && $user->gender == 'Others'){{ 'selected' }}@endif > Others </option> -->
                                            </select>
                                        </span>
                                    </p>
                                </div>
                                <div class=" text-white">
                                <p style="font-weight: 600; font-size: 18px;">DOB: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></span></p> 
                                </div>
                        </div> --}}
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
                                <div class="ugc-actions" >
                                    <div style="border-radius: 7px; background-color:#ED563C; padding:2px 10px; " >
                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Meta"
                                        data-original-title="Edit Meta" href="{{ URL::to('ugc-edit') . '/' . $eachugcvideos->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                            </svg>
                                        </a>
                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Video"
                                        data-original-title="Edit Video" href="{{ URL::to('admin/videos/editvideo') . '/' . $eachugcvideos->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                            </svg>
                                        </a>
                                        <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="Delete Video"
                                        data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/videos/delete') . '/' . $eachugcvideos->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                

                            <div class="text-white pt-3">
                                <h6>{{$eachugcvideos->title}}</h6>
                                <p style="margin:5px 0px;">{{$user->name}}</p>
                                <p> {{$eachugcvideos->created_at->diffForHumans()}} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} views
                                    | 90k Likes</p>
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
                                    <div class="ugc-actions" >
                                        <div style="border-radius: 7px; background-color:#ED563C; padding:2px 10px; " >
                                            <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Meta"
                                            data-original-title="Edit Meta" href="{{ URL::to('ugc-edit') . '/' . $eachugcvideos->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                </svg>
                                            </a>
                                            <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Video"
                                            data-original-title="Edit Video" href="{{ URL::to('admin/videos/editvideo') . '/' . $eachugcvideos->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                </svg>
                                            </a>
                                            <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="Delete Video"
                                            data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/videos/delete') . '/' . $eachugcvideos->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                    
    
                                <div class="text-white pt-3">
                                    <h6>{{$eachugcvideos->title}}</h6>
                                    <p style="margin:5px 0px;">{{$user->name}}</p>
                                    <p> {{$eachugcvideos->created_at->diffForHumans()}} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} views
                                        | 90k Likes</p>
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