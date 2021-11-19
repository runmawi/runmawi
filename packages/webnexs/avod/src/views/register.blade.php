@extends('layouts.app')

<!doctype html>
<html lang="en-US">
   <head>
      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
// print_r($uppercase);
// exit();
      ?>
      <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name;?>
    <title><?php echo $uppercase.' | ' . $settings->website_name ; ?></title>
    <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
     <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/responsive.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
<style>
    /*.sign-user_card {
        background: none !important;
    }*/
#ck-button {
    margin:4px;
/*    background-color:#EFEFEF;*/
    border-radius:4px;
/*    border:1px solid #D0D0D0;*/
    overflow:auto;
    float:left;
}
#ck-button label {
    float:left;
    width:4.0em;
}
#ck-button label span {
    text-align:center;
    display:block;
    color: #fff;
    background-color: #3daae0;
    border: 1px solid #3daae0;
    padding: 0;
}
#ck-button label input {
    position:absolute;
/*    top:-20px;*/
}

#ck-button input:checked + span {
    background-color:#3daae0;
    color:#fff;
}
    
.mobile-div {
    margin-left: -2%;
    margin-top: 1%;
}
.modal-header {
    padding: 0px 15px;
    border-bottom: 1px solid #e5e5e5 !important;
    min-height: 16.42857143px;
}
#otp {
    padding-left: 15px;
    letter-spacing: 42px;
    border: 0;
   /* background-image: linear-gradient(to right, black 60%, rgb(120, 120, 120) 0%);*/
    background-position: bottom;
    background-size: 50px 1px;
    background-repeat: repeat-x;
    background-position-x: 80px;
}
    #otp:focus {
        border: none;
    }
    /*.sign-up-buttons{
        margin-left: 40% !important;
    }*/.verify-buttons{
        margin-left: 36%;
    }
    .container{
        margin-top: 70px;
    }
    .panel-heading {
    margin-bottom: 1rem;
}
  
.phselect{
    width: 100px !important;
    height: 45px !important;
    background: transparent !important;
    color: var(--iq-white) !important;
}
.form-control {
    height: 45px;
    line-height: 45px;
    background: transparent !important;
    border: 1px solid var(--iq-body-text);
    font-size: 14px;
    color: var(--iq-white) !important;
    border-radius: 0;
    margin-bottom: 1rem !important;
}
    .form-control:focus {
     color: var(--iq-white) !important;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
}
    .custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
/*input[type="file"] {
    display: none;
}*/
    .catag {
    padding-right: 150px !important;
}
i.fa.fa-google-plus {
    padding: 10px !important;
}
    option {
    background: #474644 !important;
}
    .reveal{
        margin-left: -92px !important;
    height: 45px !important;
    background: transparent !important;
    color: #fff !important;
    }
</style>

<section style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); ?>
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
    

?>

<div class="container">
      <div class="row justify-content-center align-items-center height-self-center">
         <div class="col-sm-9 col-md-7 col-lg-5 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto">
                      <div align="center">
                          <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" style="margin-bottom:1rem;">       <h3 class="mb-3 text-center">Advertiser Sign Up</h3>
                      </div>
                      <form action="{{url('advertiser/post-register')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                            <div class="form-group">

                                <div class="col-md-12">
                                    <input id="company_name" type="text"  class="form-control alphaonly  @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" required autocomplete="off" autofocus>

                                    @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <input id="license_number" type="text"  class="form-control   @error('license_number') is-invalid @enderror" name="license_number" value="{{ old('license_number') }}" placeholder="Licence Number" required autocomplete="off" autofocus>

                                    @error('license_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                

                            <div class="col-md-12">
                                <input id="mobile_number" type="tel" placeholder="Mobile Number"  class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" required autocomplete="off">

                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                    <input id="address" type="text"  class="form-control alphaonly  @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="Address" required autocomplete="off" autofocus>

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                <input id="email_id" type="email" placeholder="Email Id"  class="form-control @error('email_id') is-invalid @enderror" name="email_id" value="{{ old('email_id') }}" required autocomplete="off">

                                @error('email_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                
                                 <div class="col-md-12">
                                     <div class="row">
                                     <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror pwd" name="password" required autocomplete="new-password">
                                         </div>
                                         <div >
                                
                                         </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                         </div>
                            </div>
                                 
                            </div>
                          
                        <div class="form-group" >
                            
                            <div class="sign-up-buttons col-md-12" align="right">
                                  
                                  <button class="btn btn-hover btn-primary btn-block signup" style="display: block;" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
                                </div>
                        </div>
                      
                        
                    </form>
                  </div>
               </div>    
               <div class="mt-3">
                  <div class="d-flex justify-content-center links">
                     Already have an account? <a href="<?= URL::to('advertiser/login')?>" class="text-primary ml-2">Sign In</a>
                  </div>                        
               </div>
            </div>
         </div>
      </div>
   </div>

<!-- Modal -->
<style>
    .modal-content {
        background-color: #000000;
    }
</style>

    </section>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    function visibility1() {
  var x = document.getElementById('password');
  if (x.type === 'password') {
    x.type = "text";
    $('#eyeShow').show();
    $('#eyeSlash').hide();
  }else {
    x.type = "password";
    $('#eyeShow').hide();
    $('#eyeSlash').show();
  }
}
</script>
<script>
    function visibility2() {
  var x = document.getElementById('password-confirm');
  if (x.type === 'password') {
    x.type = "text";
    $('#eyeShow1').show();
    $('#eyeSlash1').hide();
  }else {
    x.type = "password";
    $('#eyeShow1').hide();
    $('#eyeSlash1').show();
  }
}
</script>
<script>
    $('.alphaonly').bind('keyup blur',function(){ 
    var node = $(this);
    node.val(node.val().replace(/[^a-z,^A-Z ]/g,'') ); }
);
</script>



 <!-- jQuery, Popper JS -->
      <script src="{{URL::to('/')}}/assets/js/jquery-3.4.1.min.js"></script>
      <script src="{{URL::to('/')}}/assets/js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="{{URL::to('/')}}/assets/js/bootstrap.min.js"></script>
      <!-- Slick JS -->
      <script src="{{URL::to('/')}}/assets/js/slick.min.js"></script>
      <!-- owl carousel Js -->
      <script src="{{URL::to('/')}}/assets/js/owl.carousel.min.js"></script>
      <!-- select2 Js -->
      <script src="{{URL::to('/')}}/assets/js/select2.min.js"></script>
      <!-- Magnific Popup-->
      <script src="{{URL::to('/')}}/assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script src="{{URL::to('/')}}/assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script src="{{URL::to('/')}}/assets/js/custom.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
      <script type="text/javascript">
        <?php if(session('success')){ ?>
            toastr.success("<?php echo session('success'); ?>");
        <?php }else if(session('error')){  ?>
            toastr.error("<?php echo session('error'); ?>");
        <?php }else if(session('warning')){  ?>
            toastr.warning("<?php echo session('warning'); ?>");
        <?php }else if(session('info')){  ?>
            toastr.info("<?php echo session('info'); ?>");

        <?php } ?>

    </script>


@include('footer')

@endsection 
