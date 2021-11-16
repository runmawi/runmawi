@extends('moderator.master')
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
         <div class="container-fluid">
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
                <a href="{{ URL::to('/cpp/livestream/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>    
	
	<div class="clear"></div>

	<div class="gallery-env mt-2">
		
			<table class="data-tables table livestream_table " style="width:100%">
				<thead>
					<tr>
						<th><label>Image</label></th>
						<th><label>Title</label></th>
						<th><label>User Name</label></th>
						<th><label>Video Type</label></th>
						<th><label>Video Access</label></th>
						<th><label>Status</label></th>
						<th><label>Description</label></th>
						<th><label>Action</label></th>
					</tr>
				</thead>
				<tbody>
					@foreach($videos as $video)
					<tr>
						<td><img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" width="50" /></td>
						<td><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></td>
						<td> <?php echo @$video->cppuser->username; ?></td>
						<?php if($video->access == "ppv" ){ ?>
						<td> <?php echo "Paid"; ?></td>
					<?php }else{ ?>
						<td> <?php  echo "Free"; ?></td>
					<?php }?>  
						<td>{{ $video->access }}</td>
						<?php if($video->active == 0){ ?>
						<td class="bg-warning"> <?php echo "Pending"; ?></td>
					<?php }elseif($video->active == 1){ ?>
						<td class="bg-success"> <?php  echo "Approved"; ?></td>
					<?php }elseif($video->active == 2){ ?>
						<td class="bg-danger"> <?php  echo "Rejected"; ?></td>
					<?php }?>  

						<td><?php if(strlen($video->description) > 25){ echo substr($video->description, 0, 25) . '...'; } else { echo $video->description; } ?></td>
						<td class="d-flex align-items-center list-user-action">
                            <!-- <a href="{{ URL::to('live/play/') . '/' . $video->id }}" target="_blank" class="iq-bg-warning"><i class="lar la-eye"></i></a> -->
							<a href="{{ URL::to('cpp/livestream/edit') . '/' . $video->id }}" class="iq-bg-success"><i class="ri-pencil-line"></i></a>
							<a href="{{ URL::to('cpp/livestream/delete') . '/' . $video->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><i
                                                class="ri-delete-bin-line"></i></a>
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

