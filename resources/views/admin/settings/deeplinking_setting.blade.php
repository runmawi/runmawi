@extends('admin.master')

@include('admin.favicon')

@section('content')

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

<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div class="">
	<form id="update-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/linking/store') }}" method="post">
            <div><h4><i class="entypo-globe"></i> Link Settings</h4></div>		 
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                <label for="slug">IOS App Store ID</label>
                <input name="ios_app_store_id" id="ios_app_store_id" placeholder="IOS App Store ID" class="form-control" value="@if(!empty($deeplinking_setting->ios_app_store_id)){{ $deeplinking_setting->ios_app_store_id }}@endif" /><br />
                </div>
                <div class="col-md-6">
                <label for="slug">IOS URL</label>
                <input name="ios_url" id="ios_url" placeholder="IOS URL" class="form-control" value="@if(!empty($deeplinking_setting->ios_url)){{ $deeplinking_setting->ios_url }}@endif" /> 
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <label for="slug">IPAD App Store ID</label>
                <input name="ipad_app_store_id" id="ipad_app_store_id" placeholder="IPAD App Store ID" class="form-control" value="@if(!empty($deeplinking_setting->ipad_app_store_id)){{ $deeplinking_setting->ipad_app_store_id }}@endif" /><br />
                </div>
                <div class="col-md-6">
                <label for="slug">IPAD URL</label>
                <input name="ipad_url" id="ipad_url" placeholder="IPAD URL" class="form-control" value="@if(!empty($deeplinking_setting->ipad_url)){{ $deeplinking_setting->ipad_url }}@endif" /> 
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <label for="slug">Android App Store ID</label>
                <input name="android_app_store_id" id="android_app_store_id" placeholder="Android App Store ID" class="form-control" value="@if(!empty($deeplinking_setting->android_app_store_id)){{ $deeplinking_setting->android_app_store_id }}@endif" /><br />
                </div>
                <div class="col-md-6">
                <label for="slug">Android URL</label>
                <input name="android_url" id="android_url" placeholder="Android URL" class="form-control" value="@if(!empty($deeplinking_setting->android_url)){{ $deeplinking_setting->android_url }}@endif" /> 
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <label for="slug">Windows Phone App Store ID</label>
                <input name="windows_phone_app_store_id" id="windows_phone_app_store_id" placeholder="Windows Phone App Store ID" class="form-control" value="@if(!empty($deeplinking_setting->windows_phone_app_store_id)){{ $deeplinking_setting->windows_phone_app_store_id }}@endif" /><br />
                </div>
                <div class="col-md-6">
                <label for="slug">Windows Phone URL</label>
                <input name="windows_phone_url" id="windows_phone_url" placeholder="Windows Phone URL" class="form-control" value="@if(!empty($deeplinking_setting->windows_phone_url)){{ $deeplinking_setting->windows_phone_url }}@endif" /> 
                </div>
            </div>
        </div>
        
            
        <input type="hidden" name="id" id="id" value="@if(!empty($deeplinking_setting->id)){{ $deeplinking_setting->id }}@endif" />
        <input type="hidden" name="_token" value="<?=csrf_token() ?>" />
</div>

<div class="">
	
	<button type="submit" class="btn btn-primary" id="submit-update-menu">Update</button>
    <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/linking_settings') }}">Close</a>
</div>
</form>

    </div></div>
</div>


	@stop
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script src="jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
// $('#message').fadeOut(120);
setTimeout(function() {
$('#successMessage').fadeOut('fast');
}, 3000);
})
</script>
