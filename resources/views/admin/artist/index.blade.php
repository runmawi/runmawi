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

<div class="admin-section-title" style="margin-left: 340px;
    padding-top: 100px;">
      <div class="iq-card">
	<div class="row mt-3">
		<div class="col-md-6">
            
			<h4><i class="entypo-newspaper"></i> Manage Artist</h4>
           
		</div>
		<div class="col-md-4">	
			<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="<?= Request::get('s'); ?>" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
		</div>
        <div class="col-md-2">
             <a href="{{ URL::to('admin/artists/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create Artist</a>
        </div>
	</div>
    

<div class="clear"></div>


<table class="table table-striped artists-table">
	<tr class="table-header">
		<th><label>S.No</label></th>
		<th><label>Image</label></th>
		<th><label>Artist Name</label></th>
		<th><label>Operation</label></th>
		@foreach($artists as $key=>$artist)
		<tr>
			<td>{{$artist->id}}</td>
			<td><img src="{{ URL::to('/public/uploads/artists/') . '/'.$artist->image }}" width="100"></td>
			<td valign="bottom"><p>{{ $artist->artist_name }}</p></td>
			<td>
				<p class="d-flex align-items-center list-user-action">
					<a href="{{ URL::to('admin/artists/edit') . '/' . $artist->id }}" class="iq-bg-warning"><i class="lar la-eye"></i> </a>
					<a href="{{ URL::to('admin/artists/delete') . '/' . $artist->id }}" class="iq-bg-danger"><i
                                                class="ri-delete-bin-line"></i></a>
				</p>
			</td>
		</tr>
		@endforeach
	</table>
</div>
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