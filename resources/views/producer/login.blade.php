@php
    $current_timezone = 'Asia/Kolkata';
    $current_time = Carbon\Carbon::now($current_timezone);
@endphp

<div id="form-login" class="pop">
    <center>
        <form id="form1" class="loginset-form" action="{{ route('producer.verify_login') }}" method="post">
            @csrf
            <input type="hidden" name="type" id="type" value=1>
            <center><h4 class="text-dark mt-3 mb-2">Login</h4></center>

            <div class="container">

                @if ($errors->any())
                    <div id="error-message" class="alert alert-danger" style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="uname"><b>Mobile no</b></label>
                <input type="text" class="login-input-text" placeholder="Enter 10 digit number" name="mobile_number" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" class="login-input-text" placeholder="Enter Password" name="otp" required>

                <button type="submit" id="btn-login">Login</button>

            </div>

            <div class="container text-secondary text-center" style="background-color:#04AA6D">
                <a href="{{ route('producer.signup')}}" type="button" class="cancelbtn btn-primary"> New user? sign up</a>
            </div>
        </form>

        <div class="container text-center">
            <h6 class="text-secondary">Copyright &copy;  {{ $current_time->year }} <br> Runmawi</h6>
        </div>
    </center>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(function () {
                errorMessage.style.display = 'none';
            }, 15000);
        }
    });
</script>

<style>
    #form1 {
        max-width: 500px;
        text-align: left;
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
