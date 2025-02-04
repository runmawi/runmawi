@extends('admin.master') @section('css')
<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop @section('content')
<div id="content-page" class="content-page">

    <!-- BREADCRUMBS -->
    <div class="row mr-2">
        <div class="nav container-fluid pl-0 mar-left " id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="black-text"
                            href="{{ URL::to('admin/series-list') }}">{{ ucwords(__('Tv Shows List')) }}</a>
                        <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                    </li>
                    
                    <li class="breadcrumb-item">
                        <a class="black-text"
                            href="{{ URL::to('admin/series/edit/'.$series->id )  }}"> {{ __($series->title) }}
                        </a>
                        
                    <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                    </li>
                    <li class="breadcrumb-item">{{ optional($season)->series_seasons_name }}</li>
               
                </ol>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="iq-card">
            <div class="modal-body">
                <form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/season/update') }}" method="post" enctype="multipart/form-data">
                    
                <div class="form-group">
                    <label>Season Title:</label>
                    <input type="text" id="series_seasons_name" name="series_seasons_name" value="{{ optional($season)->series_seasons_name }}" placeholder="Enter the Season Title" class="form-control">
                </div>  

                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="m-0">Season Thumbnail </label>
                        @php 
                            $player_width = $compress_image_settings->width_validation_season;
                            $player_heigth = $compress_image_settings->height_validation_season;
                        @endphp
                        @if($player_width !== null && $player_heigth !== null)
                            <p class="p1">{{ ("Select Season Thumbnail (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                        @else
                            <p class="p1">{{ "Select Season Thumbnail ( 1280x720px )"}}:</p> 
                        @endif
                        {{-- <p class="p1">(16:9 Ratio or 1080 X 1920px)</p> --}}
                        @if(!empty($season->image))
                            <img src="{{  $season->image }}" class="movie-img" width="200" />
                        @endif
                        <input type="file" multiple="true" class="form-control" name="image" id="season_image" accept="image/png, image/gif, image/jpeg"/>
                        <span>
                            <p id="season_image_error_msg" style="color:red !important; display:none;">
                                * Please upload an image with the correct dimensions.
                            </p>
                        </span>
                    </div>
                    <!-- <div class="form-group">
                        <label>Season Landing Page MP4 URL </label><br>
                        <input type="text" value ="@if(!empty($season->landing_mp4_url)){{ $season->landing_mp4_url }}@endif" class="form-control" name="landing_mp4_url" id="landing_mp4_url" >
                    </div> -->
                    <div class="form-group">
                        <label class="m-0">Season Trailer :</label>
                        <p class="p1">Drop and drag the video file</p>
                        <div style="position: relative;" class="form_video-upload mb-3">
                            <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" />
                            <!-- <p class="p1">Drop and drag the video file</p> -->
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                               @if(!empty($season->trailer))
                                  <video width="200" height="200" controls  style="width: 90%;">
                                     <source src="<?php echo $season->landing_mp4_url; ?>" type="video/mp4" />
                                  </video>
                               @endif
                            </div>
                         </div>
                    </div>
                    
                    @if(Enable_PPV_Plans() == 1)
                        <div class="form-group {{ $errors->has('series_seasons_type') ? 'has-error' : '' }}">
                            <label class="m-0">Choose Episode Type:</label>
                            <select class="form-control" id="series_seasons_type" name="series_seasons_type">
                                <option value="VideoCipher" @if(!empty($season->series_seasons_type) && $season->series_seasons_type == 'VideoCipher'){{ 'selected' }}@endif>VideoCipher Video</option>
                                <option value="m3u8" @if(!empty($season->series_seasons_type) && $season->series_seasons_type == 'm3u8'){{ 'selected' }}@endif>Episode Upload Url m3u8</option>
                                <option value="videomp4" @if(!empty($season->series_seasons_type) && $season->series_seasons_type == 'videomp4'){{ 'selected' }}@endif>Episode Upload Url MP4</option>
                                <option value="embed_video" @if(!empty($season->series_seasons_type) && $season->series_seasons_type == 'embed_video'){{ 'selected' }}@endif>Episode Upload Url Embed</option>
                            </select>
                        </div>
                    @endif

                    <div class="form-group {{ $errors->has('ppv_access') ? 'has-error' : '' }}">
                        <label class="m-0">Choose User Access:</label>
                        <select class="form-control" id="ppv_access" name="ppv_access">
                            <option value="free" @if(!empty($season->access) && $season->access == 'free'){{ 'selected' }}@endif>Free (everyone)</option>
                            <option value="ppv" @if(!empty($season->access) && $season->access == 'ppv'){{ 'selected' }}@endif>PPV (Pay Per Season(Episodes))</option>
                        </select>
                    </div>
                    
                    <div class="form-group {{ $errors->has('ppv_price') ? 'has-error' : '' }}" id="ppv_price_group">
                        <label class="m-0">PPV Price ($):</label>
                        <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="ppv_price_input" value="@if(!empty($season->ppv_price)){{ $season->ppv_price }}@endif" />
                        <p id="ppv_error_req" style="color: red !important;display:none;">*This field is required</p>
                    </div>
                    

                    <div id="ppv_price_plan">
                        <div class="form-group" >

                            <label class="m-0">PPV Price for 480 Plan:</label>
                            <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_480p"  value="@if(!empty($season->ppv_price_480p)){{ $season->ppv_price_480p }}@endif">
                            <span id="error_quality_ppv_price" style="color:red;">*Enter the 480 PPV Price </span>
                        </div>

                        <div class="form-group" >
                            <label class="m-0">PPV Price for 720 Plan:</label>
                            <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_720p"  value="@if(!empty($season->ppv_price_720p)){{ $season->ppv_price_720p }}@endif">
                            <span id="error_quality_ppv_price" style="color:red;">*Enter the 720 PPV Price </span>
                        </div>

                        <div class="form-group" >

                            <label class="m-0">PPV Price for 1080 Plan:</label>
                            <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_1080p"  value="@if(!empty($season->ppv_price_1080p)){{ $season->ppv_price_1080p }}@endif">
                            <span id="error_quality_ppv_price" style="color:red;">*Enter the 1080 PPV Price </span>
                        </div>  
                    </div>

                    <div class="form-group ios_ppv_price_old" id='ios_ppv_price_old' >
                        <label class="m-0">IOS PPV Price ($):</label>
                        <select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                            <option value= "" >Select IOS PPV Price: </option>
                            @foreach($InappPurchase as $Inapp_Purchase)
                                <option value="{{ $Inapp_Purchase->product_id }}"  @if(!empty($season->ios_product_id) && $season->ios_product_id == $Inapp_Purchase->product_id){{ 'selected' }} @endif > {{ $Inapp_Purchase->plan_price }} </option>
                            @endforeach
                        </select>
                        <p id="ios_error_req" style="color: red !important;display:none;">*This field is required</p>
                    </div>

                    <div class="form-group ios_ppv_price_plan" id='ios_ppv_price_plan'>

                        <div class="form-group" >
								<label class="m-0">IOS PPV Price for 480 Plan:</label>
								<select  name="ios_ppv_price_480p" class="form-control" id="ios_ppv_price_480p">
									<option value= "" >Select 480 IOS PPV Price: </option>
									@foreach($InappPurchase as $Inapp_Purchase)
                                    <option value="{{ $Inapp_Purchase->product_id }}"  @if(!empty($season->ios_ppv_price_480p) && $season->ios_ppv_price_480p == $Inapp_Purchase->product_id){{ 'selected' }} @endif > {{ $Inapp_Purchase->plan_price }} </option>
									@endforeach
								</select>
							</div>
							<div class="form-group" >
								<label class="m-0">IOS PPV Price for 720 Plan:</label>
								<select  name="ios_ppv_price_720p" class="form-control" id="ios_ppv_price_720p">
									<option value= "" >Select 720 IOS PPV Price: </option>
									@foreach($InappPurchase as $Inapp_Purchase)
                                    <option value="{{ $Inapp_Purchase->product_id }}"  @if(!empty($season->ios_ppv_price_720p) && $season->ios_ppv_price_720p == $Inapp_Purchase->product_id){{ 'selected' }} @endif > {{ $Inapp_Purchase->plan_price }} </option>
									@endforeach
								</select>
							</div>
							<div class="form-group" >
								<label class="m-0">IOS PPV Price for 1080 Plan:</label>
								<select  name="ios_ppv_price_1080p" class="form-control" id="ios_ppv_price_1080p">
									<option value= "" >Select 1080 IOS PPV Price: </option>
									@foreach($InappPurchase as $Inapp_Purchase)
                                    <option value="{{ $Inapp_Purchase->product_id }}"  @if(!empty($season->ios_ppv_price_1080p) && $season->ios_ppv_price_1080p == $Inapp_Purchase->product_id){{ 'selected' }} @endif > {{ $Inapp_Purchase->plan_price }} </option>
									@endforeach
								</select>
							</div>
                            
                    </div>
                    @if (Enable_videoCipher_Upload() == 0 && Enable_PPV_Plans() == 0)
                        <div id="ppv_intravel_group" class="form-group {{ $errors->has('ppv_interval') ? 'has-error' : '' }}">
                            <label class="m-0">PPV Interval:</label>
                            <p class="p1">Please Mention How Many Episodes are Free:</p>
                            <input type="text" id="ppv_interval" name="ppv_interval" value="@if(!empty($season->ppv_interval)){{ $season->ppv_interval }}@endif" class="form-control" />
                            <p id="intravel_error_req" style="color: red !important;">*This field is required</p>
                        </div>
                    @endif

                    <input type="hidden" name="id" id="id" value="{{ $season->id }}" />
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                    <div class="modal-footer form-group">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <a type="button" class="btn btn-primary" data-dismiss="modal" href="{{ URL::to('admin/series/edit'.'/'.$season->series_id) }}">Close</a>
                        <button type="submit" class="btn btn-primary" id="submit-update-cat" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

@section('javascript')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        var previousValue = $('#ppv_access').val();
        var access_pass = '<?= $access_password ?>';
        var access_btn_staus = '<?= $access_btn_staus ?>';
        console.log('access_btn_staus: ' + access_btn_staus);
        
        
        if(access_btn_staus == 1){
            $('#ppv_access').change(function() {
                var newValue = $(this).val();

                if (newValue !== previousValue) {
                    var password = prompt("Please enter your password:");

                    if (password === access_pass ) {
                        previousValue = newValue;
                    } else {
                        $(this).val(previousValue);
                        alert("Incorrect password. Access level not changed.");
                    }
                }
            });

            $('#submit-update-cat').click(function(event) {
                if ($('#ppv_access').val() === previousValue) {
                    return true;
                } else {
                    event.preventDefault();
                    alert("Please change the access level back or enter the correct password.");
                }
            });
        };
    });
</script>

<script>
    $(document).ready(function(){
        $("#ppv_price_input").change(function(){
            var priceValue = $('#ppv_price_input').val();
            if(priceValue.length === 0){
                $('#ppv_error_req').show();
                $('#submit-update-cat').prop("disabled", true);

            }else{
                $('#ppv_error_req').hide();
                $('#submit-update-cat').prop("disabled", false);
            }
        });
        $("#ios_ppv_price").change(function(){
            var priceValue = $('#ios_ppv_price').val();
            if(priceValue.length === 0){
                $('#ios_error_req').show();
                $('#submit-update-cat').prop("disabled", true);

            }else{
                $('#ios_error_req').hide();
                $('#submit-update-cat').prop("disabled", false);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        function updateFormState() {
            var ppvAccess = $('#ppv_access').val();
            var ppvPrice = $('#ppv_price_input').val();
            var iosPpvPrice = $('#ios_ppv_price').val();
            var ppvInterval = $('#ppv_interval').val();
            var series_seasons_type = $('#series_seasons_type').val();
            var enable_ppv_plans = '<?= @$theme_settings->enable_ppv_plans ?>';
            var enable_video_cipher_upload = '<?= @$theme_settings->enable_video_cipher_upload ?>';
            var transcoding_access = '<?= @$settings->transcoding_access ?>';


            if (ppvAccess === 'ppv' && series_seasons_type == 'VideoCipher') {

                $('#ppv_price_group').hide();
                $('#ios_ppv_price_old').hide();
                $('#ios_ppv_price').hide();
                $('#ppv_intravel_group').show();
                $('#ppv_price_plan').show();
                $('#ios_ppv_price_plan').show();

                if (ppvPrice === '' || iosPpvPrice === '' || ppvInterval === '') {
                    // $('#submit-update-cat').prop('disabled', true);
                    if (ppvPrice === '') $('#ppv_error_req').show();
                    if (iosPpvPrice === '') $('#ios_error_req').show();
                    if (ppvInterval === '') $('#intravel_error_req').show();
                } else {
                    $('#submit-update-cat').prop('disabled', false);
                    $('#ppv_error_req').hide();
                    $('#ios_error_req').hide();
                    $('#intravel_error_req').hide();
                }
            } else if (ppvAccess === 'ppv' && series_seasons_type != 'VideoCipher') {
                $('#ppv_price_group').show();
                $('#ios_ppv_price_old').show();
                $('#ios_ppv_price').show();
                $('#ppv_intravel_group').hide();
                $('#ppv_price_plan').hide();
                $('#ios_ppv_price_plan').hide();

             
            } else {
                $('#ppv_price_group').hide();
                $('#ppv_price_plan').hide();
                $('#ios_ppv_price_old').hide();
                $('#ios_ppv_price_plan').hide();
                $('#ppv_intravel_group').hide();
                $('#submit-update-cat').prop('disabled', false);
                $('#ppv_error_req').hide();
                $('#ios_error_req').hide();
                $('#intravel_error_req').hide();
            }

            
            if(enable_ppv_plans == 0 && enable_video_cipher_upload == 0){
                $('#ppv_price_plan').hide();
                
            }

        }

        updateFormState();

        $('#ppv_access').change(function() {
            updateFormState();
        });

        $('#ppv_price_input, #ios_ppv_price, #ppv_interval').on('input change', function() {
            updateFormState();
        });
    });
</script>
    

    
<script>
          
        var enable_ppv_plans = '<?= @$theme_settings->enable_ppv_plans ?>';
        var enable_video_cipher_upload = '<?= @$theme_settings->enable_video_cipher_upload ?>';
        var transcoding_access = '<?= @$settings->transcoding_access ?>';

    	$('#ppv_price').hide();
        $('#ios_ppv_price_old').hide();
        $('#ios_ppv_price').hide();
        $('#ppv_price_plan').hide();
        $('#ios_ppv_price_plan').hide();

        if(enable_ppv_plans == 1 && enable_video_cipher_upload == 1){
            // alert();
            if($('#ppv_access').val() == "ppv"){
                $('#ppv_price_plan').show();
                $('#ios_ppv_price_plan').show();
                $('#ios_ppv_price').hide();
                $('#ios_ppv_price_old').hide();
            	$('#ppv_price').hide();
    		}else{
                $('#ppv_price_plan').hide();
                $('#ios_ppv_price').hide();
                $('#ios_ppv_price_old').hide();
                $('#ios_ppv_price_plan').hide();
            	$('#ppv_price').hide();
            }
        }else{
            if($('#ppv_access').val() == "ppv"){
                $('#ppv_price').show();
                $('#ios_ppv_price').show();
                $('#ios_ppv_price_old').show();
    		}else{
                $('#ppv_price').hide();
                $('#ios_ppv_price').hide();
                $('#ios_ppv_price_old').hide();
            }
        }
        $('#access').change(function(){
            if($('#access').val() == "ppv"){
            $('#ppv_price').show();
            $('#ios_ppv_price_old').show();
            $('#ios_ppv_price').show();
            }
    	});
        
    $(document).ready(function () {
        $("#submit-update-cat").click(function () {
            $("#update-cat-form").submit();
        });
    });

    
    

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script src="<?= URL::to('/assets/admin/js/jquery.nestable.js');?>"></script>

<script type="text/javascript">



    
    jQuery(document).ready(function($){



    	$('#nestable').nestable({ maxDepth: 3 });

    	// Add New Category
    	$('#submit-new-cat').click(function(){
    		$('#new-cat-form').submit();
    	});

    	$('.actions .edit').click(function(e){
    		$('#update-category').modal('show', {backdrop: 'static'});
    		e.preventDefault();
    		href = $(this).attr('href');
    		$.ajax({
    			url: href,
    			success: function(response)
    			{
    				$('#update-category .modal-content').html(response);
    			}
    		});
    	});

    	$('.actions .delete').click(function(e){
    		e.preventDefault();
    		if (confirm("Are you sure you want to delete this category?")) {
    	       window.location = $(this).attr('href');
    	    }
    	    return false;
    	});

    	$('.dd').on('change', function(e) {
      			$('.category-panel').addClass('reloading');
      			$.post('<?= URL::to('admin/videos/categories/order');?>', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val()  }, function(data){
      				console.log(data);
      				$('.category-panel').removeClass('reloading');
      			});

    	});


    });

    $('.ErrorText').hide();
        $('#ppv_access').change(function () {
            // alert();
            var series_access = '<?= @$series->access ?>';
            if (series_access == 'subscriber' && $('#ppv_access').val() == "ppv") {
                $('#ppv_price').hide();
                $('.ErrorText').show();
                $('#submit-update-cat').prop('disabled', true);
            } else {
                $('#submit-update-cat').prop('disabled', false);
                $('.ErrorText').hide();
            }
        });

        document.getElementById('season_image').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var img = new Image();
            img.onload = function() {
                var width = img.width;
                var height = img.height;
                console.log(width);
                console.log(height);
                
                var validWidth = {{ $compress_image_settings->width_validation_season ?: 1280 }};
                var validHeight = {{ $compress_image_settings->height_validation_season ?: 720 }};
                console.log(validWidth);
                console.log(validHeight);

                if (width !== validWidth || height !== validHeight) {
                    document.getElementById('season_image_error_msg').style.display = 'block';
                    $('#submit-update-cat').prop('disabled', true);
                    document.getElementById('season_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                } else {
                    document.getElementById('season_image_error_msg').style.display = 'none';
                    $('#submit-update-cat').prop('disabled', false);
                }
            };
            img.src = URL.createObjectURL(file);
        }
    });

</script>
<script src="<?= URL::to('/'). '/assets/css/vue.min.js';?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<style>
    .form_video-upload input{
        position:relative;
    }
    .breadcrumb-item+.breadcrumb-item::before{display:none;}

</style>

@stop @stop


 