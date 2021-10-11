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
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
</style>
@stop


@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">
<div id="admin-container">
     <div class="iq-card">
	<!-- This is where -->

	<div class="admin-section-title">
		<h5><i class="entypo-credit-card"></i> Mobile Settings</h5> 
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
	<div class="clear"></div>

	<form method="POST" action="{{ URL::to('admin/mobile_app/store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            

		<div class="row">

			<div class="panel panel-primary col-md-6" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Splash Screen</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body " style="display: block; > 
                    
					@if(!empty($mobile_settings->splash_image))
					<img src="{{ URL::to('/') . '/public/uploads/settings/' . $mobile_settings->splash_image }}" style="max-height:100px" />
					@endif
					<p>Upload Splash Screen:(960dp x 720dp)</p> 
					<input type="file" multiple="true" class="form-control" name="splash_image" id="splash_image" />

				</div> 

                    
			</div>
                            <div class="col-md-6" align="right">
                <input type="submit" value="Save Settings" class="btn btn-primary pull-right" />
                    </div>
		</div>

		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		
	</form>





	<div class="clear"></div>

	<div class="clear"></div>
    
    <div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Slider</h4>
				</div>
				
                <div class="modal-body">
                    <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/mobile/sliders/store') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                                <label>Image:</label>
                                <input type="file" multiple="true" class="form-control" name="slider" id="slider" />

                            </div> 
                            <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                                <label>Target Link:</label>
                                <input type="text" multiple="true" class="form-control" name="link" id="link" />

                            </div>
                            <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                                <label>Status:</label>
                                <input type="radio" id="active" name="active" value="1">Active
                                <input type="radio" id="active" name="active" value="0">Deactive
                             </div>
                    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>
    
    <!-- Add New Modal -->
	<div class="modal fade" id="update-category">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>
    
                </div>
    </div>
    
    
    
    <input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />  

</div>
</div>

	@section('javascript')

		<script src="<?= URL::to('/assets/admin/js/jquery.nestable.js');?>"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			$('#nestable').nestable({ maxDepth: 3 });

			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-category').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-category .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this category?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
    			$('.category-panel').addClass('reloading');
    			$.post('<?= URL::to('admin/videos/categories/order');?>', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val()  }, function(data){
    				console.log(data);
    				$('.category-panel').removeClass('reloading');
    			});

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
<script src="{{ URL::to('/assets/admin/js/bootstrap-switch.min.js') }}"></script>
@stop

@stop