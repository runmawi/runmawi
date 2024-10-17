<div id="form-login" class="pop">
	<center>
		<form id="form1" class="loginset-form" action="logincheck.php" method="post">
		<input type="hidden" name="type" id="type" value=1>
		 
			
			<center><h6 class="text-dark mt-3 mb-2">Login</h6></center>
			
		  <div class="container">
			<label for="uname"><b>Mobile no</b></label>
			<input type="text" class="login-input-text" placeholder="Enter 10 digit number" name="userid" required>

			<label for="psw"><b>Password</b></label>
			<input type="password" type="text" class="login-input-text" placeholder="Enter Password" name="password" required>
				
			<button type="submit" id="btn-login">Login</button>
			
			<div class="row text-secondary">
			<div class="col-12">
				<a href="#resetpassword" class="float-right text-warning"></a>
			</div>
		  </div>
		  </div>

		  <div class="container text-secondary text-center" style="background-color:#f1f1f1">
			<a href="#register" type="button" class="cancelbtn btn-primary"></a>
		  </div>
		</form>

		<div class="container text-center">
			<h6 class="text-secondary">Copyright &copy; 2021<br> Runmawi</h6>
		</div>
	</center>
	</div>
	
	
	

<style>
#form1{
	max-width:500px;
	text-align:left;
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

	  
	  