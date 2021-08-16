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

<div class="admin-section-title" >
      <div class="iq-card">
	<div class="row">
		<div class="col-md-8">
			<h3><i class="entypo-newspaper"></i> Manage Artist</h3><a href="{{ URL::to('admin/artists/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Artist</a>
		</div>
		<div class="col-md-4">	
			<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="<?= Request::get('s'); ?>" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
		</div>
	</div>
    </div>

<div class="clear"></div>


<table class="table table-striped artists-table">
	<tr class="table-header">
		<th>S.No</th>
		<th>Image</th>
		<th>Artist Name</th>
		<th>Operation</th>
		@foreach($artists as $key=>$artist)
		<tr>
			<td>{{$artist->id}}</td>
			<td><img src="{{ URL::to('/public/uploads/artists/') . '/'.$artist->image }}" width="100"></td>
			<td valign="bottom"><p>{{ $artist->artist_name }}</p></td>
			<td>
				<p>
					<a href="{{ URL::to('admin/artists/edit') . '/' . $artist->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
					<a href="{{ URL::to('admin/artists/delete') . '/' . $artist->id }}" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
				</p>
			</td>
		</tr>
		@endforeach
	</table>

	<div class="clear"></div>

	<div class="pagination-outter"><?= $artists->appends(Request::only('s'))->render(); ?></div>
	<script src="{{ Url::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$ = jQuery;
		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this artist?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
				return false;
			});
		});

	</script>
	@stop