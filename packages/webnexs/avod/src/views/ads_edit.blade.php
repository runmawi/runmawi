@include('avod::ads_header')

<!-- videojs-contrib-ads CSS and Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/6.6.6/videojs-contrib-ads.min.js"></script>

{{-- video-js Style --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link rel="stylesheet" href="<?= URL::to('/') . '/public/themes/default/assets/css/video-js/videojs.min.css' ?>" />

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
    .my-video.video-js .vjs-big-play-button{font-size:3em;line-height:1.5em;height:1.63332em;width:3em;display:inline-block;position:absolute;top:50%;left:50%;padding:0;margin-top:-.81666em;margin-left:-1.5em;cursor:pointer;opacity:1;border:none;background-color:#fff0;border-radius:none;transition:3s;color:#000}
    .my-video.video-js .vjs-big-play-button .vjs-icon-placeholder:before{height:50px;width:50px;left:27%;border-radius:50%;background-color:#fff;display:grid;place-content:center;cursor:pointer}
    .my-video.video-js .vjs-control-bar{background:linear-gradient(transparent,rgb(0 0 0 / .75));background:var(--plyr-video-controls-background,linear-gradient(transparent,#fff0));transition:opacity 0.4s ease-in-out,transform 0.4s ease-in-out;z-index:3;height:64px}
    .vjs-icon-play:before,.my-video .video-js .vjs-play-control .vjs-icon-placeholder:before,.my-video.video-js .vjs-big-play-button .vjs-icon-placeholder:before{content:"\f101"}
    .my-video.video-js.vjs-playing .vjs-big-play-button .vjs-icon-placeholder:before{content:"\f103"}
    .vjs-play-control .vjs-icon-placeholder:before{margin-top:.33em;border-radius:4px;border:0 solid #fff0;font-size:25px}
    .my-video.video-js button{background:#fff0;border:none;color:#fff;display:inline-block;font-size:13px;text-transform:capitalize;text-decoration:none;appearance:none;font-weight:500}
    .my-video.video-js .vjs-mute-control{cursor:pointer;flex:none;line-height:3.3em;margin-top:40px;right:12px}
    .my-video.video-js .vjs-time-control{flex:none;font-size:1.3em;line-height:4.8em;display:block;left:3px}
    .my-video.video-js .vjs-control.vjs-menu-button{height:50%;border-radius:3px;margin-bottom:22px;margin-top:15px;margin-right:10px}
    .vjs-menu-button-popup .vjs-menu .vjs-menu-content{position:absolute;width:100%;bottom:.9em;max-height:15em;background-color:#2b333f;border-radius:5px}
    .vjs-menu li.vjs-menu-item:focus,.vjs-menu li.vjs-menu-item:hover,.js-focus-visible .vjs-menu li.vjs-menu-item:hover{background-color:#095ae5}
    .vjs-menu-button-popup .vjs-menu{display:none;position:absolute;bottom:0;width:10em;left:-3em;height:0em;margin-bottom:2.5em;border-top-color:rgb(43 51 63 / .7)}
    .vjs-volume-panel{position:absolute;right:auto;bottom:20px;left:10px;height:150px;width:20px;display:flex;align-items:center;justify-content:center}
    .vjs-volume-bar{height:100%;width:10px;display:flex;flex-direction:column-reverse;transform-origin:center center}
    .vjs-volume-bar .vjs-volume-level{width:100%;height:auto}
    .video-js .vjs-volume-panel .vjs-volume-control{margin-left:-18px!important;margin-top:40px!important}
    .vjs-volume-bar.vjs-slider-horizontal{height:0.5em!important}
    .my-video.video-js .vjs-volume-level:before{font-size:1.4em}
    .vjs-slider-horizontal .vjs-volume-level:before{line-height:0em!important;top: -0.15em !important;}
    .vjs-volume-bar .vjs-volume-handle{height:10px;width:100%;bottom:auto;left:0;transform:translateX(50%)}
    .my-video.vjs-theme-city .vjs-progress-control .vjs-progress-holder,.my-video.vjs-theme-city .vjs-progress-control:hover .vjs-progress-holder{font-size:1.5em}
    .my-video.video-js .vjs-slider{position:relative;cursor:pointer;padding:0;margin:0 .45em 0 .55em;-webkit-touch-callout:none;-webkit-user-select:none;user-select:none;background-color:#73859f;font-size:10px;border-radius:3px}
    .my-video.video-js .vjs-progress-holder{flex:auto;transition:all 0.2s;height:.2em}
    .video-js .vjs-picture-in-picture-control{right:5px}
    .vjs-playback-rate .vjs-playback-rate-value{ font-size: 1.4em !important;line-height: 3.15em !important;}

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
                        <a  style="margin-top: -6.5%;" href="#" class="btn btn-lg btn-primary pull-right" data-toggle="modal" data-target="#largeModal">Preview Player</a>
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

                    <div class="container">                
                        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Episode Player</h4>
                                        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <video id="my-video" class="my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                                            width="auto" height="auto" playsinline="playsinline" autoplay>
                                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4" type="video/mp4">
                                            {{-- <source src={{$Advertisement->ads_video}} type="video/mp4"> --}}
                                        </video>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="close-btn btn btn-lg btn-primary" data-dismiss="modal">Close Player</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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