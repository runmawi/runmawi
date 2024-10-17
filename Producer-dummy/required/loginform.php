<?php
	$sql  ="select content from custom_page where pageid='termsofuse'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$termsofuse = $row[0];
?>
<div id="form-login" class="pop">
	<center>
		<div class="form-wrapper">
			<form id="form1" class="loginset-form" action="actions/login_actions.php" method="post">
			  <div class="imgcontainer">
				<img src="assets/images/logo-icon.png" alt="Avatar" class="avatar" style="width:46px; height:46px">
			  </div>
				<center><h6 class="text-dark mt-3 mb-2">Login</h6></center>
				
			  <div id="login-step1" class="container">
				<input type="hidden" name="type" id="type" value=10>
				<label for="uname"><b>Mobile no/Email</b></label>
				<input type="text" id="userid" class="login-input-text" placeholder="" name="userid" required>
				<button type="submit" id="btn-getotp">Get OTP</button>
				
				<div class="text-end">
					<small>I mobile number emaw email i chhut hnuah <b>Get OTP</b> ah hian khawih tur. SMS ah OTP i dawng ang a, OTP chhutna tur a lang ang.
					</small>
					<br>I vawikhat hmanna a nih chuan, a hnuaia <b>Regster now</b> ah hian in register phawt tur.
				</div>
					
			  </div>
			  <div class="container text-secondary text-center" style="background-color:#f1f1f1">
				<a href="#register" type="button" class="cancelbtn btn-primary">Register now</a>
			  </div>
			</form>

			<div class="container text-center">
				<h6 class="text-secondary">Copyright &copy; 2021<br> Runmawi</h6>
			</div>
		</div>
	</center>
</div>

<div id="form-login2" class="pop">
	<center>
		<div class="form-wrapper">
			<form id="form11" class="loginset-form" action="actions/login_actions.php" method="post">
			  <div class="imgcontainer">
				<img src="assets/images/logo-icon.png" alt="Avatar" class="avatar" style="width:46px; height:46px">
			  </div>
				<center><h6 class="text-dark mt-3 mb-2">Login</h6></center>
				
			  <div id="login-step2"  class="container">
					<input type="hidden" name="type" id="type" value=11>
					<label for="uname1"><b>Mobile no/Email</b></label>
					<input type="text" id="userid2" class="login-input-text" placeholder="Enter 10 digit number" name="userid" readonly required>

					<label for="otp"><b>OTP</b></label>
					<input type="text" class="login-input-text" placeholder="Enter OTP" id="password" name="password" required>
						
					<div class="text-end">
						<a style="display:none; float:right" class='text-dark' id='btn-resend' onclick="$('#btn-getotp').click()">Resend OTP</a>
						<span id='resend-msg'>Second <b><span id='resend-timer'>0</span></b> chhungin SMS i dawn loh chuan OTP thar request na button tah hian a lang ang.</span>
					</div>
					<button type="submit" id="btn-login">Login</button>
				</div>
				
				<div class="container text-end">
					<a  class='text-dark'  onclick="clearInterval(timer); $('#form-login').show(); $('#form-login2').hide();"><i class='fa fa-arrow-left'></i> Edit phone number/email</a>
				</div>
				
			  <div class="container text-secondary text-center" style="background-color:#f1f1f1">
				<a href="#register" type="button" class="cancelbtn btn-primary">New user? Register now</a>
			  </div>
			</form>

			<div class="container text-center">
				<h6 class="text-secondary">Copyright &copy; 2021<br> Runmawi</h6>
			</div>
		</div>
	</center>
</div>
	

	<style>
	.form-wrapper{
		width:100%;
		max-width:500px;
	}
#form-login{
		position:fixed;
		top:0px;
		bottom:0px;
		left:0px;
		right:0px;
		background-color:#f3f3f3;
		z-index:100001;
		overflow:auto;
		padding:12px;
}

#form-login2{
		position:fixed;
		top:0px;
		bottom:0px;
		left:0px;
		right:0px;
		background-color:#f3f3f3;
		z-index:100001;
		overflow:auto;
		padding:12px;
		display:none;
}
#form-register{
		position:fixed;
		top:0px;
		bottom:0px;
		left:0px;
		right:0px;
		background-color:#f3f3f3;
		z-index:100001;
		overflow:auto;
		display:none;
		padding:12px;
		
}


