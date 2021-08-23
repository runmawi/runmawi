@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')
<style>
   
</style>

<div id="content-page" class="content-page">
         <div class="container-fluid">
	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-6">
                <h4><i class="entypo-video"></i> Live Videos</h4>
                
			</div>
			<div class="col-md-6" align="right">	
<!--				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="<?= Request::get('s'); ?>" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>-->
                <a href="{{ URL::to('admin/livestream/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>    
	
	<div class="clear"></div>

	<div class="gallery-env">
		
			<table class="data-tables table livestream_table " style="width:100%">
				<thead>
					<tr>
						<th><label>Image</label></th>
						<th><label>Name</label></th>
						<th><label>Description</label></th>
						<th><label>Action</label></th>
					</tr>
				</thead>
				<tbody>
					@foreach($videos as $video)
					<tr>
						<td><img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" width="50" /></td>
						<td><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></td>
						<td><?php if(strlen($video->description) > 25){ echo substr($video->description, 0, 25) . '...'; } else { echo $video->description; } ?></td>
						<td><a href="{{ URL::to('channelVideos/play_videos/') . '/' . $video->id }}" target="_blank"><i class="fa fa-eye"></i></a>
							<a href="{{ URL::to('admin/livestream/edit') . '/' . $video->id }}" class="album-options"><i class="fa fa-edit"></i></a>
							<a href="{{ URL::to('admin/livestream/delete') . '/' . $video->id }}" class="delete"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		

		<div class="clear"></div>

		<div class="pagination-outter"><?= $videos->appends(Request::only('s'))->render(); ?></div>
		
		
	</div>
    </div>
</div>
    
    </div></div>

	@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>

	@stop

@stop

