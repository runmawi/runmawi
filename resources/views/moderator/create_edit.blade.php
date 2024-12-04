@extends('admin.master')
@section('content')

<style>
    .form-group{margin: 8px auto;}

    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin-left: 31rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .disable-actions {
        pointer-events: none; /* Disables all mouse events */
        opacity: 0.6;         /* Adds a semi-transparent overlay effect */
    }

    .disable-actions #loadingIndicator {
        pointer-events: auto; /* Allow interactions with the loading spinner */
        opacity: 1;           /* Ensure the spinner remains fully visible */
    }
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

                            {{-- Commission Percentage - Individual commission content --}}

                        @if ( $setting->CPP_Commission_Status == 1)  
                       
                            <div class="col-md-12 m-0 mb-1"><hr>
                                <h5> Commission Percentage (%)</h5>
                                <div id="loadingIndicator" style="display:none;" class="loading-spinner"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label text-md-right">{{ __('Videos') }}</label>
                                    @if ( ($videos)->isNotEmpty())
                                        <select class="form-control source_id" data-source-name="videos" id="video_id" name="video_id">
                                            @forelse($videos as $value)
                                                <option value="{{ $value->id }}">{{ $value->title }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p > No data found </p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                @if ( ($videos)->isNotEmpty())
                                    <div class="form-group">
                                        <label class="col-form-label text-md-right">{{ __('Commission') }}</label>
                                        <input type="number" class="form-control" name="videos_commission" id="videos_commission" placeholder="0 - 100" value="{{ @$videos[0]->CPP_commission_percentage }}"
                                            value="" min="0" max="100" step="1"
                                            oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4" >
                                <div class="form-group">
                                    <label class=" col-form-label text-md-right">{{ __('Livestream') }}</label>
                                    @if ( ($livestream)->isNotEmpty())
                                        <select class="form-control source_id" data-source-name="livestream"  name="livestream_id">
                                            @foreach($livestream as $value)
                                                <option value="{{ $value->id }}" >{{ $value->title }}</option>
                                            @endforeach
                                        </select>  
                                    @else
                                        <p > No data found </p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-md-2" >
                                @if ( ($livestream)->isNotEmpty())
                                    <div class="form-group">
                                        <label class="col-form-label text-md-right">{{ __('Commission') }}</label>
                                        <input type="number" class="form-control" name="live_commission" id="live_commission"  placeholder="0 - 100" value="{{ @$livestream[0]->CPP_commission_percentage }}"
                                                value=""  min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4" >
                                <div class="form-group">
                                    <label class=" col-form-label text-md-right">{{ __('TV Shows') }}</label>
                                    @if ( ($series)->isNotEmpty())
                                        <select class="form-control source_id" data-source-name="series" name="series_id">
                                            @foreach($series as $value)
                                                <option value="{{ $value->id }}" >{{ $value->title }}</option>
                                            @endforeach
                                        </select>  
                                    @else
                                        <p > No data found </p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-2" >
                                @if ( ($series)->isNotEmpty())
                                    <div class="form-group">
                                        <label class="col-form-label text-md-right">{{ __('Commission') }}</label>
                                        <input type="number" class="form-control" name="series_commission" id="series_commission"  placeholder="0 - 100" value="{{ @$series[0]->CPP_commission_percentage }}"
                                        value=""  min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                    <br>

                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <button type="submit" id ="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div> 

            {{-- Commission Percentage Table - Individual commission content --}}

            @if ( $setting->CPP_Commission_Status == 1)  

                <div class="table-view">

                    <h5> CPP Commission Percentage (%)  List</h5><br>

                    <table id="Commission_table" class="table movie_table text-center table-bordered" style="width:100%">
                        <thead>
                            <tr class="r1">
                                <th style="width: 5%;">#</th>
                                <th style="width: 30%;">Title</th>
                                <th style="width: 30%;">Commission Percentage (%) </th>
                                <th style="width: 25%;">Source </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($all_data as $key => $data)
                                <tr >
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ @$data->title}}</td>
                                    <td>{{ @$data->CPP_commission_percentage}}</td>
                                    <td>{{ @$data->source}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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

        $('#Commission_table').DataTable({
            responsive: true, 
            paging: true,     
            pageLength: 10,   
            lengthMenu: [5, 10, 25, 50, 100], 
            autoWidth: false  
        });

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
                
                $('#loadingIndicator').show();
                $('body').addClass('disable-actions');

                $.ajax({
                    url: "{{ route('ModeratorsUser.getCPPCommission') }}", 
                    type: 'GET',
                    data: {
                        sourceID: sourceID,
                        sourceName: sourceName,
                        moderator_id: "{{ $moderators->id }}",
                    },
                    success: function(response) {
                    
                        $('#loadingIndicator').hide();
                        $('body').removeClass('disable-actions');

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
                        $('#loadingIndicator').hide();
                        $('body').removeClass('disable-actions');
                        alert('An error occurred while fetching commission data.');
                    }
                });
            });
        });
    </script>
@stop