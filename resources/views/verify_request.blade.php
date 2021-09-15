@extends('layouts.app')

@section('content')
@include('/header')
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
</style>
<body>
<div class="container">
	<div class="row page-height">
		<div class="col-sm-8 offset-2 content">
			<div class="verifyemail-text">
				<h3><i class="fa fa-check-circle"></i> A Verification link has been sent to your email account.</h3>  
				<p class="text-white"> Please click on the link that has been sent to your email account to verify your email and continue the registration process.</p>
			</div>
		</div>
	</div>
</div>
</body>



@include('footer')
@endsection 