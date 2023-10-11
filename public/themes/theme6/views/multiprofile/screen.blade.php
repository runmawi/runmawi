@extends('admin.master')

@include('admin.favicon')

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">

	<div class="admin-section-title">
        <div class="iq-card">
		<div class="row">
			<div class="col-md-4">
				<h4><i class="entypo-list"></i> Choose Profile Screen </h4>
			</div>
            <div class="col-md-8" align="right">
                <a href="javascript:;" onclick="jQuery('#screen-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Update</a>
            </div>
            
		</div>
    

<style>
	.theme_name {
		padding: 13px;
		margin-left: 41px;
	}
</style>

    <!-- Add New Modal -->
	<div class="modal fade" id="screen-new">
		<div class="modal-dialog">
			<div class="modal-content">
				    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif    
    
				<div class="modal-header">
                    <h4 class="modal-title">Choose Profile Screen</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				
				<div class="modal-body p-3">
					<form id="screenss" accept-charset="UTF-8" action="{{ URL::to('admin/ChooseProfileScreen_store') }}" method="post" enctype="multipart/form-data">
				        <label for="name">Enter the New Screen Name below</label>
				        <input name="screen_name" id="screen_name" placeholder="Screen Name"  class="form-control" value="" /><br />

				        <label for="theme_image"> Screen Images</label>
				   
                        <div class="control-group">
                            <input type="file" name="screen_image" id="screen_image" required>
                        </div>

				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submit-new-menu">Save changes</button>
				        </div>
				    </form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="sign-in-from  m-auto" >

		<div class="row data">
				@forelse ($screen as $screen_image)
					<div class="theme_image">
						<div class="themes">
							<img src="{{URL::asset('public/uploads/avatars/').'/'.$screen_image->choosenprofile_screen }}"  alt="theme" class="theme_img" style="width:50%">                              
						</div>
						<div class="theme_name">{{ $screen_image ? ucwords($screen_image->profile_name) : ''  }}</div>
					</div>
				@empty 
						<p> No Image Available </p>
				@endforelse
		</div>
	</div>
</div>
        </div>
</div>
</div>
</div>

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
$('form[id="screenss"]').validate({
	rules: {
	   screen_name: {
      required: true,
    },

	screen_image: {
      required: true,
    }
	},
	messages: {
		screen_name: 'Screen Name is required',
		screen_image: 'Screen Image is required',
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

</script>
	@stop
