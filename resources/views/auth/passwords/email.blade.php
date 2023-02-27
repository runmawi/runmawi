<?php
$settings = App\Setting::find(1);
?>
<html>
<head>
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
        <title>Reset Password | <?php echo $settings->website_name ; ?></title>
        <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
        <link rel="stylesheet" href="<?= URL::to('/assets/admin/css/font-awesome.min.css'); ?>" />
        <link rel="stylesheet" href="<?= URL::to( '/assets/admin/css/email/hellovideo-fonts.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>

        <link rel="stylesheet" href="<?=  URL::to('/assets/css/style.css'); ?>" />
        <link rel="stylesheet" href="<?=  URL::to('/assets/css/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" href="<?=  URL::to('/assets/css/typography.css'); ?>" />
        <link rel="stylesheet" href="<?=  URL::to('/assets/css/responsive.css'); ?>" />
        <link rel="stylesheet" href="<?=  URL::to('/assets/admin/css/animate.min.css'); ?>" />

        <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>if (!window.jQuery) { document.write('<script src="<?= URL::to('/assets/js/jquery.min.js'); ?>"><\/script>'); }</script>

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <style>
        /*Button Bg color  */
            .btn{
                background-color:  {{ button_bg_color() .'!important' }} ;
                border:   {{ '1px solid'. button_bg_color() .'!important' }};
            }

.container.page-height {
        padding-top: 80px !important;
}
            .sign-in-from{
                padding: 0;
            }
    i.fa.fa-google-plus {
    padding: 10px !important;
}
   
    .container-fluid{
      
    }
    h1{
        color: #fff;
    }
    .h{
        color: #fff; 
    }
            .km {
    text-align: center;
    font-size: 75px;
    font-weight: 900;
}
            input{
                border: 1px solid gray!important;
            }
            .reset-help{
                margin-top: 10px;
                padding: 15px;
                            }
            .sign-user_card{
                padding: 20px;
            }
</style>
    </head>
<body>
    

<section class="sign-in-page" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat;background-size: cover;height:650px;padding:10% 0 10% 0;">
<div class="container">
    <div class="row justify-content-around">
        <div class="col-lg-7 col-12 align-self-center">
              <div class="" >
              <h1 class="km">FREE EDUTAINMENT FOR THE DIGITAL WARRIOR
</h1>
                  </div>
          </div>

       
                  
           <div class="col-lg-4 col-md-12 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto" align="center">
                      
                  <img class="mb-2" src="<?php echo  URL::to('/assets/img/nem.png')?>" alt="<?php echo $settings->website_name ; ?>"/>
                   
                 
                      <h2 class="mb-3 text-center h">{{ __('Forgot Password') }}</h2>
			
                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert" style="font-size: 15px;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                       
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder= "email@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
								<p class="reset-help text-center">We will send you an email with instructions on how to reset your password.</p>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								
                                @if( $mail_status == 1)

                                     <button type="submit" class="btn btn-primary">
                                         {{ __('Send Password Reset Link') }}
                                     </button>

                                 @elseif( $mail_status == 0 )
                        <div class="text-center">
                                    <button type="reset" id="Mail_error"  class="btn btn-primary" >  {{ __('Send Password Reset Link') }} </button></div>
                                @endif
                    </form>
                     </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $("#Mail_error").click(function(){
            alert("Can't send email at this time, Contact Support Team");
        });
    });
</script>



</body>
</html>
