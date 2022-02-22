<?php
$settings = App\Setting::find(1);
$system_settings = App\SystemSetting::find(1);
?>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Login | <?php echo $settings->website_name ; ?></title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
  </script>
<style>
    h3 {font-size: 30px!important;}
    .from-control::placeholder{
        color: #7b7b7b!important;
    }
    .links{
         color: #fff;
    }
    .nv{
        font-size: 14px;
       color: #fff;
        margin-top: 25px;
    }
    .km{
       text-align:center;
         font-size: 75px;
        font-weight: 900;
        
       
    }
    
       
    .signcont {
 }
    a.f-link {
    margin-bottom: 1rem;
        margin-left: 15vw;
        font-size: 14px;
    
}
   .d-inline-block {
    display: block !important;
}
i.fa.fa-google-plus {
    padding: 10px !important;
}
    .demo_cred {
    background: #5c5c5c69;
    padding: 15px;
    border-radius: 15px;
    border: 2px dashed #51bce8;
    text-align: left;
}    
</style>
    </head>

<body>
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
<section class="sign-in-page" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
        <div class="container">
            <div class="row  align-items-center height-self-center">
                <div class="col-lg-7  col-12">
                    <h1 class="km">Logged Devices</h1>      
                </div>

<table class="table">
<tr class="table-header">
    <th style="color:white;"><label>S.No</label></th>
    <th style="color:white;"><label>Username</label></th>
    <th style="color:white;"><label>User Ip</label></th>
    <th style="color:white;"><label>Device Name</label></th>
    <th style="color:white;"><label>Action</label></th>

    @foreach($alldevices as $key => $devices)
    <tr>
        <td style="color:white;">{{$devices->id}}</td>
        <td style="color:white;" valign="bottom"><p>{{ @$devices->user_name->username }}</p></td>
        <td style="color:white;" valign="bottom"><p>{{ $devices->user_ip }}</p></td>
        <td style="color:white;" valign="bottom"><p>{{ $devices->device_name }}</p></td>
        <td style="color:red;" >
            <div class="d-flex align-items-center list-user-action">
                <a href="{{ URL::to('/device/logout/verify/') . '/' . $devices->id }}" class="iq-bg-danger ml-2"><i
                onclick="return confirm('Are you sure?')" ></i> Deregister</a>
            </div>
        </td>
    </tr>
    @endforeach
</table>

<div class="clear"></div>
            </div>
   </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
                    <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  </script>
</body>
   
</html>

