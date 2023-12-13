@extends('admin.master') @section('css')
<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop @section('content')
<div id="content-page" class="content-page">
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
                        <p class="p1">(16:9 Ratio or 1080 X 1920px)</p>
                        @if(!empty($season->image))
                        <img src="{{  $season->image }}" class="movie-img" width="200" />
                        @endif
                        <input type="file" multiple="true" class="form-control" name="image" id="image" />
                    </div>
                    <!-- <div class="form-group">
                        <label>Season Landing Page MP4 URL </label><br>
                        <input type="text" value ="@if(!empty($season->landing_mp4_url)){{ $season->landing_mp4_url }}@endif" class="form-control" name="landing_mp4_url" id="landing_mp4_url" >
                    </div> -->
                    <div class="form-group">
                        <label class="m-0">Season Trailer :</label>
                        <p class="p1">Drop and drag the video file</p>
                        <div style="position: relative;" class="form_video-upload">
                            <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" />
                            <p class="p1">Drop and drag the video file</p>
                        </div>
                        <?php if(!empty($season->trailer)){ ?>
                        <video width="200" height="200" controls>
                            <source src="<?php echo $season->trailer; ?>" type="video/mp4" />
                        </video>
                        <?php }else{  } ?>
                    </div>

                    <div class="form-group {{ $errors->has('ppv_access') ? 'has-error' : '' }}">
                        <label class="m-0"> Choose User Access:</label>
                        <select class="form-control" id="ppv_access" name="ppv_access">
                            <option value="free" @if(!empty($season->access) && $season->access == 'free'){{ 'selected' }}@endif>Free (everyone)</option>
                            <option value="ppv" @if(!empty($season->access) && $season->access == 'ppv'){{ 'selected' }}@endif>PPV (Pay Per Season(Episodes))</option>
                        </select>
                    </div>
                    <div class="form-group {{ $errors->has('ppv_price') ? 'has-error' : '' }}" id="ppv_price">
                        <label class="m-0">PPV Price:</label>
                        <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($season->ppv_price)){{ $season->ppv_price }}@endif" />
                    </div>
                    <div class="form-group" >
                        <label class="m-0">IOS PPV Price:</label>
                        <select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                            <option value= "" >Select IOS PPV Price: </option>
                            @foreach($InappPurchase as $Inapp_Purchase)
                                <option value="{{ $Inapp_Purchase->product_id }}"  @if(!empty($season->product_id) && $season->product_id == $Inapp_Purchase->product_id){{ 'selected' }} @endif > {{ $Inapp_Purchase->plan_price }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group {{ $errors->has('ppv_interval') ? 'has-error' : '' }}">
                        <label class="m-0">PPV Interval:</label>
                        <p class="p1">Please Mention How Many Episodes are Free:</p>
                        <input type="text" id="ppv_interval" name="ppv_interval" value="@if(!empty($season->ppv_interval)){{ $season->ppv_interval }}@endif" class="form-control" />
                    </div>

                    <input type="hidden" name="id" id="id" value="{{ $season->id }}" />
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                    <div class="modal-footer form-group">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <a type="button" class="btn btn-primary" data-dismiss="modal" href="{{ URL::to('admin/series/edit'.'/'.$season->series_id) }}">Close</a>
                        <button type="submit" class="btn btn-primary" id="submit-update-cat" action="{{ URL::to('admin/sliders/update') }}">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

@section('javascript')
<script>
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
    	$('#ppv_price').hide();
            // alert($('#ppv_access').val());
    	if($('#ppv_access').val() == "ppv"){
    		$('#ppv_price').show();
    		$('#ios_ppv_price').show();
    		}
            $('#access').change(function(){
    		if($('#access').val() == "ppv"){
    		$('#ppv_price').show();
    		$('#ios_ppv_price').show();
    		}
    	});

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
</script>
<script src="<?= URL::to('/'). '/assets/css/vue.min.js';?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

@stop @stop


 