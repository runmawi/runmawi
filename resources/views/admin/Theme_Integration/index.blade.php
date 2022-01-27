@extends('admin.master')




@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">

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

    <div class="col-md-12">
                <div class="sign-in-from  m-auto" >

                <div class="row data">
                        @foreach ($Themes as $theme_integration)
                            <div class="theme_image">
                                <div class="themes">
                                    <img src="{{URL::asset('public/uploads/settings/').'/'.$theme_integration->theme_images }}" alt="theme" class="theme_img" style="width:50%" id= {{ $theme_integration->id  }}>  
                                </div>
                                <div class="theme_name">{{ $theme_integration ? ucwords($theme_integration->theme_name) : ''  }}</div>
                            </div>
                        @endforeach  
                </div>
            </div>
    </div>
</div>
</div>
</div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@section('javascript')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>


$( document ).ready(function() {


    $(".theme_img,#test").click(function(){

    theme_id=this.id;

        swal({
            title: "Are you sure?",
            text: "To Apply this Theme",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnConfirm: false,
        })
         .then((willDelete) => {
            if (willDelete) {
            $.ajax({
                    url: '{{ URL::to('admin/ThemeIntegration/set_theme') }}',
                    type: "get",
                    data:{ 
                        _token: "{{csrf_token()}}" ,
                            id: theme_id,
                        }
                }).done(function() {
                    swal({
                        title: "Applied", 
                        text: "Theme has been successfully Changed", 
                        type: "success"
                    }).then(function() {
                        location.href = '{{ URL::to('admin/ThemeIntegration') }}';
                    });
                });   
                } else {
                    swal({
                        title: "Restored", 
                        text: "Theme has been successfully Restored", 
                        type: "success"
                    })
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

