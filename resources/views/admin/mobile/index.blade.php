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


<style>
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #dfd5d5;
  width: auto;
  height: auto;
}

.tab button {
  display: block;
  background-color: #fafafb;
  color: #83878a;
  padding: 15px 65px;
  width: 100%;
  border: 1px solid #ccc;
  border-width: 0 0 1px;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

.tab button:hover {
  background-color: #eaeaf0;
}
.tab button.active {
  background-color: #eaeaf0;
}
.col-md-6.submit {
    position: absolute;
    margin-top: -5%;
}

</style>

@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">
<div id="admin-container">
     <div class="iq-card">
	<!-- This is where -->


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

	<div class="admin-section-title">
		<h4><i class="entypo-globe"></i>  Mobile Settings</h4> 
        <hr>
	</div>

	<div class="d-flex" id="wrapper">
	<div class="border-end bg-white" id="sidebar-wrapper">
		<div class="tab">
			<button class="tablinks" onclick="screen(event, 'Splash')" id="defaultOpen">Splash Screen</button>
			<button class="tablinks" onclick="screen(event, 'Welcome')">Welcome Screen</button>
		</div>
	</div>

	<div class="col-md-12 mob_screens" id="Splash" >

		<div class="row">
			<div class="col-md-8">
				<label for="" align="left" >Splash Screen</label>
			</div>
			<div class="col-md-4">
				<a href="javascript:;" onclick="jQuery('#splash-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>
	

		<div class="sign-in-from" >
		<div class="row data">

				@forelse ($mobile_settings as $splash)
					<div class="splash_image" style="padding: 20px;">
						<div class="">
							<img src="{{ URL::to('/') . '/public/uploads/settings/' . $splash->splash_image }}" style="max-height:100px" />
						</div>

						<div class="action" align="right">
							<a href="{{ route('Splash_edit', ['id' => $splash->id]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
							<a href="{{ route('Splash_destroy', ['id' => $splash->id]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
						</div>
					</div>
				@empty  
						<p> No Splash Screen Available </p>
				@endforelse
		</div>
	</div>
</div>



{{-- Welcome screen --}}

	<form method="post" action="{{ URL::to('welcome-screen') }}" accept-charset="UTF-8" enctype="multipart/form-data" id="Welcome" class="mob_screens">
		@csrf     
		<div class="">
			<div class="panel panel-primary col-md-12" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label style="font-weight: 600;">Welcome Screen</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body " style="display: block;" > 
					<p>Upload Welcome Screen:(960dp x 720dp)</p> 
					<input type="file" multiple="true" class="form-control" name="welcome_image[]" id="welcome_image" />
				</div> 
			</div>

            <div class="col-md-6 submit" align="right">
                <input type="submit" value="Save Settings" class="btn btn-primary pull-right" />
            </div>
		</div>
	</form>

{{--End Welcome screen --}}
</div>



<!-- Add New Splash  Modal -->
<div class="modal fade" id="splash-new">
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
				<h4 class="modal-title">New Splash</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
			</div>
			
			<div class="modal-body p-3">
				<form id="Splash" accept-charset="UTF-8" action="{{ URL::to('admin/mobile_app/store') }}" method="post" enctype="multipart/form-data">
			
					<div class="control-group">
						<label for="theme_image">Splash Preview Images</label>
						<input type="file" name="splash_image" id="splash_image" accept="image/*" >
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
<!-- End New Splash  Modal -->


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


<script>
	function screen(evt, screens) {
	  var i, mob_screens, tablinks;
	  mob_screens = document.getElementsByClassName("mob_screens");
	  for (i = 0; i < mob_screens.length; i++) {
		mob_screens[i].style.display = "none";
	  }
	  tablinks = document.getElementsByClassName("tablinks");
	  for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	  }
	  document.getElementById(screens).style.display = "block";
	  evt.currentTarget.className += " active";
	}
	
	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
	</script>
	   
@stop

@stop