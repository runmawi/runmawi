@include('avod::ads_header')

<!-- videojs-contrib-ads CSS and Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/6.6.6/videojs-contrib-ads.min.js"></script>

{{-- video-js Style --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link rel="stylesheet" href="<?= URL::to('/') . '/public/themes/default/assets/css/video-js/videojs.min.css' ?>" />
<link rel="stylesheet" href="<?= URL::to('/') . '/public/themes/default/assets/css/video-js/videos-player.css' ?>" />

{{-- video-js Script --}}
<script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="<?= URL::to('/') . '/assets/js/video-js/video.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/js/video-js/videojs-http-source-selector.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/js/video-js/videojs.ads.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/js/video-js/videojs.ima.min.js' ?>"></script>

<style>
    .p1 {
        font-size: 15px !important;
    }

    .black {
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
        border-radius: 0px 4px 4px 0px;
    }

    .black:hover {
        background: #fff;
        padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }


    .tags-input-wrapper {
        background: transparent;
        padding: 10px;
        border-radius: 4px;
        max-width: 400px;
        border: 1px solid #ccc
    }

    .tags-input-wrapper input {
        border: none;
        background: transparent;
        outline: none;
        width: 140px;
        margin-left: 8px;
    }

    .tags-input-wrapper .tag {
        display: inline-block;
        background-color: #20222c;
        color: white;
        border-radius: 40px;
        padding: 0px 3px 0px 7px;
        margin-right: 5px;
        margin-bottom: 5px;
        box-shadow: 0 5px 15px -2px rgba(250, 14, 126, .7)
    }

    .tags-input-wrapper .tag a {
        margin: 0 7px 3px;
        display: inline-block;
        cursor: pointer;
    }
    
    /* Video-Player CSS */
    .my-video.video-js .vjs-big-play-button{ top: 48% !important; left: 48% !important;}
    .video-js .vjs-control-bar{ height: 6em !important;}
    .vjs-play-control .vjs-icon-placeholder:before{margin-top:.33em;border-radius:4px;border:0 solid #fff0;font-size:25px}
    .vjs-icon-play:before,.my-video .video-js .vjs-play-control .vjs-icon-placeholder:before,.my-video.video-js .vjs-big-play-button .vjs-icon-placeholder:before{content:"\f101"}
    .my-video.video-js .vjs-play-progress:before{ border-radius: 5px;}
    .vjs-icon-picture-in-picture-enter:before, .my-video.video-js .vjs-picture-in-picture-control .vjs-icon-placeholder:before{ line-height: 43px !important;}
    .vjs-volume-bar.vjs-slider-horizontal{height:0.5em!important}
    .my-video.video-js .vjs-volume-level:before{font-size:1.4em}
    .vjs-slider-horizontal .vjs-volume-level:before{line-height:0em!important;top: -0.15em !important;}
    .my-video.video-js .vjs-picture-in-picture-control .vjs-icon-placeholder:before{ left: -6px !important;}
    .vjs-fullscreen-control .vjs-control .vjs-button{top: 20%;}
    .video-js .vjs-fullscreen-control .vjs-icon-placeholder:before, .vjs-icon-fullscreen-enter:before{top: 1px;font-size: 25px;left: -7px;}
    .vjs-loading-spinner{top: 49.2% !important;left: 47.8% !important;}
    .custom-skip-forward-button{left: 60% !important;}
    .custom-skip-forward-button, .custom-skip-backward-button{top: calc(100% - 53%) !important;}
    .custom-skip-forward-button svg, .custom-skip-backward-button svg{ width: 30px !important;}

</style>

    <div id="content-page" class="content-page">
        <div class=" d-flex">
            <a class="black" href="{{ route('ads-list') }}">All Advertisement</a>
            <a class="black" href="{{ route('upload_ads') }}">Add Advertisement</a>
            <a class="black" href="{{ route('ads-list') }}">Advertisement For Approval</a>
        </div>
        
        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container" style="padding: 15px;">
                    <div class="admin-section-title">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                       
                                        {{-- Heading --}}
                        <div class="d-flex justify-content-between">
                            <div> <h4>Edit Advertisement</h4> </div>
                        </div>
                        <hr>
                    </div>

                    @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $message)
                            <div class="alert alert-danger display-hide" id="successMessage">
                                <button id="successMessage" class="close" data-close="alert"></button>
                                <span>{{ $message }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="clear"></div>

                    <form action="{{ route('Ads_update', $Advertisement->id) }}" method="POST"  enctype="multipart/form-data" >
                        @csrf
                        @method('PATCH')
                        
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Ads Name: </label>
                                <p class="p1">Add the Advertisement Name in the textbox below:</p>

                                <div class="panel-body">
                                    <input type="text" class="form-control" name="ads_name" id="ads_name" placeholder="Advertisement Name"
                                        value="{!! $Advertisement->ads_name !!}" />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="m-0">Advertisement Devices</label>
                                <p class="p1">Select the Advertisement Devices </p>
                                <div class="panel-body">
                                    <select  name="ads_devices[]" class="js-example-basic-multiple" style="width:100%" multiple="multiple">
                                        <option value="website" @if ( !is_null( $Advertisement->ads_devices ) &&  in_array( 'website',json_decode( $Advertisement->ads_devices)) ) selected="true" @endif > {{ ucwords('website') }} </option>
                                        <option value="android" @if ( !is_null( $Advertisement->ads_devices ) &&  in_array( 'android',json_decode( $Advertisement->ads_devices)) ) selected="true" @endif  > {{ ucwords('android') }} </option>
                                        <option value="IOS"     @if ( !is_null( $Advertisement->ads_devices ) &&  in_array( 'IOS',json_decode( $Advertisement->ads_devices)) ) selected="true" @endif> {{ ucwords('IOS') }} </option>
                                        <option value="TV"      @if ( !is_null( $Advertisement->ads_devices ) &&  in_array( 'TV',json_decode( $Advertisement->ads_devices)) ) selected="true" @endif> {{ ucwords('TV') }} </option>
                                        <option value="roku"    @if ( !is_null( $Advertisement->ads_devices ) &&  in_array( 'roku',json_decode( $Advertisement->ads_devices)) ) selected="true" @endif> {{ ucwords('roku') }} </option>
                                        <option value="lg"      @if ( !is_null( $Advertisement->ads_devices ) &&  in_array( 'lg',json_decode( $Advertisement->ads_devices)) ) selected="true" @endif> {{ ucwords('lg') }} </option>
                                        <option value="samsung" @if ( !is_null( $Advertisement->ads_devices ) &&  in_array( 'samsung',json_decode( $Advertisement->ads_devices)) ) selected="true" @endif> {{ ucwords('samsung') }} </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Ads Category:</label>
                                <div class="panel-body">
                                    <select class="form-control" name="ads_category">
                                        @foreach ($ads_category as $key => $category)
                                            <option value="{{ $category->id }}"  {{ (!empty($Advertisement->ads_category) && $Advertisement->ads_category == $category->id) ? "selected" : " " }}> {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="m-0">Ads Position Play:</label>
                                <div class="panel-body">
                                    <select class="form-control" name="ads_position">
                                        <option value="pre"  {{ "pre" == $Advertisement->ads_position ? "selected" : null }} >Pre</option>
                                        <option value="mid"  {{ "mid" == $Advertisement->ads_position ? "selected" : null }} >Mid</option>
                                        <option value="post" {{ "post" == $Advertisement->ads_position ? "selected" : null }}>Post</option>
                                        <option value="all"  {{ "all" == $Advertisement->ads_position ? "selected" : null }}>All Position</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Ads upload Type:</label>
                                <div class="panel-body">
                                    <select class="form-control ads_type" name="ads_upload_type">
                                        <option value="null"    {{ $Advertisement->ads_upload_type == "null" ? "selected" : null }}  >select Ads Type </option>
                                        <option value="tag_url" {{ $Advertisement->ads_upload_type == "tag_url" ? "selected" : null }}  >Ad Tag Url </option>
                                        <option value="ads_video_upload" {{  $Advertisement->ads_upload_type == "ads_video_upload"? "selected" : null }} > Ads Video Upload </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 tag_url"  style="{{ $Advertisement->ads_upload_type == 'tag_url' ? 'display:block;' : 'display:none;' }}">
                                <label class="m-0">Ad Tag Url:</label>
                                <div class="panel-body">
                                    <input type="text" id="ads_path" name="ads_path"  class="form-control"
                                        value="{{ $Advertisement->ads_path }}" placeholder="Enter the Ads Tag URL" />
                                </div>
                            </div>

                            <div class="col-sm-6 ads_video_upload" style="{{ $Advertisement->ads_upload_type == 'ads_video_upload' ? 'display:block;' : 'display:none;' }}">
                                <label class="m-0">Ad Video Upload:</label>
                                <div class="panel-body">
                                    <input type="file" id="ads_video" name="ads_video" accept="video/mp4" class="form-control" />
                                    <span> {{ $Advertisement->ads_path }} </span>
                                </div>

                                <label class="m-0">Ads Redirection URL:</label>
                                <div class="panel-body">
                                    <input type="url" id="ads_redirection_url" name="ads_redirection_url"  
                                        placeholder="https://example.com"  class="form-control" value="{{ $Advertisement->ads_redirection_url }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Ads Age:</label>
                                <div class="panel-body">
                                    <div class="mt-1">
                                            <label class="checkbox-inline" >
                                                <input type="checkbox" class="age" name="age[]" value="0-17" {{  !empty(json_decode($Advertisement->age)) &&  in_array('0-17',json_decode($Advertisement->age) ) ? 'checked' : '' }} > 0-17
                                                <input type="checkbox" class="age" name="age[]" value="18-24" {{  !empty(json_decode($Advertisement->age)) &&  in_array('18-24',json_decode($Advertisement->age) ) ? 'checked' : '' }} > 18-24
                                                <input type="checkbox" class="age" name="age[]" value="25-34"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('25-34',json_decode($Advertisement->age))) ? 'checked' : '' }}> 25-34
                                                <input type="checkbox" class="age"  name="age[]" value="35-44"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('35-44',json_decode($Advertisement->age))) ? 'checked' : '' }} /> 35-44
                                                <input type="checkbox" class="age"  name="age[]" value="45-54"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('45-54',json_decode($Advertisement->age))) ? 'checked' : '' }}/> 45-54
                                                <input type="checkbox" class="age"  name="age[]" value="45-54"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('45-54',json_decode($Advertisement->age))) ? 'checked' : '' }}/> 55-64
                                                <input type="checkbox" class="age" name="age[]"  value="65+"    {{ !empty(json_decode($Advertisement->age)) &&  (in_array('65+',json_decode($Advertisement->age))) ? 'checked' : '' }} /> 65+
                                                <input type="checkbox" class="age"  name="age[]" value="unknown"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('unknown',json_decode($Advertisement->age))) ? 'checked' : '' }} /> All
                                            </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="m-0">Ads Gender:</label>
                                <div class="panel-body">
                                    <select class="gender form-control" name="gender[]" multiple="multiple" id="gender">
                                        <option value="male"   {{ !empty(json_decode($Advertisement->gender)) && in_array('male', json_decode($Advertisement->gender) ) ? 'selected' : '' }} >Male</option>
                                        <option value="female" {{ !empty(json_decode($Advertisement->gender)) && in_array('female', json_decode($Advertisement->gender) ) ? 'selected' : '' }} >Female</option>
                                        <option value="other"   {{ !empty(json_decode($Advertisement->gender)) && in_array('other', json_decode($Advertisement->gender) ) ? 'selected' : '' }} >other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Ads Location:</label>
                                <div class="panel-body">

                                    <input type="radio"  name="location" value=" " {{ is_null($Advertisement->location) ? 'checked' : '' }}  />
                                    <label class="">{{ ucwords('all countries & territories') }}</label><br>

                                    <input type="radio"  name="location" value="India" {{ $Advertisement->location == 'India' ? 'checked' : '' }}  />
                                    <label>India</label><br>

                                    <input type="radio"  name="location"  value="enter_location" {{ !is_null($Advertisement->location) && $Advertisement->location != 'India' ? 'checked' : '' }}  />
                                    <label>{{ ucwords('enter the location') }}</label>
                                </div>
                            </div>

                            <div class="col-md-6 location_input">
                                <div class="form-group">
                                    <label>Enter the Location:</label> 
                                    <input type="text" name="locations" class="form-control" placeholder="Enter the Location" value="{{ $Advertisement->location }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="container">
                                <button class="custom-skip-forward-button">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                                </button>
                
                                <button class="custom-skip-backward-button">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                                </button>

                                <video id="my-video" class="my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                                    width="auto" height="auto" playsinline="playsinline">
                                    <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4" type="video/mp4">
                                    {{-- <source src={{$Advertisement->ads_video}} type="video/mp4"> --}}
                                </video>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" onclick="return confirm('Are you updated this form, for sure? The ads are awaiting approval.');" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

    @include('avod::ads_player_script')
    @include('avod::ads_footer')

    <script src=" {{ URL::to('assets/admin/dashassets/js/jquery.min.js') }} "></script>  <!-- Imported styles on this page -->
    <script src=" {{ URL::to('assets/admin/dashassets/js/select2.min.js') }}"></script> <!-- Select2 JavaScript -->

    <script>
        $(document).ready(function() {

            var retrieve_location = "{{ $Advertisement->location }}";

            if(retrieve_location == "India" || retrieve_location == "" ){
                $('.location_input').hide();
            }

             // Location Hide and show

                $("input[name='location']").click(function() {
                    
                    $('.location_input').hide();
                    
                    var location = $(this).val();

                    if( location == "enter_location" ){
                        $('.location_input').show();
                    }else{
                        $('.location_input').hide();
                    }

                });

                 // Select 2 for Gender
            $('.gender').select2();

            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        });

        $(document).ready(function() {

            $('.js-example-basic-multiple').select2();

            $(".ads_type").change(function() {
                $('.tag_url, .ads_video_upload').hide();
                var ads_type = $('.ads_type').val();

                if (ads_type === 'tag_url') {
                    $('.tag_url').css("display", "block");
                } else if (ads_type === 'ads_video_upload') {
                    $('.ads_video_upload').css("display", "block");
                }
            });
        });
    
    </script>