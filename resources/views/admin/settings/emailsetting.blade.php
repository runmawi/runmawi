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
    .media-body{
      border-left: 0px !important;
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
               <h4><i class="entypo-globe"></i> Email Settings</h4> <hr>
            </div>
	         <div class="clear"></div>

            <div id="smtpsetting">
               <div class="tab">
                  <button class="tablinks1 btn btn-light">SMTP</button>
                  <button class="tablinks2 btn btn-light">Microsoft 365</button>
                  <form method="POST" action="{{ URL::to('admin/email_settings/save') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Email_setting_form">
                        <div class="row mt-4">
                           <div class="col-md-6">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>Admin Email</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="admin_email" id="admin_email" value="@if(!empty($email_settings->admin_email)){{ $email_settings->admin_email }}@endif" />
                                    </div>
                              </div>
                           </div>
                  
                           <div class="col-md-6">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>Email Host</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="email_host" id="email_host" value="@if(!empty($email_settings->host_email)){{ $email_settings->host_email }}@endif" />
                                    </div>
                              </div>
                           </div>

                           <div class="col-md-6 mt-3">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>Email Port</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="email_port" id="email_port" value="@if(!empty($email_settings->email_port)){{ $email_settings->email_port }}@endif" />
                                    </div>
                              </div>
                           </div>

                           <div class="col-md-6 mt-3">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>Secure </label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <select id="secure" name="secure" class="form-control" required>
                                          <option value="ssl" @if(!empty($email_settings->secure) && $email_settings->secure == 'ssl'){{ 'selected' }}@endif> TRUE</option>
                                          <option value="tls" @if(!empty($email_settings->secure) && $email_settings->secure == 'tls'){{ 'selected' }}@endif >FALSE</option>
                                       </select>
                                    </div>
                              </div>
                           </div>

                           <div class="col-md-6 mt-3">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>Email User</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="email_user" id="email_user" value="@if(!empty($email_settings->user_email)){{ $email_settings->user_email }}@endif" />
                                    </div>
                              </div>
                           </div>

                           <div class="col-md-6 mt-3">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>Email Password</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="password" class="form-control" name="password" id="password" value="@if(!empty($email_settings->email_password)){{ $email_settings->email_password }}@endif" />
                                    </div>
                              </div>
                           </div>
                        </div>
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <div class="panel-body mt-3 ml-2">
                           <input type="submit" value="Update Email Settings" class="btn btn-primary" />
                        </div>
                     </form>
               </div>
            </div>

            <div id="officesetting">
               <div class="tab">
                  <button class="tablinks1 btn btn-light">SMTP</button>
                  <button class="tablinks2 btn btn-light">Microsoft 365</button>
                  <form method="POST" action="{{ URL::to('admin/email_settings/microsoftsave') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Microsoft365_email_setting_form">
                        <div class="row mt-4">
                           <div class="col-md-6">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>M365 Admin Email</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="microsoft365_admin_email" id="microsoft365_admin_email" value="@if(!empty($email_settings->microsoft365_admin_email)){{ $email_settings->microsoft365_admin_email }}@endif" />
                                    </div>
                              </div>
                           </div>
                  
                           <div class="col-md-6">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>M365 Scope</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="microsoft365_scope" id="microsoft365_scope" value="@if(!empty($email_settings->microsoft365_scope)){{ $email_settings->microsoft365_scope }}@endif" />
                                    </div>
                              </div>
                           </div>

                           <div class="col-md-6 mt-3">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>M365 Tenant ID</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="microsoft365_tenant_id" id="microsoft365_tenant_id" value="@if(!empty($email_settings->microsoft365_tenant_id)){{ $email_settings->microsoft365_tenant_id }}@endif" />
                                    </div>
                              </div>
                           </div>

                           <div class="col-md-6 mt-3">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>M365 Client ID</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="microsoft365_client_id" id="microsoft365_client_id" value="@if(!empty($email_settings->microsoft365_client_id)){{ $email_settings->microsoft365_client_id }}@endif" />
                                    </div>
                              </div>
                           </div>

                           <div class="col-md-6 mt-3">
                              <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title"><label>M365 Client Secret</label></div>
                                       <div class="panel-options">
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       <input type="text" class="form-control" name="microsoft365_client_secret" id="microsoft365_client_secret" value="@if(!empty($email_settings->microsoft365_client_secret)){{ $email_settings->microsoft365_client_secret }}@endif" />
                                    </div>
                              </div>
                           </div> 


                           <div class="col-md-6 mt-3">
                              <div>
                                 <label for="enable_microsoft365">Enable M365:</label>
                                 <input type="checkbox" @if(!empty($email_settings->enable_microsoft365) && $email_settings->enable_microsoft365 == 1){{ 'checked="checked"' }}@endif name="enable_microsoft365" value="1" id="enable_microsoft365" />
                              </div>
                           </div>


                        </div>
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <div class="panel-body mt-3 ml-2">
                           <input type="submit" value="Update Email Settings" class="btn btn-primary" />
                        </div>
                     </form>
               </div>
            </div>
     
         </div>
      </div>
   </div>


   <div class="container-fluid p-0">
      <div class="iq-card">
         <div id="admin-container">
            <div class="admin-section-title">
               <h4><i class="entypo-globe"></i> Test Email Settings</h4> <hr>
            </div>
	         <div class="clear"></div>

            <form method="post" action="{{ URL::to('admin/Testing_EmailSettting') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
               <div class="row mt-4">
                  <div class="col-md-6">
                     <div class="panel panel-primary" data-collapsed="0">
                           <div class="panel-heading">
                              <div class="panel-title"><label>Email</label></div>
                              <div class="panel-options">
                                 <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                              </div>
                           </div>
                           <div class="panel-body" style="display: block;">
                              <input type="text" class="form-control" name="test_mail" id="test_mail" required />
                           </div>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
               <div class="panel-body mt-3 ml-2">
                  <button type="submit" class="btn btn-primary" > Send Mail</button>
               </div>
            </form>
     
         </div>
      </div>
   </div>

</div>

<div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Email Templates</h4>
                        </div>
                        
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2"> <a href="{{ route('email_logs') }}" class="btn btn-primary" > Email Logs </a> </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table id="template" class="table table-striped table-bordered text-center table movie_table " style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>ID</th>
                                    <th>Template</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($email_template as $template)
                                 <tr>
                                 <td> <p class="mb-0">{{ $template->id }}</p></td>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="media-body text-white  ml-3">
                                             <p class="mb-0">{{ $template->template_type }}</p>
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $template->heading }}</td>
                                    <td>
                                       <div class="align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('admin/template/view') . '/' . $template->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/template/edit') . '/' . $template->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="clear"></div>

		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>


   <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

 <script>


$('form[id="Email_setting_form"]').validate({
        rules: {
            email_user: "required",
            admin_email: "required",
            email_host: "required",
            email_port: "required",
        },
        submitHandler: function (form) {
            form.submit();
        },
    });


$('form[id="Microsoft365_email_setting_form"]').validate({
   rules: {
      microsoft365_admin_email: "required",
      microsoft365_scope: "required",
      microsoft365_tenant_id: "required",
      microsoft365_client_id: "required",
      microsoft365_client_secret: "required",
   },
   submitHandler: function (form) {
      form.submit();
   },
});


$(document).ready(function(){

   $('#template').DataTable();

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ URL::to('admin/template_search') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>

<script src="{{ URL::to('/assets/admin/js/jquery.nestable.js') }}"></script>
<script>
   $('#smtpsetting').show();
   $('#officesetting').hide();
  
   $('.tablinks1').click(function() {
      $('#smtpsetting').show();
      $('#officesetting').hide();
   });
   $('.tablinks2').click(function() {
      $('#smtpsetting').hide();
      $('#officesetting').show();
   });
</script>


 

@stop




 
