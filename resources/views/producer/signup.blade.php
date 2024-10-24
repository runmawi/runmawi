<div class="pop">
    <center>
        <div class="form-wrapper">
            <form class="" action="{{ route('producer.signup_otp') }}" method="get">

                <div class="imgcontainer">
                    <img src="{{ front_end_logo() }}" alt="Avatar" class="avatar" style="width:46px; height:46px">
                </div>

                <center> <h4 class="text-dark mt-3 mb-2"> Register </h4> </center>

                <div id="login-step2" class="container">

                    @if ($errors->any())
                        <div id="error-message" class="alert alert-danger" style="color: red;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <label><b> {{ __('User Name') }} </b></label>
                    <input type="text" class="login-input-text" placeholder="Enter the User Name" name="username" required>

                    <label><b> {{ __('Mobile no') }} </b></label>
                    <input type="text" class="login-input-text" placeholder="Enter 10 digit number" name="mobile_number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>

                    <button type="submit" id="btn-login">Verify Mobile Number</button>

                    <label><b> {{ __('Enter OTP') }} </b></label>
                    <input type="text" class="login-input-text" placeholder="Enter OTP" name="mobile_number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" required>
                    <a href="" target="_blank" rel="noopener noreferrer">Resend OTP</a>  

                    <button type="submit" id="btn-login">Verify OTP</button>

                    <div class="text-end">
                        <a style="display:none; float:right" class='text-dark' id='btn-resend' onclick="$('#btn-getotp').click()">Resend OTP</a>
                    </div>

                    <button type="submit" id="btn-login">Register Now </button>

                </div>

                <div class="container text-end">
                </div>

                <div class="container text-secondary text-center" style="background-color:#04AA6D">
                    <a href="{{ route('producer.login') }}" type="button" class="cancelbtn btn-primary">Already Existing user? Login now</a>
                </div>
            </form>

            <div class="container text-center">
                <h6 class="text-secondary">Copyright &copy; 2021<br> Runmawi</h6>
            </div>
        </div>
    </center>
</div>

<style>
    .form-wrapper {
        width: 100%;
        max-width: 500px;
    }

    #form-login {
        position: fixed;
        top: 0px;
        bottom: 0px;
        left: 0px;
        right: 0px;
        background-color: #f3f3f3;
        z-index: 100001;
        overflow: auto;
        padding: 12px;
    }

    #form-login2 {
        position: fixed;
        top: 0px;
        bottom: 0px;
        left: 0px;
        right: 0px;
        background-color: #f3f3f3;
        z-index: 100001;
        overflow: auto;
        padding: 12px;
        display: none;
    }

    #form-register {
        position: fixed;
        top: 0px;
        bottom: 0px;
        left: 0px;
        right: 0px;
        background-color: #f3f3f3;
        z-index: 100001;
        overflow: auto;
        display: none;
        padding: 12px;

    }


    .login-input-text {
        width: 100%;
        margin: 8px 0;
        border: 1px solid #eeeeee !important;
        box-sizing: border-box !important;
        background-color: white !important;
        color: #666666 !important;
        height: 40px !important;
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
        color: #ffffff;
        background-color: #0000cc text-align:center;
        margin-top: 5px;
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
    .pop {
        animation: pop 0.2s linear 1;
    }

    @keyframes pop {
        10% {
            transform: scale(1.1);
        }
    }
</style>