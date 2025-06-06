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
    <div class="d-flex">
    <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/Writer') }}">All Writer</a>
    <a class="black" href="{{ URL::to('admin/Writer/create') }}">Add New Writer</a></div>
      <div class=" container-fluid p-0">
          <div class="iq-card">
	<div class="row mt-3">

		<div class="col-md-6">
			<h4><i class="entypo-newspaper"></i> Manage Writer</h4>
		</div>
		
		@if (Session::has('message'))
            <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        @if(count($errors) > 0)
            @foreach( $errors->all() as $message )
            	<div class="alert alert-danger display-hide" id="successMessage" >
					<button id="successMessage" class="close" data-close="alert"></button>
					<span>{{ $message }}</span>
                </div>
            @endforeach
        @endif

		<div class="col-md-3">	
			<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="<?= Request::get('s'); ?>" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
		</div>
        <div class="col-md-3 text-right">
             <a href="{{ URL::to('admin/Writer/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create Writer</a>
        </div>
	</div>
    

<div class="clear"></div>


	<table class="table  artists-table iq-card text-center p-0">
			<tr class="r1">
				<th><label> S.No </label></th>
				<th><label> Image </label></th>
				<th><label> Writer Name </label></th>
				<th><label> Writer Type </label></th>
				<th><label> Action </label></th>
				
				@foreach($artists as $key=>$artist)
				<?php if($artist->image == 'default.jpg'){ $artistimage = default_vertical_image_url(); }else{ $artistimage = URL::to('/public/uploads/artists/') . '/'.$artist->image;} ?>
				<tr>
					<td>{{ $key+1 }}</td>
					<td><img src="{{ $artistimage }}" width="100"></td>
					<td valign="bottom"><p> {{ $artist->artist_name ?  $artist->artist_name : "No  Arist Name Found"  }} </p></td>
					<td valign="bottom"><p> {{ $artist->artist_type ?  str_replace('_', ' ', $artist->artist_type) : "No  Arist Type Found"  }} </p></td>
					<td>
						<p class=" align-items-center list-user-action">
							<a href="{{ URL::to('admin/Writer/edit') . '/' . $artist->id }}" class="iq-bg-warning"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"> </a>
							<a href="{{ URL::to('admin/Writer/delete') . '/' . $artist->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
						</p>
					</td>
				</tr>
			@endforeach
	</table>
</div>
	<div class="clear"></div></div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
	<div class="pagination-outter"><?= $artists->appends(Request::only('s'))->render(); ?></div>
	<script src="{{ Url::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$ = jQuery;
		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this writer?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
				return false;
			});
		});

	</script>
	<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
    </div>
	@stop
	