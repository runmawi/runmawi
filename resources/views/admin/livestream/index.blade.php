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
    .lar {
    font-family: 'Line Awesome Free';
    font-weight: 400;
    margin: 4px;
}
     .form-control {
/*background: #fff!important; */
   
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
<style>
   
</style>
<?php 
// foreach($videos as $video){
// 	dd($video->cppuser->username);
// }
?>
<div id="content-page" class="content-page">
   
                    <div class="d-flex">
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/livestream') }}">All Live Videos</a>
                        <a class="black" href="{{ URL::to('admin/livestream/create') }}">Add New Live Video</a>
                        <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Video Categories</a></div>
         <div class="container-fluid p-0">
	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-6">
                <h4><i class="entypo-video"></i> Live Videos</h4>
                
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
			<div class="col-md-6" align="right">	
<!--				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="<?= Request::get('s'); ?>" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>-->
                <a href="{{ URL::to('admin/livestream/create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>    
	
	<div class="clear"></div>

	<div class="gallery-env mt-2">
		
			<table class="data-tables table livestream_table iq-card text-center p-0" style="width:100%">
				<thead>
					<tr class="r1">
						<th>Image</th>
						<th>Title</th>
						<th>User Name</th>
						<th>Video Type</th>
						<th>Video Access</th>
						<th>Status</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($videos as $video)
					<tr>
						<td><img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" width="50" /></td>
						<td><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></td>
						<td> <?php if(!empty(@$video->cppuser->username)){ echo @$video->cppuser->username; }else{ @$video->usernames->username; }?></td>
						<?php if($video->access == "ppv" ){ ?>
						<td> <?php echo "Paid"; ?></td>
					<?php }else{ ?>
						<td> <?php  echo "Free"; ?></td>
					<?php }?>  
						<td>{{ $video->access }}</td>
						<?php if($video->active == 0){ ?>
                        <td> <p class = "bg-warning video_active"><?php echo "Pending"; ?></p></td>
					<?php }elseif($video->active == 1){ ?>
                        <td> <p class = "bg-primary video_active"> <?php  echo "Approved"; ?></p></td>
					<?php }elseif($video->active == 2){ ?>
                        <td>  <p class = "bg-danger video_active"><?php  echo "Rejected"; ?></p></td>
					<?php }?>  

						<td><?php if(strlen($video->description) > 25){ echo substr($video->description, 0, 25) . '...'; } else { echo $video->description; } ?></td>
						<td class=" align-items-center list-inline">								
                            <a href="{{ URL::to('live') .'/'.$video->slug }}" target="_blank" class="iq-bg-warning"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
							<a href="{{ URL::to('admin/livestream/edit') . '/' . $video->id }}" class="iq-bg-success"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
							<a href="{{ URL::to('admin/livestream/delete') . '/' . $video->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		

		<div class="clear"></div>

		<div style="position: relative;top: -50px;" class="pagination-outter mt-3 pull-right"><?= $videos->appends(Request::only('s'))->render(); ?></div>
		
		
	</div>
    </div>
</div>
    
    </div></div>

	@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';
			$('#DataTables_Table_0_paginate').hide();

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
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
	@stop

@stop

