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
</style>

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

	<div class="admin-section-title"  style="margin-left: 330px;
    padding-top: 100px;">
         <div class="iq-card">
		<div class="row align-items-center p-2">
			<div class="col-md-5">
				<h4><i class="entypo-movie"></i> Series</h4>
			</div>
			<div class="col-md-5 mt-3">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
                
			</div>
            <div class="col-md-2">
                <a href="{{ URL::to('admin/series/create') }}" class="btn btn-primary mt-2"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
		</div>
	
	<div class="clear"></div>

	<div class="gallery-env">
		
		<div class="row mt-3 p-2">

		<table class="table">
		<tr class="table-header">
			<th><label>S.No</label></th>
			<th><label>Image</label></th>
			<th><label>Series Title</label></th>
			<th><label>Genre</label></th>
			<th><label>Operation</label></th>
			@foreach($series as $key=>$series_value)
			<tr>
				<td>{{$series_value->id}}</td>
				<td><img src="{{ URL::to('/') . '/public/uploads/images/' . $series_value->image }}" width="100"></td>
				<td valign="bottom"><p>{{ $series_value->title }}</p></td>
				<td valign="bottom"><p>{{ $series_value->genre_id }}</p></td>
				<td>
					<div class="d-flex align-items-center list-user-action">
						<a href="{{ URL::to('play_series') . '/' .$series_value->title }}" class="iq-bg-warning" ><i class="lar la-eye"></i> <!--Visit Site--></a>
						<a href="{{ URL::to('admin/series/edit') . '/' . $series_value->id }}" class="iq-bg-success ml-2"><i class="ri-pencil-line"></i> <!--Edit--></a>
						<a href="{{ URL::to('admin/series/delete') . '/' . $series_value->id }}" class="iq-bg-danger ml-2"><i
						onclick="return confirm('Are you sure?')" class="ri-delete-bin-line"></i> <!--Delete--></a>
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

