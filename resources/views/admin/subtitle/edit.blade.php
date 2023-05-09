@extends('admin.master')

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
                        <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Update Subtitle</h4>
                        </div>
                     </div>
<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/subtitles/update') }}" method="post" enctype="multipart/form-data">
       
         <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                        <label>Name:</label>

                        <input type="text" id="language" name="language" value="{{ $Subtitles->language }}" class="form-control" placeholder="Enter Language Name">
                        @if ($errors->has('language'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('language') }}</strong>
                            </span>
                        @endif

                    </div>
        
        

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label>Slug:</label>

                        <input type="text" id="short_code" name="short_code" value="{{ $Subtitles->short_code }}" class="form-control" placeholder="Enter Short Code">
                        @if ($errors->has('slug'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif

                    </div>


        <input type="hidden" name="id" id="id" value="{{ $Subtitles->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-info" id="submit-update-cat">Update</button>
</div>
</div>    </div>    </div>    </div>    </div>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
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