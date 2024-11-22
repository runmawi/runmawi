<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Runmawi | Register</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{  getFavicon() }}" >

        <!-- toastr -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" defer></script>

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
        .refresh-icon {
            filter: invert(0) brightness(0) saturate(70%);
        }
    </style>
</head>
<body>
    <div class="pop">

        @if (session('Regiter_successfully'))
            <script>
                $(document).ready(function () {
                    toastr.options = {"timeOut": "5000","extendedTimeOut": "5000"};
                    toastr.success('{{ session('Regiter_successfully') }}', 'Success Message');
                });
            </script>
        @endif

        <center>
            <div class="form-wrapper">

                <div class="imgcontainer">
                    <img src="{{ front_end_logo() }}" alt="Avatar" class="avatar">
                </div>

                <h1 class="text-dark"> Register </h4>

                <div id="login-step2" class="container">

                    <div class="input-group">
                        <label for="username" class="label-name">User Name</label>
                        <input type="text" id="username" class="login-input-text" placeholder="Enter User Name" name="username" required>
                    </div>

                    <div class="input-group">
                        <label for="mobile_number" class="label-name">Mobile Number</label>

                        <div class="input-group col-md-12 mb-3">
                            <div class="input-group-append col-md-3">
                                <select class="form-control login-input-text mobile_validation" name="ccode" id="ccode" >
                                <option>{{ __('Select Country') }}</option>
                                    @foreach($jsondata as $code)
                                        <option value="{{  $code['dial_code'] }}" {{ $code['name'] == "India" ? 'selected' : ''}}>{{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5" style="padding-left: 10px;">
                                <input type="text" id="mobile" class="form-control login-input-text mobile_validation" id="mobile_number" placeholder="Enter mobile number" aria-label="Mobile Number" aria-describedby="basic-addon2" name="mobile_number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
                            </div>

                            <div class="input-group-append col-md-3" style="padding-left: 9px;">
                                <input type="button" id="send_otp_button" class="btn btn-outline-secondary btn-main send_otp_button" value="Send OTP" >
                            </div>

                            <div class="col-md-1 p-2">  {{-- Refresh--}}
                                <a data-toggle="tooltip" title="Refresh Mobile No" href="{{ route('producer.signup') }}"> <img src="{{ URL::to('public/img/refresh.svg') }}" alt="refresh-icon" class="refresh-icon"></a>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <span style="color: var(--iq-white); font-size: 14px;" class="mob_exist_status"></span>
                        </div>
                    </div>

                    <div class="input-group otp_div">
                        <label for="otp" class="label-name">Enter OTP</label>

                        <div class="input-group col-md-12 mb-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control login-input-text" id="otp" placeholder="Enter OTP" aria-label="OTP" aria-describedby="basic-addon2" name="otp" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" required>
                            </div>

                            <div class="col-md-4" style="padding-left: 16px;">
                                <div class="input-group-append">
                                    <input type="button"  id="verify-button" class="btn btn-outline-secondary btn-main verify-button" value="Verify & Register"> <br>
                                    <a href="#" target="_blank" rel="noopener noreferrer" id="resend_otp_button" class="resend-link resend_otp_button">Resend OTP</a>
                                </div>
                            </div>
                        </div>

                        <p class="otp_send_message m-0 p-0" > </p>
                    </div>  
                </div>
                
                <div class="container text-center existing-user mt-4">Already Existing user?
                    <a href="{{ route('producer.login') }}" class="login" style="color: #0072ff;"> Login now</a>
                </div>

                <div class="footer text-center"><p>Copyright &copy;  {{ $current_time->year }} <br>Runmawi</p></div>
            </div>
        </center>
    </div>

    <script>
        $(document).ready(function(){

            $('#send_otp_button').prop('disabled', true);
            $('.otp_div').hide();

            $(".mobile_validation").on("input", function() {

                let mobileNumber = $('#mobile').val();
                let mobileNumber_count = mobileNumber.length;
                let ccode = $('#ccode').val();

                $('.mob_exist_status').text("");

                if( mobileNumber !== "" && mobileNumber_count > 9 ){

                    $.ajax({
                        url: "{{ route('producer.Signup_check_mobile_exist') }}",
                        type: "get",
                        data: {
                            mobile_number: mobileNumber,
                            ccode: ccode,
                        },
                        dataType: "json",

                        success: function(response) {
                            if (response.exists) {
                                document.getElementById("send_otp_button").removeAttribute("disabled");
                                $('.mob_exist_status').text("Valid Mobile number, verify Number via OTP to register!").css('color', 'green');;

                            } else {
                                document.getElementById("send_otp_button").setAttribute("disabled", "disabled");
                                $('.mob_exist_status').text("Mobile Number Already exists!").css('color', 'red');
                            }
                        },
                        error: function(error) {
                            console.error('AJAX error:', error);
                            $('.mob_exist_status').text("Mobile Number not exists!").css('color', 'red');
                        }
                    });
                }
            });

            $(document).on('click', '#send_otp_button, #resend_otp_button', function (event) {
            
                event.preventDefault();

                $('#mobile').attr('readonly', true);
                $('#ccode').attr('disabled', true);

                $('.otp_send_message').text("");

                let mobileNumber = $('#mobile').val();
                let ccode = $('#ccode').val();
                $('.mob_exist_status').text("");

                $.ajax({
                    url: "{{ route('producer.otp.signup-sending-otp') }}",
                    type: "get",
                    data: {
                            mobile_number: mobileNumber,
                            ccode: ccode
                        },
                    dataType: "json",

                    success: function(response) {
                        if (response.exists) {
                            $("#send_otp_button").hide();
                            $('.mob_exist_status').text( response.message_note ).css('color', 'green');
                            $('.otp_div').show();
                        } else {
                            $('.mob_exist_status').text( response.message_note ).css('color', 'red');
                        }
                    },
                    error: function(error) {
                        console.error('AJAX error:', error);
                    }
                });
            });

            $(document).on('click', '#verify-button', function () {

                let username = $('#username').val();
                let mobileNumber = $('#mobile').val();
                let ccode = $('#ccode').val();
                let otp = $('#otp').val();

                $('.otp_send_message,.mob_exist_status').text("");

                let validationPassed = true;

                if (!otp) {
                    $('.otp_send_message').text('OTP is required').css('color', 'red');
                    validationPassed = false;
                }

                if (!username) {
                    $('.otp_send_message').text('Username is required').css('color', 'red');
                    validationPassed = false;
                }

                if (validationPassed) {

                    $.ajax({
                        url: "{{ route('producer.otp.signup_otp_verification') }}",
                        type: "GET",
                        data: {
                            username:username,
                            mobileNumber: mobileNumber,
                            ccode:ccode,
                            otp: otp,
                        },
                        dataType: "JSON",
                        
                        success: function(response) {
                            if (response.status === true) {
                                $('.otp_send_message').text(response.message_note).css('color', 'green');
                                $('#verify-button').prop('disabled', true);
                                $('#resend_otp_button').hide();
                                location.reload();

                            } else if (response.status === false) {
                                
                                $('.otp_send_message').text(response.message_note).css('color', 'red');
                                $('#verify-button').prop('disabled', false);
                                $('#resend_otp_button').show();

                            }
                        },
                        error: function() {
                            $('.otp_send_message').text("An error occurred. Please try again.").css('color', 'red');
                            $('#verify-button').prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>