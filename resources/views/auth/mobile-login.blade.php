@include('header')

 <?php
   $settings = App\Setting::find(1);
 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>
<div class="container">
    <div class="row justify-content-center">		
	 

		<div class="col-md-4 col-sm-offset-4">
			<div class="login-block">
				<div class="card-header"><h2 class="form-signin-heading">{{ __('Sign-In') }}</h2></div>

				<div class="card-body">
					<!-- <form method="POST" action="{{ URL::to('/sendOtp') }}" class="form-signin"> -->
						<!-- @csrf -->
						
						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
                         
                        @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                        @endif
						<div class="form-group row margin-bottom-5">
							<div class="col-sm-4">
                              <select class="phselect" name="ccode" id="ccode" style="    width: 105px;">
                                @foreach($jsondata as $code)
                                <option data-thumbnail="images/icon-chrome.png" value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                @endforeach
                            </select>
                            </div>
                          <!--   <div class="col-sm-4">
                              <select name="ccode" >
                                @foreach($jsondata as $code)
                                <option value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) { echo "selected='seletected'"; } ?>> {{ $code['dial_code'] }}</option>
                                @endforeach
                            </select>
                            </div> -->
                            <div class="col-sm-8 nopadding">
								<input id="mobile" type="text" class="form-control @error('email') is-invalid @enderror" name="mobile" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile') }}" required autocomplete="off" autofocus>

                            </div>
						</div>
                        
                        

                        
						<div class="forgot-pass text-right padding-bottom-10">
						   @if (Route::has('password.request'))
								<a href="{{ route('password.request') }}" style="color:#d6bb04;">
									{{ __('Forgot Your Password?') }}
								</a>
							@endif  
                            <a href="<?= URL::to('/login')?>" style="color:#d6bb04;"> <?php echo _('Sign In');?></a>
						</div>
						
						<div class="form-group mb-0">
							<button type="submit" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#myModal">
								{{ __('Send OTP') }}
							</button>
						</div>
						
						<div class="form-group nomargin">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

								<label class="form-check-label" for="remember">
									{{ __('Keep me Signed in') }}
								</label>
							</div>
						</div>
                        <div class="line-design margin-bottom-10 footer-section-line1"></div>
						<div class="form-group mb-0 account-group text-center">
							<p>{{ __('New to') }} <?php echo $settings->website_name; ?>? <a style="color: #d6bb04;" href="{{ route('signup') }}">{{ __('Sign Up Now') }}</a> </p>
						</div>						
					<!-- </form> -->
				</div>
			</div>
		</div>
    </div>
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <form method="POST" action="{{ URL::to('/directVerify') }}" class="form-signin">
      <!-- Modal content-->
      @csrf



      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
        	<div class="d-flex justify-content-center align-items-center container">
    <div class="card py-5 px-3">
        <h5 class="m-0">Mobile phone verification</h5><span class="mobile-text">Enter the code we just send on your mobile phone <b class="text-danger"> <input type="hidden" id="mobilecopy" name="mobile"></b></span>
        <div class="d-flex flex-row mt-5">
        	<input type="text" id="activation_code" name="activation_code" class="form-control" autofocus="">
        <!-- 	<input type="text"  class="form-control">
        	<input type="text" class="form-control">
        	<input type="text" class="form-control"> -->
        </div>
        <!-- <div class="text-center mt-5"><span class="d-block mobile-text">Don't receive the code?</span><span class="font-weight-bold text-danger cursor"><button type="submit" data-toggle="modal" data-target="#myModal">
								{{ __('Resend OTP') }}
							</button></span></div>
    </div> -->
</div>
        	  <!-- <input type="hidden" id="mobilecopy" name="mobile">
          <input id="activation_code" name="activation_code"> -->
        </div>
        <div class="modal-footer">
         <button type="submit" class="btn btn-lg btn-primary btn-block">
			{{ __('Verify OTP') }}
		</button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <!-- End Modal -->
</div>
<script>
$('#mobile').change(function() {
    $('#mobilecopy').val($(this).val());
});
</script>
@include('footer')

