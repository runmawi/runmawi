@include('avod::ads_header')

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

    */
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
                                        <option value="all"  {{ "all" == $Advertisement->ads_position ? "selected" : null }}>All Position (Only for Ads Type - Tag URL)</option>
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
                                        value="{{ $Advertisement->ads_path }}" placeholder="Please! Enter the Ads Tag URL" />
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
                                                <input type="checkbox" class="age" name="age[]" value="18-24" {{  !empty(json_decode($Advertisement->age)) &&  in_array('18-24',json_decode($Advertisement->age) ) ? 'checked' : '' }} > 18-24
                                                <input type="checkbox" class="age" name="age[]" value="25-34"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('25-34',json_decode($Advertisement->age))) ? 'checked' : '' }}> 25-34
                                                <input type="checkbox" class="age"  name="age[]" value="35-44"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('35-44',json_decode($Advertisement->age))) ? 'checked' : '' }} /> 35-44
                                                <input type="checkbox" class="age"  name="age[]" value="45-54"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('45-54',json_decode($Advertisement->age))) ? 'checked' : '' }}/> 45-54
                                                <input type="checkbox" class="age"  name="age[]" value="45-54"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('45-54',json_decode($Advertisement->age))) ? 'checked' : '' }}/> 55-64
                                                <input type="checkbox" class="age" name="age[]"  value="65+"    {{ !empty(json_decode($Advertisement->age)) &&  (in_array('65+',json_decode($Advertisement->age))) ? 'checked' : '' }} /> 65+
                                                <input type="checkbox" class="age"  name="age[]" value="unknown"  {{ !empty(json_decode($Advertisement->age)) &&  (in_array('unknown',json_decode($Advertisement->age))) ? 'checked' : '' }} /> unknown
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
                                        <option value="kids"   {{ !empty(json_decode($Advertisement->gender)) && in_array('kids', json_decode($Advertisement->gender) ) ? 'selected' : '' }} >kids</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Ads Location:</label>
                                <div class="panel-body">

                                    <input type="radio"  name="location" value="all_countries" {{ $Advertisement->location == 'all_countries' ? 'checked' : '' }}  />
                                    <label class="">{{ ucwords('all countries & territories') }}</label><br>

                                    <input type="radio"  name="location" value="India" {{ $Advertisement->location == 'India' ? 'checked' : '' }}  />
                                    <label>India</label><br>

                                    <input type="radio"  name="location"  value="enter_location" {{ $Advertisement->location != 'India' && $Advertisement->location != 'all_countries' ? 'checked' : '' }}  />
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

    

    @include('avod::ads_footer')

    <script src=" {{ URL::to('assets/admin/dashassets/js/jquery.min.js') }} "></script>  <!-- Imported styles on this page -->
    <script src=" {{ URL::to('assets/admin/dashassets/js/select2.min.js') }}"></script> <!-- Select2 JavaScript -->

    <script>
        $(document).ready(function() {

            var retrieve_location = "{{ $Advertisement->location }}";

            if(retrieve_location == "India" || retrieve_location == "all_countries" ){
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