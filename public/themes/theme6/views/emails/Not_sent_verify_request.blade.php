@extends('layouts.app')

<?php
include(public_path('themes/default/views/header.php'));
?>

@section('content')
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
<style>

    .content{
        padding-top: 100px !important;
    }
    .page-height{
        min-height: 450px !important;
    }
    .verifyemail-text {
        border-radius: 5px;
        background: rgba(255, 255, 255, 0.07);
        padding: 30px 30px;
    }

    i.ri-settings-4-line.text-primary {
        color: {{ button_bg_color() .'!important' }} ;
    }

    i.ri-logout-circle-line.text-primary{
        color: {{ button_bg_color() .'!important' }} ;
    }
</style>

<body>
<div class="container">
	<div class="row page-height">
		<div class="col-sm-8 offset-2 content">
			<div class="verifyemail-text">
				<h3><i class="fa fa-check-circle"></i> sorry for the inconvenience , A Verification link not sent to your email account.</h3>   <br>
                
				<p class="text-white"> Please Contact Admin for other details </p>

                <button onclick="location.href='{{  URL::to('login') }}' " type="button"> Go to Login </button>

			</div>
		</div>
	</div>
</div>
</body>



@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

@endsection 