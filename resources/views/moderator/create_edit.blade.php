@extends('admin.master')
@section('content')

<style>
    .form-group{margin: 8px auto;}
</style>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script src="category/videos/js/rolespermission.js"></script>

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="iq-card">

            <div id="moderator-container">

	
                <div class="moderator-section-title">
                    <h4><i class="entypo-globe"></i>Update Moderator Users</h4> 
                    <hr>
                </div>

                <div class="clear"></div>

                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                @if(count($errors) > 0)
                    @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage">
                            <button id="successMessage" class="close" data-close="alert"></button>
                            <span>{{ $message }}</span>
                        </div>
                    @endforeach
                @endif	

                <form method="POST" action="{{ URL::to('admin/moderatoruser/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Moderator_edit" onsubmit="return validateMobileNumber()">
                        @csrf
                    <div class="row container-fluid">
                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="name" class=" col-form-label text-md-right">{{ __('User Name') }}</label>
                                <input id="id" type="hidden" class="form-control" name="id" value="{{  $moderators->id }}"  autocomplete="username" autofocus>
                                <input id="status" type="hidden" class="form-control" name="status" value="{{  $moderators->status }}"  autocomplete="username" autofocus>
                                <input id="name" type="text" class="form-control" name="username" value="{{ $moderators->username }}"  autocomplete="username" autofocus>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email_id" type="email" class="form-control " name="email_id" value="{{ $moderators->email }}"  autocomplete="email">
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="mobile_number" class=" col-form-label text-md-right">{{ __('Mobile Number') }}</label>
                                <input id="mobile_number" type="text" class="form-control " name="mobile_number" value="{{ $moderators->mobile_number }}"  autocomplete="email">
                                <span id="error" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                            </div>
                        </div>

                        <!-- <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                
                                <input id="password" type="password" class="form-control " name="password"  autocomplete="new-password">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <input id="confirm_password" type="password" class="form-control" name="confirm_password"  autocomplete="new-password">
                            </div>
                        </div> -->

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="description" class=" col-form-label text-md-right">{{ __('Description') }}</label>
                                <input id="description" type="textarea" class="form-control" name="description" value ="{{ $moderators->description }}" autocomplete="description">
                            </div>
                        </div>

                        @if ( $setting->CPP_Commission_Status == 0)  
                            <div class="col-md-6" >
                                <div class="form-group row">
                                    <label for="" class=" col-form-label text-md-right">{{ __('Commission Percentage') }}</label>
                                    <input type="number" class="form-control" name="commission_percentage" id="percentage"  value="{{ (!is_null($moderators->commission_percentage)) ? $moderators->commission_percentage : null }}" 
                                        min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="user_role" class=" col-form-label text-md-right">{{ __('User Roles') }}</label>
                        
                                <select class="form-control" id="user_role" name="user_role">
                                    <option value="">Select Roles</option>

                                    @if($roles->count() > 0)
                                        @foreach($roles as $value)
                                            <option value="{{ $value->id }}" @if(!empty($moderators->user_role) && $moderators->user_role == $value->id){{ 'selected' }}@endif>{{ $value->role_name }}</option>
                                        @endforeach
                                    @else
                                        No Record Found
                                    @endif   
                                </select>         
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="picture" class=" col-form-label text-md-right">{{ __('Picture') }}</label>
                                <input id="picture" type="hidden" class="form-control" id= "picture" name="picture"  value="">
                                <input id="picture" type="file" class="form-control" id= "picture" name="picture"  value="DefaultImageName">
                                <p class="text" id= "error_picture"> </p>
                            </div>
                            
                            @if(!empty($moderators->picture))
                                <img class="w-50 mt-2 rounded" src="<?php if($moderators->picture == "Default.png") { echo  URL::to('/public/uploads/avatars/profile.png') ; }else { echo  $moderators->picture; }?>"  />
                            @endif
                        </div>

                            {{-- Commission Percentage --}}

                        @if ( $setting->CPP_Commission_Status == 1)  

                            <div class="d-flex col-md-12 m-0 mb-1"><hr>
                                <div class="col-md-8">
                                    <h5> Commission Percentage (%)</h5>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label text-md-right">{{ __('Videos') }}</label>
                                    <select class="form-control source_id" data-source-name="videos" id="video_id" name="video_id">
                                        <option value="">Select videos</option>
                                        @foreach($videos as $value)
                                            <option value="{{ $value->id }}">{{ $value->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label text-md-right">{{ __('Commission') }}</label>
                                    <input type="number" class="form-control" name="videos_commission" id="videos_commission" placeholder="0 - 100"
                                           value="" min="0" max="100" step="1"
                                           oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                                </div>
                            </div>

                            <div class="col-md-4" >
                                <div class="form-group row">
                                    <label class=" col-form-label text-md-right">{{ __('Livestream') }}</label>
                                    <select class="form-control source_id" data-source-name="livestream"  name="livestream_id">
                                        <option value="">Select Livestream</option>
                                        @foreach($livestream as $value)
                                            <option value="{{ $value->id }}" >{{ $value->title }}</option>
                                        @endforeach
                                    </select>  
                                </div>
                            </div>

                            <div class="col-md-2" >
                                <div class="form-group">
                                    <label class="col-form-label text-md-right">{{ __('Commission') }}</label>
                                    <input type="number" class="form-control" name="live_commission" id="live_commission"  placeholder="0 - 100"
                                            value=""  min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                                </div>
                            </div>

                            <div class="col-md-4" >
                                <div class="form-group row">
                                    <label class=" col-form-label text-md-right">{{ __('TV Shows') }}</label>
                                    <select class="form-control source_id" data-source-name="series" name="series_id">
                                        <option value="">Select TV Shows</option>
                                        @foreach($series as $value)
                                            <option value="{{ $value->id }}" >{{ $value->title }}</option>
                                        @endforeach
                                    </select>  
                                </div>
                            </div>

                            <div class="col-md-2" >
                                <div class="form-group">
                                    <label class="col-form-label text-md-right">{{ __('Commission') }}</label>
                                    <input type="number" class="form-control" name="series_commission" id="series_commission"  placeholder="0 - 100"
                                    value=""  min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                                </div>
                            </div>
                        @endif

                    </div>
                    <br>

                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <button type="submit" id ="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

        function validateMobileNumber() {

                var mobileNumber = document.getElementById('mobile_number').value;

            if (mobileNumber.length !== 10 || !/^\d+$/.test(mobileNumber)) {
                alert("Please enter a valid 10-digit mobile number.");
                return false;
            }

            return true; 

        }
                
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>

@section('javascript')

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    
    <script>
        
        $('form[id="Moderator_edit"]').validate({
            rules: {
                username : 'required',
                mobile_number : 'required',
                user_role : 'required',
                email_id : 'required'
            },
            messages: {
                username: 'This field is required',
                mobile_number: 'This field is required',
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $(document).ready(function() {

            $('.source_id').on('change', function() {
                
                let sourceName = $(this).data('source-name'); 
                let sourceID = $(this).val();

                $.ajax({
                    url: "{{ route('ModeratorsUser.getCPPCommission') }}", 
                    type: 'GET',
                    data: {
                            sourceID: sourceID,
                            sourceName : sourceName,
                            moderator_id: "{{ $moderators->id }}",
                        },
                    success: function(response) {
                        if (response.success) {

                            if (response.sourceName == "videos") {
                                $('#videos_commission').val(response.commission);
                            }

                            if (response.sourceName == "livestream") {
                                $('#live_commission').val(response.commission);
                            }

                            if (response.sourceName == "series") {
                                $('#series_commission').val(response.commission);
                            }
                        } else {
                            alert('No commission data found for the selected.');

                            if (response.sourceName == "videos") {
                                $('#videos_commission').val(" ");
                            }

                            if (response.sourceName == "livestream") {
                                $('#live_commission').val(" ");
                            }

                            if (response.sourceName == "series") {
                                $('#series_commission').val(" ");
                            }
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching commission data.');
                    }
                });
            });
        });

    </script>
@stop