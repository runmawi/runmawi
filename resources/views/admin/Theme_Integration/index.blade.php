@extends('admin.master')

@section('content')

<style>
    .theme_image:hover {
        border: 2px solid rgb(64, 172, 37);
        padding: 10px;
        border-radius: 25px;
    }
    .theme_name {
        color: #c92727;
        text-align: center;
        font-family: 'FontAwesome';
    }
    .active{
        color: #1ba31b;
        position: absolute;
        left: 15px;
        font-family: unset;
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

<div id="content-page" class="content-page">
       <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
    <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
    <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
    <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
   <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
   
    <div class="mt-4">
         <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
    <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
     <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
    <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
    <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
 
         <div class="container-fluid mt-5">

	<div class="admin-section-title">
        <div class="iq-card">
		<div class="row">
			<div class="col-md-4">
				<h4><i class="entypo-list"></i> Themes </h4>
			</div>
            <div class="col-md-8" align="right">
                <a href="javascript:;" onclick="jQuery('#theme-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
            
		</div>
    <div class="col-md-12" style="padding:30px;">
                <div class="sign-in-from  m-auto" >

                <div class="row data">
                        @foreach ($Themes as $theme_integration)
                            <div class="theme_image col-md-4">
                                <div class="zoom themes">
                                    <img class="theme_img w-100" src="{{URL::asset('public/uploads/settings/').'/'.$theme_integration->theme_images }}" alt="theme"  style="width:25%" id= {{ $theme_integration->id  }}>  
                                </div>
                                <div class="theme_name">
                                    {{ $theme_integration ? ucwords($theme_integration->theme_name) : ''  }}
                                    @if( $theme_integration->theme_name == $active_Status->theme_choosen)
                                       <span class="active" >
                                        <i class="far fa-check-circle"></i>  {{'Active'}}
                                      </span>                                
                                    @endif
                                </div>
                            </div>
                        @endforeach  
                </div>
            </div>
    </div>


    <!-- Add New Modal -->
	<div class="modal fade" id="theme-new">
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
                    <h4 class="modal-title">New Themes</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body p-3">
					<form id="ThemeIntegration" accept-charset="UTF-8" action="{{ URL::to('admin/ThemeIntegration/create') }}" method="post" enctype="multipart/form-data">
				        <label for="name">Enter the New Themes Name below</label>
				        <input name="theme_name" id="theme_name" placeholder="Theme Name"  class="form-control" value="" /><br />

				   
                        <div class="control-group">
				            <label for="theme_image">Theme Preview Images</label>
                            <input type="file" name="theme_image" id="theme_image" accept="image/*" >
                        </div>

                        <div class="control-group">
                             <label for="theme_zip">Theme Zip File</label><br>
                            <input type="file" name="theme_zip" id="theme_zip" >
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

    
</div>
</div>
</div>

</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('javascript')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>


$( document ).ready(function() {
    $(".theme_img,#test").click(function(){
    theme_id=this.id;

    Swal.fire({
        title: 'Are you sure?',
        text: 'To Apply this Theme!',
        icon: 'warning',
        allowOutsideClick:false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
    $.ajax({
            url: '{{ URL::to('admin/ThemeIntegration/set_theme') }}',
            type: "get",
            data:{ 
                _token: "{{csrf_token()}}" ,
                id: theme_id, }
                }).done(function() {
                    swal.fire({
                        title: 'Applied', 
                        text: 'Theme has been successfully Changed', 
                        allowOutsideClick:false,
                        type: 'success',
                        icon: 'success',
                    }).then(function() {
                        location.href = '{{ URL::to('admin/ThemeIntegration') }}';
                    });
                });
  }
});      
});


// validation
    $( "#ThemeIntegration" ).validate({
        rules: {
                theme_image: {
                    required: true,
                },
                theme_zip: {
                    required: true,
                },
                theme_name: {
                    required: true,
                    remote: {
                        url: '{{ URL::to('admin/ThemeIntegration/uniquevalidation') }}',
                        type: "post",
                        data: {
                            _token: "{{csrf_token()}}" ,
                            themename: function() {
                            return $( "#theme_name" ).val(); }
                        }
                    }
                }
            },
                messages: {
                    theme_name: {
                        required: "Theme Name is required",
                        remote: "Theme Name already in taken ! Please try another Name"
                    },
                    theme_image: {
                         required: "Theme Image is required",
                    }
                }
    });
});

</script>
@stop

