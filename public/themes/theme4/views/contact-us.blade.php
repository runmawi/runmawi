@php
    include(public_path('themes/theme4/views/header.php'));
@endphp

<style>
    .error{
        color:red;
    }
</style>

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
	<div class="">
          <div class="">
		<div class="row">
			<div class="col-md-12 text-center" >
				<h4 class="font-weight-bold"><i class="entypo-archive"></i> {{ ('CONTACT US') }} </h4>
			</div>
		</div>
<div class="row justify-content-center mt-4 mb-5">
    <div class="col-xl-8 col-lg-8">
        <div class="login-form">
            <form  id="contact_us_form" method="POST" action="{{ URL::to('/contact-us/store/') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label text-md-right">{{ __('Full Name') }}</label>
                            <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ isset(Auth::user()->firstname) ? Auth::user()->firstname : '' }} {{ isset(Auth::user()->lastname) ? Auth::user()->lastname : '' }}"  autocomplete="Fullname" autofocus>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email" class="col-form-label text-md-right">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ isset(Auth::user()->email) ? Auth::user()->email : '' }}"  autocomplete="email" autofocus>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label text-md-right">{{ __('Phone Number') }}</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ isset(Auth::user()->phone_number) ? Auth::user()->phone_number : '' }}"  autocomplete="phone_number" autofocus>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label text-md-right">{{ __('Subject') }}</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject"  id="subject" autofocus>
                        </div>
                    </div>
                </div>
                  
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="col-form-label text-md-right">{{ __('Message') }}</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" ></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label text-md-right">{{ __('Attach Screenshot') }}</label>

                            <input type="file" class="form-control @error('screenshot') is-invalid @enderror" name="screenshot" autofocus style="line-height: 27px!important;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- reCAPTCHA  --}}
                    @if( get_enable_captcha()  == 1)  
                        <div class="col-md-6">
                            <div class="form-group text-left" style="  margin-top: 30px;">
                                {!! NoCaptcha::renderJs('') !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Message') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
             </div>
    </div>
@php
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp

<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#contact_us_form').validate({
        rules: {
            fullname: "required",
            email: "required",
            subject: "required",
            message: "required",
            phone_number: "required",

        },
        messages: {
            fullname: "This field is required",
            email: "This field is required",
            subject: "This field is required",
            message: "This field is required",
            phone_number: "This field is required",
        },

        submitHandler: function (form) {
            form.submit();
        },
    });
});

</script>