.login-input-text {
  width: 100%;
  margin: 8px 0; 
  border: 1px solid #eeeeee !important;
  box-sizing: border-box !important;
  background-color:white !important; 
  color:#666666 !important;
  height:40px !important;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 8px 12px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}


.cancelbtn {
  padding: 6px 10px;
  color:#ffffff;
  background-color:#0000cc
  text-align:center;
  margin-top:5px;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}


/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}

/***** Slide Up *****/
.slide-up {
  animation: 0.3s slide-up;
}
@keyframes slide-up {
  from {
    margin-top: 100%;
  }
  to {
    margin-bottom: 0%;
  }
}

/***** Slide Down *****/
.slide-down {
  animation: 0.3s slide-down;
}
@keyframes slide-down {
  from {
    margin-bottom: 100%;
  }
  to {
    margin-to: 0%;
  }
}

/***** Pop *****/
.pop{
	animation: pop 0.2s linear 1;
}
@keyframes pop{
  10%  {transform: scale(1.1);}
}

</style>

<script>


$(function() {
    $('.loginset-form').submit(function (event){
        event.preventDefault();
        var form = $(event.target); 
		var formData = form.serialize();
        var url = form.attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
			timeout: 10000,
			beforeSend: function(){
				//Loading(1);
				$("#btn-getotp").text("Requesting OTP..");
				$("#btn-login").text("Please wait..");
				$("#btn-register").text("Registering..");
				
				$("#btn-getotp").attr("disabled", "disabled");
				$("#btn-login").attr("disabled", "disabled");
				$("#btn-register").attr("disabled", true);
				
				$("#btn-resend").hide();
				$("#resend-msg").show();
			},
            success: function (data) {
				/*
					data is in JSON format;
					status = 1: login successful
					status = 2: register successful
				*/
				const obj = JSON.parse(data); 
				status = obj.status;

				$("#password").val("");
				if(status == 1){
					//login successful
					setAccountInfo(obj.username, obj.phone, obj.email);
					location.href="#home";
					$("#form-login").hide();
					$("#form-login2").hide();
					//$("#form1").trigger("reset");
				}
				else if(status == 101){
					//OTP sent successfully
					ShowToast("A 4-digit OTP has been sent to you..");
					$("#form-login").hide();
					$("#form-login2").show();
					$('#userid2').val($("#userid").val());
					
					var time = 60; //60 seconds
					timer = setInterval(function(){
						time = time-1;
						$("#resend-timer").text(time);
						if(time == 0){
							$("#btn-resend").show();
							$("#resend-msg").hide();
							clearInterval(timer);
						}
					}, 1000);
				}	
				else if(status == 2){
					ShowToast("Registered successfully. Login to continue.");
					location.href="#login";
					$("#form2").trigger("reset");
					$("#form-login2").hide();
					$("#form-login").show();
				}
				else{
					if(status == 10) ShowToast("Please check your OTP."); //ok
					else if(status == 11) ShowToast("Enter registered email or mobile number."); //ok
					else if(status == 12) ShowToast("The account you try to access is blocked.");
					else if(status == 21) ShowToast("Error registration. Please try again.");
					else if(status == 22) ShowToast("Your mobile number is already registered.");
					else if(status == 23) ShowToast("your email is already registered.");
					else ShowToast("Please check your input and try again.");
				}
					
				//Loading(0);
				$("#btn-getotp").text("Get OTP");
				$("#btn-login").text("Login");
				$("#btn-register").text("Register");
				
				$("#btn-getotp").attr("disabled", false);
				$("#btn-login").attr("disabled", false);
				$("#btn-register").attr("disabled", false);	
            },
			
            error: function (e) {
                ShowToast("Cannot reach server.. Please try again. ");
				//Loading(0);
				$("#btn-getotp").text("Get OTP");
				$("#btn-login").text("Login");
				$("#btn-register").text("Register");
				
				$("#btn-getotp").attr("disabled", false);
				$("#btn-login").attr("disabled", false);
				$("#btn-register").attr("disabled", false);
            }
        });
    });
});

function setAccountInfo(username, phone, email){
	$("#username").text(username);
	$("#phone").text(phone);
	$("#email").text(email);
}
</script>

	  
	  