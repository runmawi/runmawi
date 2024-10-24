
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="pop">
    <center>
        <div class="form-wrapper">
            <form class="" action="{{ route('producer.signup_otp') }}" method="get">

                <div class="imgcontainer">
                    <img src="{{ front_end_logo() }}" alt="Avatar" class="avatar">
                </div>

                <h1 class="text-dark"> Register </h4>

                <div id="login-step2" class="container">
                    @if ($errors->any())
                        <div id="error-message" class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="input-group">
                        <label for="username" class="label-name">User Name</label>
                        <input type="text" id="username" class="login-input-text" placeholder="Enter User Name" name="username" required>
                    </div>

                    <div class="input-group">
                        <label for="mobile_number" class="label-name">Mobile Number</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control login-input-text" id="mobile_number" placeholder="Enter mobile number" aria-label="Mobile Number" aria-describedby="basic-addon2" name="mobile_number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
                            <div class="input-group-append ">
                              <button class="btn btn-outline-secondary btn-main" type="submit">Verify Number</button>
                            </div>
                          </div>
                    </div>

                    <div class="input-group">
                        <label for="otp" class="label-name">Enter OTP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control login-input-text" id="otp" placeholder="Enter OTP" aria-label="OTP" aria-describedby="basic-addon2" name="otp" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" required>
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary btn-main" type="submit">Verify OTP</button>
                            </div>
                        </div>
                        <div class="resend-container">
                            <a href="" target="_blank" rel="noopener noreferrer" class="resend-link">Resend OTP</a>
                        </div>
                    </div>  

                    <div class="register-now">
                        <button type="submit" class="btn-main">Register Now </button>
                    </div>

                </div>

                <div class="container text-center existing-user mt-4">Already Existing user?
                    <a href="{{ route('producer.login') }}" class="login" style="color: #0072ff;"> Login now</a>
                </div>

            </form>

            <div class="footer text-center">
                <p>Copyright &copy; 2021 <br>Runmawi</p>
            </div>
        </div>
    </center>
</div>

<style>
    .form-wrapper {
        width: 100%;
        max-width: 600px;
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 50px auto;
    }
    .imgcontainer {
        text-align: center;
        margin-bottom: 50px;
    }

    img.avatar {
        width: 50%;
        height: 75px;
        
    }
    h1 {
        /* font-weight: 600; */
        margin-bottom: 30px;
        letter-spacing: 3px;
    }
    .input-group {
        margin-bottom: 20px;
    }
    .input-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
        font-size: 18px;
        float: left;
    }
    .login-input-text {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-sizing: border-box;
        background-color: #f9f9f9;
        color: #333;
        font-size: 14px;
    }
    .btn-main {
        background-color: #0072ff;
        color: white;
        padding: 12px;
        border: none;
        cursor: pointer;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    .btn-main:hover {
        background-color: #005bb5;
        border-radius: 8px;
    }
    .btn-secondary {
        display: block;
        text-decoration: none;
        padding: 12px;
        margin-top: 10px;
        background-color: #0072ff;
        color: white;
        text-align: center;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #0072ff;
        border-radius: 8px;
    }
    .resend-container {
        text-align: right;
        margin-bottom: 10px;
    }
    .resend-link {
        color: #0072ff;
        text-decoration: none;
        font-size: 14px;
    }
    .footer {
        margin-top: 20px;
    }
    .footer p {
        font-size: 12px;
        color: #666;
    }
</style>