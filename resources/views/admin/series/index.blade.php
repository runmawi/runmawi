@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-movie"></i> Series</h3><a href="{{ URL::to('admin/series/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
			<div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>

	<div class="gallery-env">
		
		<div class="row">

		<table class="table table-striped genres-table">
		<tr class="table-header">
			<th>S.No</th>
			<th>Image</th>
			<th>Series Title</th>
			<th>Genre</th>
			<th>Operation</th>
			@foreach($series as $key=>$series_value)
			<tr>
				<td>{{$series_value->id}}</td>
				<td><img src="{{ URL::to('/') . '/public/uploads/images/' . $series_value->image }}" width="100"></td>
				<td valign="bottom"><p>{{ $series_value->title }}</p></td>
				<td valign="bottom"><p>{{ $series_value->genre_id }}</p></td>
				<td>
					<p>
						<a href="{{ URL::to('play_series') . '/' . $series_value->id }}" class="btn btn-xs btn-info"><span class="fa fa-external-link"></span> Visit Site</a>
						<a href="{{ URL::to('admin/series/edit') . '/' . $series_value->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
						<a href="{{ URL::to('admin/series/delete') . '/' . $series_value->id }}" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
			@endforeach
	</table>

		<div class="clear"></div>

		<div class="pagination-outter"><?= $series->appends(Request::only('s'))->render(); ?></div>
		
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

	@stop

@stop

