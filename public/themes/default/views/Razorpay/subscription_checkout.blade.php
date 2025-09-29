@php  include(public_path('themes/default/views/header.php')); @endphp

<button id="rzp-button1" hidden>{{ __('Pay')  }}</button>  
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="col-lg-12  h-100">
    <div class="d-flex justify-content-center">
        <img src="{{ URL::to('/public/Thumbnai_images/checkout-processing.gif')}}" alt="" srcset="" class="w-100">
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<!-- ✅ Custom Alert Styles -->
<style>
    #custom-alert-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
    }

    .custom-alert {
        background: #fff;
        padding: 40px 30px;
        border-radius: 10px;
        text-align: center;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.3s ease-in-out;
    }

    .custom-alert.success {
        border-left: 5px solid #28a745;
    }

    .custom-alert.error {
        border-left: 5px solid #dc3545;
    }

    .custom-alert h2 {
        margin-bottom: 15px;
        font-size: 24px;
    }

    .custom-alert p {
        font-size: 16px;
        margin-bottom: 10px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    #custom-alter-title{
        color: #616061 !important;

    }
    #custom-alter-para{
        color: #4a494a !important;
    }
</style>

<!-- ✅ Container to hold alert -->
<div id="custom-alert-container" style="display: none;"></div>

<!-- ✅ Razorpay Script -->
<script>
    function showCustomAlert(type, title, message, redirectUrl) {
        const container = document.getElementById("custom-alert-container");

        container.innerHTML = `
            <div class="custom-alert ${type}">
                <h2 id="custom-alert-title">${title}</h2>
                <p id="custom-alert-message">${message}</p>
                <p>Redirecting in 5 seconds...</p>
            </div>
        `;

        container.style.display = "flex";

        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 5000);
    }

    const rzpOptions = {
        key: "{{ $rzp_key }}",
        subscription_id: "{{ $subscription_id }}",
        name: "Runmawi",
        description: "Monthly Subscription",
        prefill: {
            name: "{{ auth()->check() ? auth()->user()->name : '' }}",
            email: "{{ auth()->check() ? auth()->user()->email : '' }}",
            contact: "{{ auth()->check() ? auth()->user()->mobile ?? '' : '' }}"
        },
        theme: {
            color: "#F37254"
        },
        handler: function (response) {
            console.log("✅ Payment successful:", response);

            const data = {
                subscription_id: "{{ $subscription_id }}",
                payment_id: response.razorpay_payment_id,
                _token: "{{ csrf_token() }}"
            };

            fetch("{{ route('razorpay.checkStatus') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": data._token
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    showCustomAlert("success", "Payment Successful", res.message, "{{ url('/') }}");
                } else {
                    showCustomAlert("error", "Payment Error", res.message, "{{ url('/') }}");
                }
            })
            .catch(error => {
                console.error("❌ Error verifying payment:", error);
                showCustomAlert("error", "Server Error", "Something went wrong. Please contact support.", "{{ url('/') }}");
            });
        },
        modal: {
            ondismiss: function () {
                console.log("❌ Payment popup dismissed");
                showCustomAlert(
                    "error",
                    "Payment Cancelled",
                    "You closed the payment window before completing the process.",
                    "{{ url('/') }}"
                );
            }
        }
    };

    window.onload = function () {
        const rzp = new Razorpay(rzpOptions);
        rzp.open();
    };
</script>


@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp