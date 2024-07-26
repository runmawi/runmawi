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
p.welcome_p {
    display: block;
    margin-top: 1em !important;
    margin-bottom: 0em;
    margin-left: 13em;
    margin-right: 0;
}
</style>

@section('content')
<div id="content-page" class="content-page">
    <div class="d-flex">
       <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
		<a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
		<a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
		<a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
		<a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
		<a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
	</div>

	<div class="d-flex">
         <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
		<a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
		<a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
		<a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
		<a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
 
            <div class="container-fluid p-0">
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
		<h4><i class="entypo-globe"></i>  Mobile Settings</h4><hr>
	</div>

	<div class="d-flex" id="wrapper">
		<div class="border-end bg-white" id="sidebar-wrapper">
			<div class="tab">
				<button class="tablinks" onclick="screen(event, 'Splash')" id="defaultOpen">Splash Screen</button>
				<button class="tablinks" onclick="screen(event, 'Welcome')">Welcome Screen</button>
				<button class="tablinks" onclick="screen(event, 'device_version')">Device Version</button>
				<button class="tablinks" onclick="screen(event, 'tv_splash_screen')">TV Splash Screen</button>
				</div>
		</div>

					{{-- Splash screen --}}
		<div class="col-md-12 mob_screens" id="Splash" >
			<div class="row">
				<div class="col-md-8">
					<label for="" align="left"  style="font-weight: 600;">Splash Screen</label>
				</div>
				<div class="col-md-4">
					<a href="javascript:;" onclick="jQuery('#splash-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
				</div>
			</div>
		
			<div class="sign-in-from" >
			<div class="row data">
								{{-- Splash Screen --}}

					@forelse ($mobile_settings as $key => $splash)
						<div class="splash_image" style="padding: 20px;">
							<div class="">
								<img src="{{ URL::to('/') . '/public/uploads/settings/' . $splash->splash_image }}" style="max-height:100px" />
							</div>

							<span> {{ 'IOS' }} {{ $key + 1 }}  </span>

							<div class="action" align="right">
								<a href="{{ route('Splash_edit', ['id' => $splash->id ,'source'=>'ios' ]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
								<a href="{{ route('Splash_destroy', ['id' => $splash->id ,'source'=>'ios' ]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</div>
						</div>
					@empty  
							<p> No Splash Screen Available </p>
					@endforelse

								{{-- Andriod Splash Screen --}}

					@forelse ($mobile_settings as $key => $andriod_splash)
						<div class="splash_image" style="padding: 20px;">
							<div class="">
								<img src="{{ URL::to('/') . '/public/uploads/settings/' . $andriod_splash->andriod_splash_image }}" style="max-height:100px" />
							</div>

							<span> {{ 'Andriod'  }}  {{ $key + 1 }} </span>

							<div class="action" align="right">
								<a href="{{ route('Splash_edit', ['id' => $andriod_splash->id , 'source'=>'andriod']) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
								<a href="{{ route('Splash_destroy', ['id' => $andriod_splash->id ,'source'=>'andriod' ]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</div>
						</div>
					@empty  
					@endforelse
			</div>
		</div>
	</div>

				{{-- Welcome screen --}}

	<div id="Welcome" class="col-md-12 mob_screens">
		<div class="row">
			<div class="col-md-8">
				<label for="" align="left" style="font-weight: 600;">Welcome Screen</label>
			</div>
			<div class="col-md-4">
				<a href="javascript:;" onclick="jQuery('#welcome-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>

		<div class="sign-in-from" >
			<div class="row data">
					@forelse ($welcome_screen as $welcomeScreen)
						<div class="welcome_image" style="padding: 20px;">
							<div class="">
								<img src="{{ URL::to('/') . '/public/uploads/settings/' . $welcomeScreen->welcome_images }}" style="max-height:100px" />
							</div>
	
							<div class="action" align="right">
								<a href="{{ route('welcomescreen_edit', ['id' => $welcomeScreen->id]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
								<a href="{{ route('welcomescreen_destroy', ['id' => $welcomeScreen->id]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</div>
						</div>
					@empty  
							<p class="welcome_p"> No Welcome Screen Available </p>
					@endforelse
			</div>
		</div>
	</div>

			{{-- Device Version --}}

	<div id="device_version" class="col-md-12 mob_screens">
		<div class="row">
			<div class="col-md-8">
				<label for="" align="left" style="font-weight: 600;">{{ __('Device version') }}</label>
			</div>
		</div>

		<form action="{{route('mobile_app.device_version')}}" method="get">
			<div class="col-md-4">
				<input type="text" class="form-control" name="ios_device_version" value="{{ !empty($mobile_settings[0]) && !is_null($mobile_settings[0]->ios_device_version) ? $mobile_settings[0]->ios_device_version : null }}" placeholder="IOS Device Version"><br>
				<button type="submit" class="btn btn-primary" >Update</button>  
			</div>
		</form>
	</div>


	{{-- TV Splash screen --}}
		<div class="col-md-12 mob_screens" id="tv_splash_screen" >
			<div class="row">
				<div class="col-md-8">
					<label for="" align="left"  style="font-weight: 600;">TV Splash Screen</label>
				</div>
				<div class="col-md-4">
					<a href="javascript:;" onclick="jQuery('#tv-splash-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
				</div>
			</div>
		
			<div class="sign-in-from" >
			<div class="row data">
								{{-- TV Splash Screen --}}

					@forelse ($tv_splash_screen as $key => $AndroidTv_splash_screen)
						<div class="tv_splash_image" style="padding: 20px;">
							<div class="">
								<img src="{{ URL::to('/') . '/public/uploads/settings/' . $AndroidTv_splash_screen->AndroidTv_splash_screen }}" style="max-height:100px" />
							</div>

							<span> {{ 'Android TV' }} {{ $key + 1 }}  </span>

							<div class="action" align="right">
								<a href="{{ route('TV_Splash_edit', ['id' => $AndroidTv_splash_screen->id  ]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
								<a href="{{ route('TV_Splash_destroy', ['id' => $AndroidTv_splash_screen->id  ]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</div>
						</div>
					@empty  
							<p> No Splash Screen Available </p>
					@endforelse

								{{-- LG Splash Screen --}}

					@forelse ($tv_splash_screen as $key => $LG_splash_screen)
						<div class="splash_image" style="padding: 20px;">
							<div class="">
								<img src="{{ URL::to('/') . '/public/uploads/settings/' . $LG_splash_screen->LG_splash_screen }}" style="max-height:100px" />
							</div>

							<span> {{ 'LG Splash'  }}  {{ $key + 1 }} </span>

							<div class="action" align="right">
								<a href="{{ route('TV_Splash_edit', ['id' => $LG_splash_screen->id ]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
								<a href="{{ route('TV_Splash_destroy', ['id' => $LG_splash_screen->id  ]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</div>
						</div>
					@empty  
					@endforelse

					
					{{-- RokuTV Splash Screen --}}

						@forelse ($tv_splash_screen as $key => $RokuTV_splash_screen)
							<div class="splash_image" style="padding: 20px;">
								<div class="">
									<img src="{{ URL::to('/') . '/public/uploads/settings/' . $RokuTV_splash_screen->RokuTV_splash_screen }}" style="max-height:100px" />
								</div>

								<span> {{ 'RokuTV Splash'  }}  {{ $key + 1 }} </span>

								<div class="action" align="right">
									<a href="{{ route('TV_Splash_edit', ['id' => $RokuTV_splash_screen->id ]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
									<a href="{{ route('TV_Splash_destroy', ['id' => $RokuTV_splash_screen->id  ]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
								</div>
							</div>
						@empty  
						@endforelse



				{{-- Samsung Splash Screen --}}

				@forelse ($tv_splash_screen as $key => $Samsung_splash_screen)
					<div class="splash_image" style="padding: 20px;">
						<div class="">
							<img src="{{ URL::to('/') . '/public/uploads/settings/' . $Samsung_splash_screen->Samsung_splash_screen }}" style="max-height:100px" />
						</div>

						<span> {{ 'Samsung Splash'  }}  {{ $key + 1 }} </span>

						<div class="action" align="right">
							<a href="{{ route('TV_Splash_edit', ['id' => $Samsung_splash_screen->id ]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
							<a href="{{ route('TV_Splash_destroy', ['id' => $Samsung_splash_screen->id  ]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
						</div>
					</div>
				@empty  
				@endforelse


				{{-- Firetv Splash Screen --}}

				@forelse ($tv_splash_screen as $key => $Firetv_splash_screen)
					<div class="splash_image" style="padding: 20px;">
						<div class="">
							<img src="{{ URL::to('/') . '/public/uploads/settings/' . $Firetv_splash_screen->Firetv_splash_screen }}" style="max-height:100px" />
						</div>

						<span> {{ 'Firetv Splash'  }}  {{ $key + 1 }} </span>

						<div class="action" align="right">
							<a href="{{ route('TV_Splash_edit', ['id' => $Firetv_splash_screen->id  ]) }}" ><i class="fa fa-pencil" aria-hidden="true"></i></a>	
							<a href="{{ route('TV_Splash_destroy', ['id' => $Firetv_splash_screen->id  ]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
						</div>
					</div>
				@empty  
				@endforelse

			</div>
		</div>
		
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
						<label for="theme_image">Splash Preview Images <span> (IOS) </span></label>
						<input type="file" name="splash_image" id="splash_image" required >
					</div>

					<div class="control-group">
						<label for="theme_image"> Splash Preview Images <span> (Andriod) </span></label>
						<input type="file" name="andriod_splash_image" id="andriod_splash_image"  required>
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


<!-- Add New welcome  Modal -->
<div class="modal fade" id="welcome-new">
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
				<h4 class="modal-title">New welcome</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body p-3">
				<form id="" accept-charset="UTF-8" action="{{ URL::to('welcome-screen') }}" method="post" enctype="multipart/form-data">
					<div class="control-group">
						<label for="theme_image">Welcome Preview Images</label>
						<input type="file" class="form-control" name="welcome_image[]" id="welcome_image" accept="image/*" multiple="true" >
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





<!-- Add New Splash  Modal -->
<div class="modal fade" id="tv-splash-new">
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
				<h4 class="modal-title">New TV Splash Screen</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			
			<div class="modal-body p-3">
				<form id="Splash" accept-charset="UTF-8" action="{{ URL::to('admin/tv_splash_screen/store') }}" method="post" enctype="multipart/form-data">
					<div class="control-group">
						<label for="theme_image">Android Splash Screen <span> (TV) </span></label>
						<input type="file" name="AndroidTv_splash_screen" id="AndroidTv_splash_screen" required >
					</div>

					<div class="control-group">
						<label for="theme_image"> LG Splash Screen <span> (TV) </span></label>
						<input type="file" name="LG_splash_screen" id="LG_splash_screen"  required>
					</div>

					<div class="control-group">
						<label for="theme_image"> RokuTV Splash Screen <span> (TV) </span></label>
						<input type="file" name="RokuTV_splash_screen" id="RokuTV_splash_screen"  required>
					</div>

					<div class="control-group">
						<label for="theme_image"> Samsung Splash Screen <span> (TV) </span></label>
						<input type="file" name="Samsung_splash_screen" id="Samsung_splash_screen"  required>
					</div>

					<div class="control-group">
						<label for="theme_image"> Firetv Splash Screen <span> (TV) </span></label>
						<input type="file" name="Firetv_splash_screen" id="Firetv_splash_screen"  required>
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