
@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/assets/admin/css/sweetalert.css' }}">
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="iq-card">

                                {{-- Title Name --}}
                <div class="admin-section-title">
                    <div class="row">
                        <div class="col-md-12">
                            <h3><i class="entypo-archive"></i>Update Advertisement</h3>
                        </div>
                    </div>
                </div>

                            {{-- Alert Message  --}}
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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="modal-body">
                    <form accept-charset="UTF-8" action="{{ URL::to('admin/advertisement/update') }}" method="post"  id="advertiser_edit" enctype="multipart/form-data" >
                        @csrf   
                        <input type="hidden" name="id" id="id" value="{{ $advertisement->id }}" />

                        <div class="row">
                                            {{-- Ads Name --}}
                            <div class="form-group col-md-6">
                                <label> Ads Name:</label>
                                <input type="text" id="ads_name" name="ads_name" value="{{ $advertisement->ads_name }}" class="form-control" placeholder="Enter the Ads Name">
                            </div>

                                            {{-- Ads Status --}}

                            <div class="col-md-6">
                                <label for=""> Ads Status: </label>
                                <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                    
                                    <div style="color:red;">In-active</div>

                                    <div class="mt-1">
                                        <label class="switch">
                                            <input type="checkbox"  {{ $advertisement->status == 1 ? "checked" : " "  }} name="status" >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <div style="color:green;">Active</div>
                                </div>
                                <div class="make-switch" data-on="success" data-off="warning"></div>
                            </div>
                        </div>

                        <div class="row">
                                            {{-- Ads Categories --}}
                            <div class="form-group col-md-6">
                                <label> Ads Categories :</label>
                                <select class="form-control" id="ads_category" name="ads_category">
                                    @foreach ($ads_categories as $ads_category)
                                        <option value="{{ $ads_category->id }}" @if (!empty($advertisement->ads_category) && $advertisement->ads_category == $ads_category->id) selected="selected" @endif>
                                            {{ $ads_category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                                            {{-- Ads position --}}
                            <div class="form-group col-md-6">
                                <label> Ads position :</label>
                                <select class="form-control" name="ads_position">
                                    <option value="pre" @if ($advertisement->ads_position == 'pre') {{ 'selected' }} @endif>Pre</option>
                                    <option value="mid" @if ($advertisement->ads_position == 'mid') {{ 'selected' }} @endif>Mid</option>
                                    <option value="post" @if ($advertisement->ads_position == 'post') {{ 'selected' }} @endif>Post</option>
                                    <option value="all" @if ($advertisement->ads_position == 'all') {{ 'selected' }} @endif>All Position (Only for Ads Type - Tag URL)</option>
                                </select>
                            </div>
                        </div>


                        <div class="row d-flex">
                                            {{-- Ads upload Type --}}
                            <div class="form-group col-md-4">
                                <label> Ads upload Type :</label>
                                <select class="form-control ads_type" name="ads_upload_type">
                                    <option value="null"  @if ($advertisement->ads_upload_type == 'null') {{ 'selected' }} @endif >Select Ads Type </option>
                                    <option value="tag_url" @if ($advertisement->ads_upload_type == 'tag_url') {{ 'selected' }} @endif >Ad Tag Url </option>
                                    <option value="ads_video_upload" @if ($advertisement->ads_upload_type == 'ads_video_upload') {{ 'selected' }}  @endif > Ads Video Upload </option>
                                </select>
                            </div>

                                            {{-- Ad Tag Url --}}
                            <div class="form-group col-md-6 tag_url" style="{{ $advertisement->ads_upload_type == 'tag_url' ? 'display:block;' : 'display:none;' }}" >
                                <label>Ads Tag Url :</label>
                                <input type="text" id="ads_path" name="ads_path" class="form-control" value="{{ $advertisement->ads_path }}" placeholder="Please! Enter the Ads Tag URL" />
                            </div>

                                            {{-- Ads Video Upload--}}
                            <div class="form-group col-md-4 ads_video_upload" style="{{ $advertisement->ads_upload_type == 'ads_video_upload' ? 'display:block;' : 'display:none;' }}" >
                                <label> Ads Video Upload :</label>
                                <input type="file" id="ads_video" name="ads_video" accept="video/mp4" class="form-control" />
                                <span style="font-size: small;"> {{ $advertisement->ads_path }} </span>
                            </div>

                                            {{-- Ads Redirection URL --}}
                            <div class="form-group col-md-4 ads_video_upload" style="{{ $advertisement->ads_upload_type == 'ads_video_upload' ? 'display:block;' : 'display:none;' }}" >
                                <label> Ads Redirection URL:</label>
                                <input type="url" id="ads_redirection_url" name="ads_redirection_url"  
                                        placeholder="https://example.com"  class="form-control" value="{{ $advertisement->ads_redirection_url }}" />
                            </div>
                        </div>

                        <div class="row">
                                            {{-- Age --}}
                            <div class="form-group col-md-6">
                                <label> Age :</label>
                                
                                <div class="row d-flex" style="padding: inherit;">
                                    <label class="checkbox-inline" >

                                        <input type="checkbox" class="age" name="age[]" value="18-24" {{  !empty(json_decode($advertisement->age)) &&  in_array('18-24',json_decode($advertisement->age) ) ? 'checked' : '' }} > 18-24
                                        <input type="checkbox" class="age" name="age[]" value="25-34"  {{ !empty(json_decode($advertisement->age)) &&  (in_array('25-34',json_decode($advertisement->age))) ? 'checked' : '' }}> 25-34
                                        <input type="checkbox" class="age"  name="age[]" value="35-44"  {{ !empty(json_decode($advertisement->age)) &&  (in_array('35-44',json_decode($advertisement->age))) ? 'checked' : '' }} /> 35-44
                                        <input type="checkbox" class="age"  name="age[]" value="45-54"  {{ !empty(json_decode($advertisement->age)) &&  (in_array('45-54',json_decode($advertisement->age))) ? 'checked' : '' }}/> 45-54
                                        <input type="checkbox" class="age"  name="age[]" value="45-54"  {{ !empty(json_decode($advertisement->age)) &&  (in_array('45-54',json_decode($advertisement->age))) ? 'checked' : '' }}/> 55-64
                                        <input type="checkbox" class="age" name="age[]"  value="65+"    {{ !empty(json_decode($advertisement->age)) &&  (in_array('65+',json_decode($advertisement->age))) ? 'checked' : '' }} /> 65+
                                        <input type="checkbox" class="age"  name="age[]" value="unknown"  {{ !empty(json_decode($advertisement->age)) &&  (in_array('unknown',json_decode($advertisement->age))) ? 'checked' : '' }} /> unknown
                                    </label>
                                </div>
                            </div>

                                            {{-- Gender --}}
                            <div class="form-group col-md-6">
                                <label> Gender :</label>
                               <select class="age_select2 form-control" name="gender[]" multiple="multiple" id="gender">
                                    <option value="male"   {{ !empty(json_decode($advertisement->gender)) && in_array('male', json_decode($advertisement->gender) ) ? 'selected' : '' }} >Male</option>
                                    <option value="female" {{ !empty(json_decode($advertisement->gender)) && in_array('female', json_decode($advertisement->gender) ) ? 'selected' : '' }} >Female</option>
                                    <option value="kids"   {{ !empty(json_decode($advertisement->gender)) && in_array('kids', json_decode($advertisement->gender) ) ? 'selected' : '' }} >kids</option>
                                </select>
                            </div>
                        </div>

                                        {{-- Location --}}
                         <div class="row">
                            <div class="form-group col-md-6">
                                <label> Location Details :</label><br>

                                <input type="radio"  name="location" value="all_countries" {{ $advertisement->location == 'all_countries' ? 'checked' : '' }}  />
                                <label class="">{{ ucwords('all countries & territories') }}</label><br>

                                <input type="radio"   name="location" value="India" {{ $advertisement->location == 'India' ? 'checked' : '' }}  />
                                <label>India</label><br>

                                <input type="radio"  name="location"  value="enter_location" {{ $advertisement->location != 'India' && $advertisement->location != 'all_countries' ? 'checked' : '' }}  />
                                <label>{{ ucwords('enter the location') }}</label>
                            </div>

                            <div class="col-md-6 location_input">
                                <div class="form-group">
                                    <label>Enter the Location:</label> 
                                    <input type="text" name="locations" class="form-control" placeholder="Enter the Location" value="{{ $advertisement->location }}" />
                                </div>
                            </div>
                        </div>

                                            {{-- Footer --}}
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" id="submit-update-cat" value="Update" />
                            <a type="button" class="btn btn-danger" data-dismiss="modal"  href="{{ URL::to('admin/ads_list') }}">Close</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

    {{-- validate --}}

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $('form[id="devices_edit"]').validate({
            rules: {
                devices_name: 'required',
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        })

            // Select 2 for Age
        $('.age_select2').select2();

            // Location Hide and show
            $(document).ready(function() {

                var retrieve_location = "{{ $advertisement->location }}";

                if(retrieve_location == "India" || retrieve_location == "all_countries" ){
                    $('.location_input').hide();
                }

                $("input[name='location']").click(function() {
                    
                    $('.location_input').hide();
                    
                    var location = $(this).val();

                    if( location == "enter_location" ){
                        $('.location_input').show();
                    }else{
                        $('.location_input').hide();
                    }

                });
            });

            $(document).ready(function() {

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
@stop