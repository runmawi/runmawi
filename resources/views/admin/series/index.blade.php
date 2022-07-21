@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 25px;
    }
    .lar{
        margin: 4px;
    }
     .form-control {
   /* background: #fff!important; */
   
}
     .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

	<div class="admin-section-title">
        <div id="content-page" class="content-page">
    <div class="container-fluid">

        <div class="d-flex">
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/series-list') }}"> Series List</a>
        <a class="black" href="{{ URL::to('admin/series/create') }}"> Add New Series</a></div>
         <div class="iq-card">
		<div class="row align-items-center p-2">
			<div class="col-md-5">
				<h4><i class="entypo-movie"></i> Series</h4>
			</div>
			<div class="col-md-5 mt-3">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
                
			</div>
            <div class="col-md-2 mb-2">
                <a href="{{ URL::to('admin/series/create') }}" class="btn btn-primary mt-2"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
		</div>
	
	<div class="clear"></div>

	<div class="gallery-env">
		
		<div class="row mt-3 p-2">

		<table class="table text-center iq-card">
		<tr class="table-header r1">
			<th><label>S.No</label></th>
			<th><label>Image</label></th>
			<th><label>Series Title</label></th>
			<th><label>Genre</label></th>
			<th><label>Slider</label></th>
			<th><label>Operation</label></th>
			@foreach($series as $key=>$series_value)
			<tr>
				<td>{{$key + 1}}</td>
				<td><img src="{{ URL::to('/') . '/public/uploads/images/' . $series_value->image }}" width="100"></td>
				<td valign="bottom"><p>{{ $series_value->title }}</p></td>
				<td valign="bottom"><p>{{ $series_value->genre_id }}</p></td>
				<td valign="bottom">
					<div class="mt-1">
						<label class="switch">
							<input name="video_status" class="video_status" id="{{ 'video_'.$series_value->id }}" type="checkbox" @if( $series_value->banner == "1") checked  @endif data-video-id={{ $series_value->id }}  data-type="video" onchange="update_series_banner(this)" >
							<span class="slider round"></span>
						</label>
					</div>
				</td>
				<td>
					<div class=" align-items-center list-user-action">
						<a href="{{ URL::to('play_series') . '/' .$series_value->slug }}" class="iq-bg-warning" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"> <!--Visit Site--></a>
						<a href="{{ URL::to('admin/series/edit') . '/' . $series_value->id }}" class="iq-bg-success ml-2"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"> <!--Edit--></a>
						<a href="{{ URL::to('admin/series/delete') . '/' . $series_value->id }}" class="iq-bg-danger ml-2"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"><i
						onclick="return confirm('Are you sure?')" class=""></i> <!--Delete--></a>
					</div>
				</td>
			</tr>
			@endforeach
	</table>

		<div class="clear"></div>

		<div class="pagination-outter"><?= $series->appends(Request::only('s'))->render(); ?></div>
		
		</div>
		
	</div>
        </div>
        </div>
        </div>
	@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this series?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>

	<script>
		function update_series_banner(ele){

		var video_id = $(ele).attr('data-video-id');
		var status   = '#video_'+video_id;
		var video_Status = $(status).prop("checked");

		if(video_Status == true){
			var banner_status  = '1';
			var check = confirm("Are you sure you want to active this slider?");  

		}else{
			var banner_status  = '0';
			var check = confirm("Are you sure you want to remove this slider?");  
		}


		if(check == true){ 

		$.ajax({
					type: "POST", 
					dataType: "json", 
					url: "{{ url('admin/series_slider_update') }}",
						data: {
							_token  : "{{csrf_token()}}" ,
							video_id: video_id,
							banner_status: banner_status,
					},
					success: function(data) {
						if(data.message == 'true'){
							//  location.reload();
						}
						else if(data.message == 'false'){
							swal.fire({
							title: 'Oops', 
							text: 'Something went wrong!', 
							allowOutsideClick:false,
							icon: 'error',
							title: 'Oops...',
							}).then(function() {
								location.href = '{{ URL::to('admin/ActiveSlider') }}';
							});
						}
					},
				});
		}else if(check == false){
		$(status).prop('checked', true);

		}
		}
	</script>

	@stop

@stop

