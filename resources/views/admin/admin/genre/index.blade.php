@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ Url::to('/application/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-newspaper"></i> Manage Genre</h3><a href="{{ URL::to('admin/genre-create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Genre</a>
			</div>
			<div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="<?= Input::get('s'); ?>" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped genres-table">
		<tr class="table-header">
			<th>S.No</th>
			<th>Image</th>
			<th>Genre Name</th>
			<th>Operation</th>
			@foreach($genres as $key=>$genre)
			<tr>
				<td>{{$genre->id}}</td>
				<td><img src="{{ Config::get('site.uploads_dir') . 'genres/' . $genre->image }}" width="100"></td>
				<td valign="bottom"><p>{{ $genre->name }}</p></td>
				<td>
					<p>
						<a href="{{ URL::to('admin/genre-edit') . '/' . $genre->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
						<a href="{{ URL::to('admin/genre-delete') . '/' . $genre->id }}" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
			@endforeach
	</table>

	<div class="clear"></div>

	<div class="pagination-outter"><?= $genres->appends(Request::only('s'))->render(); ?></div>
	<script src="{{ Url::to('/application/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$ = jQuery;
		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this genre?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>


@stop

