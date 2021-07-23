<html>
    <head>
    </head>


<style>

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
    .container.page-height {
        padding-top: 80px !important;
}
    i.fa.fa-google-plus {
    padding: 10px !important;
}

</style>
<section class="sign-in-page"style="background:url('<?php echo URL::to('/').'/assets/img/home/vod-header.png'; ?>') no-repeat;background-size: cover;">
<div class="container  page-height">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-offset-4">
            <div class="sign-user_card login-block text-center forgot-box">
                <h2 class="mb-3 text-center">{{ __('Reset Password') }}</h2>
				<div class="card-body">
					<form method="POST" action="{{ route('password.update') }}">
						@csrf

						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group row">
							

							<div class="col-md-12">
								<label for="email" class="col-form-label text-left">{{ __('E-Mail Address') }}</label>
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>					

							<div class="col-md-12">
								<label for="password" class="col-form-label text-left">{{ __('Create Password') }}</label>
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>

							<div class="col-md-12">
								<label for="password-confirm" class="col-form-label text-left">{{ __('Confirm Password') }}</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary btn-hover">
									{{ __('Reset Password') }}
								</button>
							</div>
						</div>
					</form>
				</div>
        	</div>
    	</div>
	</div>
</div>
</section>
