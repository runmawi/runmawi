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
    .p1{
        font-size: 12px;
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
	.make-switch{
		z-index:2;
	}
         
      
	</style>

@stop

@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<div id="content-page" class="content-page">
   <div class="d-flex">
      <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
      <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
      <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
      <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
      <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
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
      <div class="iq-card">
         <div id="admin-container">
            <div class="admin-section-title">
               <h4><i class="entypo-globe"></i> Storage Settings</h4> <hr>
            </div>
	         <div class="clear"></div>
                <form method="POST" action="{{ URL::to('admin/storage_settings/save') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="storage_settings">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading"> <div class="panel-title"><label>Site Storage</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                <div class="panel-body row"> 
                                    <div class="form-group col-md-4">  
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                            <div class="mr-2">OFF</div>
                                                <label class="switch mt-2">
                                                <input name="site_storage" class="site_storage" id="site_storage" type="checkbox" @if( $storage_settings->site_storage == "1") checked  @endif >
                                                <span class="slider round"></span>
                                                </label>
                                            <div class="ml-2">ON</div>
                                        </div>                              
                                    </div>                               
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading"> <div class="panel-title"><label>AWS Storage</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                <div class="panel-body row"> 
                                    <div class="form-group col-md-4">     
                                        <div class="mt-1 d-flex align-items-center justify-content-around">
                                            <div class="mr-2">OFF</div>
                                                <label class="switch mt-2">
                                                <input name="aws_storage" class="aws_storage" id="aws_storage" type="checkbox" @if( $storage_settings->aws_storage == "1") checked  @endif >
                                                <span class="slider round"></span>
                                                </label>
                                            <div class="ml-2">ON</div>
                                        </div>                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- AWS Env Details -->
                    <div class="row" id="aws_details">
                        <div class="col-sm-6">
                            <label class="">AWS ACCESS KEY  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_access_key" id="aws_access_key" value="@if(!empty($storage_settings->aws_access_key)){{ $storage_settings->aws_access_key }}  @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS SCRETE KEY  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_secret_key" id="aws_secret_key" value="@if(!empty($storage_settings->aws_secret_key)){{ $storage_settings->aws_secret_key }}  @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS REGION  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_region" id="aws_region" value="@if(!empty($storage_settings->aws_region)){{ $storage_settings->aws_region }} @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS BUCKET  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_bucket" id="aws_bucket" value="@if(!empty($storage_settings->aws_bucket)){{ $storage_settings->aws_bucket }} @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS Storage Video Path (Ex: /path/to )  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_storage_path" id="aws_storage_path" value="@if(!empty($storage_settings->aws_storage_path)){{ $storage_settings->aws_storage_path }} @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS Storage Video Trailer Path (Ex: /path/to )  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_video_trailer_path" id="aws_video_trailer_path" value="@if(!empty($storage_settings->aws_video_trailer_path)){{ $storage_settings->aws_video_trailer_path }} @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS Storage Season Trailer Path (Ex: /path/to )  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_season_trailer_path" id="aws_season_trailer_path" value="@if(!empty($storage_settings->aws_season_trailer_path)){{ $storage_settings->aws_season_trailer_path }} @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS Storage Season Episode Path (Ex: /path/to )  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_episode_path" id="aws_episode_path" value="@if(!empty($storage_settings->aws_episode_path)){{ $storage_settings->aws_episode_path }} @endif" />
                           </div>
                        </div>


                        <div class="col-sm-6">
                            <label class="">AWS Storage Live Path (Ex: /path/to )  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_live_path" id="aws_live_path" value="@if(!empty($storage_settings->aws_live_path)){{ $storage_settings->aws_live_path }} @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS Storage Audios Path (Ex: /path/to )  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_audio_path" id="aws_audio_path" value="@if(!empty($storage_settings->aws_audio_path)){{ $storage_settings->aws_audio_path }} @endif" />
                           </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="">AWS Transcode Path (Ex: /path/to )  </label>
                            <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="aws_transcode_path" id="aws_transcode_path" value="@if(!empty($storage_settings->aws_transcode_path)){{ $storage_settings->aws_transcode_path }} @endif" />
                           </div>
                        </div>

                    </div>
                    
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }} " />

                    <div class="col-md-12 form-group" align="right">
                        <input type="submit" value="Update Settings" class="btn btn-primary " />
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>



@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
    .swal2-popup.swal2-modal.swal2-show {
        width: 24% !important;
    }
</style>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	jQuery(document).ready(function($){

        
        $('#aws_details').hide(); 
        var aws_storage = "{{ $storage_settings->aws_storage }}";
        if(aws_storage == 1){
            $('#aws_details').show(); 
        }

        $('.aws_storage').on('change', function(event) {
            var aws_storage = $("#aws_storage").prop("checked");
            $('#site_storage').prop('checked', false); // Unchecks it
                if(aws_storage == true){
                    $('#aws_details').show(); 
                    Swal.fire({
                        title: 'Aws - Storage',
                        imageWidth: 320,
                        imageHeight: 200,
                        imageAlt: 'Custom image',
                    })
                }else{
                    $('#site_storage').prop('checked', true); // checks it
                    $('#aws_details').hide(); 
                
                }
        });
    });


</script>
