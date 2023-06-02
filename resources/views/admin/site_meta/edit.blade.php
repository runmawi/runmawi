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
                           <h4 class="card-title">Update Page Meta</h4>
                        </div>
                     </div>
<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ route('meta_setting_update') }}" method="post" enctype="multipart/form-data">
       
         <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                        <label>Page Name:</label>
                        <select name="page_name"  class= "form-control" style="width: 100%;">
                        @foreach($page_name as $key => $meta_name)
                        <option value="{{ $meta_name }}" @if( !empty($SiteMeta->page_slug) && $SiteMeta->page_slug == $key )selected='selected' @endif >{{ $meta_name }}</option>
                        @endforeach
                     </select>
                  </div> 
                        <!-- <input type="text" id="page_name" name="page_name" value="{{ $SiteMeta->page_name }}" class="form-control" placeholder="Enter Page Name"> -->
                        @if ($errors->has('page_name'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('page_name') }}</strong>
                            </span>
                        @endif

                    </div>
        
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                        <label>Page Title:</label>

                        <input type="text" id="page_title" name="page_title" value="{{ $SiteMeta->page_title }}" class="form-control" placeholder="Enter Page Title">
                        @if ($errors->has('page_title'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('page_title') }}</strong>
                            </span>
                        @endif

                        </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label>Meta Description:</label>

                        <input type="text" id="meta_description" name="meta_description" value="{{ $SiteMeta->meta_description }}" class="form-control" placeholder="Enter Meta Description">
                        @if ($errors->has('meta_description'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif

                    </div>
                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label>Meta Keyword:</label>

                        <input type="text" id="meta_keyword" name="meta_keyword" value="{{ $SiteMeta->meta_keyword }}" class="form-control" placeholder="Enter Meta Keyword">
                        @if ($errors->has('meta_keyword'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif

                    </div>

        <input type="hidden" name="id" id="id" value="{{ $SiteMeta->id }}" />
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