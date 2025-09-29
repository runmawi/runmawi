@extends('layouts.app')

@php
    include public_path('themes/default/views/header.php');
    
    $PayPalpayment = App\PaymentSetting::where('payment_type', 'PayPal')->where('status', 1)->first();
    $PayPalmode = !is_null($PayPalpayment) ? $PayPalpayment->paypal_live_mode : null;
    
    $paypalClientId = null;
    if (!is_null($PayPalpayment)) {
        switch ($PayPalpayment->paypal_live_mode) {
            case 0:
                $paypalClientId = $PayPalpayment->test_paypal_signature;
                break;
            case 1:
                $paypalClientId = $PayPalpayment->live_paypal_signature;
                break;
        }
    }
@endphp

@section('content')

@if($paypalClientId)
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
@endif

<style>
:root {
    --primary-color: #8a0303;
    --primary-hover: #7c1414;
    --secondary-color: #4895d1;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --dark-color: #343a40;
    --light-color: #f8f9fa;
    --border-radius: 12px;
    --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
}

* {
    box-sizing: border-box;
    color: white;
}

.payment-container {
    min-height: 100vh;
    padding: 2rem 0;
}

.payment-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    max-width: 1000px;
    margin: 0 auto;
}

.payment-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    padding: 2rem;
    text-align: center;
}

.back-btn {
    position: absolute;
    top: 5rem;
    left: 1rem;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: var(--transition);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-3px);
}

.step-indicator {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.welcome-text {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    opacity: 0.95;
}

.main-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.payment-body {
    padding: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--light-color);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title::before {
    content: '';
    width: 4px;
    height: 24px;
    background: var(--primary-color);
    border-radius: 2px;
}

/* Payment Methods */
.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.payment-method {
    position: relative;
    border: 2px solid #e9ecef;
    border-radius: var(--border-radius);
    padding: 1rem;
    cursor: pointer;
    transition: var(--transition);
    background: white;
}

.payment-method:hover {
    border-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
}

.payment-method.selected {
    border-color: var(--primary-color);
    background: rgba(138, 3, 3, 0.05);
}

.payment-method input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.payment-method-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    color: var(--dark-color);
}

.payment-method-icon {
    width: 32px;
    height: 32px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

/* Plans Grid */
.plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* Enhanced Plan Card Selection Styles - Replace the existing plan-card styles with these */

.plan-card {
    border: 2px solid #e9ecef;
    border-radius: var(--border-radius);
    overflow: hidden;
    cursor: pointer;
    transition: var(--transition);
    background: white;
    position: relative;
}

.plan-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
    box-shadow: var(--box-shadow);
}

.plan-card.selected {
    border-color: var(--primary-color);
    border-width: 3px;
    box-shadow: 0 0 0 3px rgba(138, 3, 3, 0.15);
    background: linear-gradient(135deg, rgba(138, 3, 3, 0.05), rgba(138, 3, 3, 0.02));
    transform: translateY(-5px);
}

/* Add a selected indicator badge */
.plan-card.selected::before {
    content: '✓';
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--primary-color);
    color: white;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
    z-index: 2;
    box-shadow: 0 2px 10px rgba(138, 3, 3, 0.3);
}

/* Enhanced plan header for selected state */
.plan-card.selected .plan-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
}

/* Make the plan name more prominent when selected */
.plan-card.selected .plan-name {
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Add a subtle glow effect for selected cards */
.plan-card.selected {
    animation: selectedGlow 2s ease-in-out infinite alternate;
}

@keyframes selectedGlow {
    from {
        box-shadow: 0 0 0 3px rgba(138, 3, 3, 0.15), 0 4px 20px rgba(138, 3, 3, 0.1);
    }
    to {
        box-shadow: 0 0 0 3px rgba(138, 3, 3, 0.25), 0 6px 25px rgba(138, 3, 3, 0.2);
    }
}

/* Dark theme support for selected cards */
body.dark-theme .plan-card.selected {
    background: linear-gradient(135deg, rgba(138, 3, 3, 0.15), rgba(138, 3, 3, 0.05));
    border-color: var(--primary-color);
}

body.dark-theme .plan-card.selected .plan-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
}

.plan-header {
    background: linear-gradient(135deg, var(--dark-color), #495057);
    color: white;
    padding: 1.5rem;
    text-align: center;
}

.plan-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.plan-price {
    font-size: 2.5rem;
    opacity: 0.9;
    margin-bottom: 0.25rem;
    background-color: #ffffff02 !important;
    border-radius: 5px;
    font-weight: bold;
    color: #22bb33;
}

.plan-duration {
    font-size: 0.9rem;
    opacity: 0.8;
}

.plan-features {
    padding: 1.5rem;
}

.plan-features p {
    margin: 0;
    color: #6c757d;
    line-height: 1.6;
}

/* Summary Section */
.summary-card {
    background: #f8f9fa;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin: 2rem 0;
    border-left: 4px solid var(--primary-color);
}

.summary-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--dark-color);
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #dee2e6;
}

.summary-item:last-child {
    border-bottom: none;
    font-weight: 600;
    font-size: 1.1rem;
}

.summary-label {
    color: var(--light-color);
}

.summary-value {
    font-weight: 500;
    color: var(--success-color);
}

/* Payment Buttons */
.payment-actions {
    margin-top: 2rem;
}

.payment-btn {
    width: 100%;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    margin-bottom: 1rem;
}

.payment-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(138, 3, 3, 0.3);
}

.payment-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.secondary-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary-color);
    background-color: var(--secondary-color);
    text-decoration: none;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.secondary-btn:hover {
    background: rgba(72, 149, 209, 0.1);
    text-decoration: none;
    color: var(--secondary-color);
}

/* PayPal Container */
#paypal-button-container {
    margin-top: 1rem;
}

/* Loading States */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Form Inputs */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark-color);
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(138, 3, 3, 0.1);
}

/* Payment Pending Modal Styles */
.payment-pending-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    animation: fadeInModal 0.3s ease-out;
}

.payment-pending-content {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    max-width: 520px;
    width: 90%;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
    text-align: center;
    position: relative;
    animation: slideInModal 0.4s ease-out;
}

.payment-pending-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2.5rem;
    animation: pendingPulse 2s infinite ease-in-out;
}

.payment-pending-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #343a40;
    margin-bottom: 1.5rem;
}

.payment-pending-message {
    color: #6c757d;
    line-height: 1.7;
    margin-bottom: 2rem;
    font-size: 1.05rem;
}

.payment-pending-highlight {
    background: #898989;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 1.2rem;
    margin: 1.5rem 0;
    border-left: 4px solid #ff6b35;
}

.payment-pending-highlight strong {
    color: #8a0303;
    display: block;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.home-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    text-decoration: none;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: var(--border-radius);
    transition: var(--transition);
    font-size: 1.1rem;
    border: none;
    cursor: pointer;
}

.home-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(138, 3, 3, 0.3);
    text-decoration: none;
    color: white;
}

.payment-disabled-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(138, 3, 3, 0.1);
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--border-radius);
}

.payment-disabled-message {
    background: rgba(138, 3, 3, 0.9);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Animations */
@keyframes fadeInModal {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInModal {
    from { 
        opacity: 0; 
        transform: translateY(30px) scale(0.9); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
}

@keyframes pendingPulse {
    0%, 100% { 
        transform: scale(1); 
        box-shadow: 0 0 0 0 rgba(255, 107, 53, 0.4);
    }
    50% { 
        transform: scale(1.05); 
        box-shadow: 0 0 0 10px rgba(255, 107, 53, 0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .payment-container {
        padding: 1rem;
    }
    
    .payment-body {
        padding: 1.5rem;
    }
    
    .main-title {
        font-size: 1.5rem;
    }
    
    .plans-grid {
        grid-template-columns: 1fr;
    }
    
    .payment-methods {
        grid-template-columns: 1fr;
    }
    
    .payment-pending-content {
        padding: 2rem;
        margin: 1rem;
    }
    
    .payment-pending-title {
        font-size: 1.5rem;
    }
}

/* Dark Theme Support */
body.dark-theme .payment-card {
    background: #2c3e50;
    color: #ecf0f1;
}

body.dark-theme .plan-card,
body.dark-theme .payment-method {
    background: #34495e;
    border-color: #4a6741;
}

body.dark-theme .summary-card {
    background: #34495e;
}

body.dark-theme .form-control {
    background: #34495e;
    border-color: #4a6741;
    color: #ecf0f1;
}

body.dark-theme .payment-pending-content {
    background: #2c3e50;
    color: #ecf0f1;
}

body.dark-theme .payment-pending-title {
    color: #ecf0f1;
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.slide-up {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from { transform: translateY(10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

@php
    $SubscriptionPlan = App\SubscriptionPlan::first();
    $signup_payment_content = App\SiteTheme::pluck('signup_payment_content')->first();
    $signup_step2_title = App\SiteTheme::pluck('signup_step2_title')->first();
    
    // Payment Settings
    $Stripe_payment_settings = App\PaymentSetting::where('payment_type', 'Stripe')->first();
    $PayPal_payment_settings = App\PaymentSetting::where('payment_type', 'PayPal')->first();
    $Paystack_payment_settings = App\PaymentSetting::where('payment_type', 'Paystack')->first();
    $Razorpay_payment_settings = App\PaymentSetting::where('payment_type', 'Razorpay')->first();
    $CinetPay_payment_settings = App\PaymentSetting::where('payment_type', 'CinetPay')->first();
    $Paydunya_payment_settings = App\PaymentSetting::where('payment_type','Paydunya')->first();
    $recurly_payment_settings = App\PaymentSetting::where('payment_type','Recurly')->where('recurly_status',1)->first();
    
    // Payment Labels
    $stripe_label = App\PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() ?: 'Stripe';
    $paypal_label = App\PaymentSetting::where('payment_type', 'PayPal')->pluck('paypal_lable')->first() ?: 'PayPal';
    $paystack_label = App\PaymentSetting::where('payment_type', 'Paystack')->pluck('paystack_lable')->first() ?: 'PayStack';
    $Razorpay_label = App\PaymentSetting::where('payment_type', 'Razorpay')->pluck('Razorpay_lable')->first() ?: 'Razorpay';
    $CinetPay_lable = App\PaymentSetting::where('payment_type', 'CinetPay')->pluck('CinetPay_Lable')->first() ?: 'CinetPay';
    $Paydunya_label = App\PaymentSetting::where('payment_type','Paydunya')->pluck('paydunya_label')->first() ?: 'Paydunya';
    $recurly_label = App\PaymentSetting::where('payment_type','Recurly')->pluck('recurly_label')->first() ?: 'Recurly';
    
    $CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first();
@endphp

<!-- Payment Pending Modal -->
@if($payment_pending)
<div class="payment-pending-modal" id="paymentPendingModal">
    <div class="payment-pending-content">
        <div class="payment-pending-icon">
            ⏳
        </div>
        
        <h3 class="payment-pending-title">Payment In Progress</h3>
        
        <div class="payment-pending-message">
            A payment has already been initiated for your account. Please wait for the current transaction to complete before trying again.
        </div>
        
        <div class="payment-pending-highlight" >
            <strong>If your last payment was successful:</strong>
            <p>Please wait a couple of minutes for the system to update your subscription status.</p>
            
            <br><br>
            <strong>If you need to try again:</strong>
            <p>Please wait at least 5 minutes before attempting another payment.</p>
        </div>
        
        <button class="home-btn" onclick="window.location.href='{{ URL::to('/home') }}'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9,22 9,12 15,12 15,22"></polyline>
            </svg>
            Go to Home
        </button>
    </div>
</div>
@endif

<div class="payment-container">
    <div class="payment-card fade-in" @if($payment_pending) style="position: relative;" @endif>
        @if($payment_pending)
        <div class="payment-disabled-overlay">
            <div class="payment-disabled-message">
                Payment Pending - Please Wait
            </div>
        </div>
        @endif
        
        <!-- Header Section -->
        <div class="payment-header">
            <button class="back-btn" onclick="history.back()" aria-label="Go back" @if($payment_pending) disabled @endif>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15,18 9,12 15,6"></polyline>
                </svg>
            </button>
            
            <div class="welcome-text">Welcome {{ Auth::user()->username ?? 'User' }}</div>
            <h1 class="main-title">{{ $signup_step2_title ?? 'Choose Your Payment Method' }}</h1>
        </div>

        <!-- Body Section -->
        <div class="payment-body">
            <!-- Payment Methods -->
            <div class="section-title">
                💳 Select Payment Methods
            </div>
            
            <div class="payment-methods">
                @if (!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                <div class="payment-method" data-payment="stripe" @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    <input type="radio" id="stripe_radio" name="payment_gateway" value="stripe" @if($payment_pending) disabled @endif>
                    <label class="payment-method-label" for="stripe_radio">
                        <div class="payment-method-icon">💳</div>
                        <span>{{ $stripe_label }}</span>
                    </label>
                </div>
                @endif

                @if (!empty($PayPal_payment_settings) && $PayPal_payment_settings->paypal_status == 1)
                <div class="payment-method" data-payment="paypal" @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    <input type="radio" id="paypal_radio" name="payment_gateway" value="paypal" @if($payment_pending) disabled @endif>
                    <label class="payment-method-label" for="paypal_radio">
                        <div class="payment-method-icon">🅿️</div>
                        <span>{{ $paypal_label }}</span>
                    </label>
                </div>
                @endif

                @if (!empty($Razorpay_payment_settings) && $Razorpay_payment_settings->status == 1)
                <div class="payment-method" data-payment="razorpay" @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    <input type="radio" id="razorpay_radio" name="payment_gateway" value="Razorpay" @if($payment_pending) disabled @endif>
                    <label class="payment-method-label" for="razorpay_radio">
                        <div class="payment-method-icon">💰</div>
                        <span>{{ $Razorpay_label }}</span>
                    </label>
                </div>
                @endif

                @if (!empty($Paystack_payment_settings) && $Paystack_payment_settings->status == 1)
                <div class="payment-method" data-payment="paystack" @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    <input type="radio" id="paystack_radio" name="payment_gateway" value="paystack" @if($payment_pending) disabled @endif>
                    <label class="payment-method-label" for="paystack_radio">
                        <div class="payment-method-icon">🏦</div>
                        <span>{{ $paystack_label }}</span>
                    </label>
                </div>
                @endif

                @if (!empty($CinetPay_payment_settings) && $CinetPay_payment_settings->CinetPay_Status == 1)
                <div class="payment-method" data-payment="cinetpay" @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    <input type="radio" id="cinetpay_radio" name="payment_gateway" value="CinetPay" @if($payment_pending) disabled @endif>
                    <label class="payment-method-label" for="cinetpay_radio">
                        <div class="payment-method-icon">🏪</div>
                        <span>{{ $CinetPay_lable }}</span>
                    </label>
                </div>
                @endif

                @if (!empty($Paydunya_payment_settings) && $Paydunya_payment_settings->paydunya_status == 1)
                <div class="payment-method" data-payment="paydunya" @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    <input type="radio" id="paydunya_radio" name="payment_gateway" value="Paydunya" @if($payment_pending) disabled @endif>
                    <label class="payment-method-label" for="paydunya_radio">
                        <div class="payment-method-icon">💸</div>
                        <span>{{ $Paydunya_label }}</span>
                    </label>
                </div>
                @endif

                @if (!empty($recurly_payment_settings) && $recurly_payment_settings->recurly_status == 1)
                <div class="payment-method" data-payment="recurly" @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    <input type="radio" id="recurly_radio" name="payment_gateway" value="Recurly" @if($payment_pending) disabled @endif>
                    <label class="payment-method-label" for="recurly_radio">
                        <div class="payment-method-icon">🔄</div>
                        <span>{{ $recurly_label }}</span>
                    </label>
                </div>
                @endif
            </div>

            <!-- Subscription Plans -->
            <div class="section-title">
                📋 Choose Your Plan
            </div>
            
            <div class="plans-grid data-plans">
                @foreach ($plans_data_signup_checkout as $key => $plan)
                <div class="plan-card" 
                     data-plan-id="{{ $plan->id }}" 
                     data-plan-price="{{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : currency_symbol() . round($plan->price, 2) }}"
                     data-plan_id="{{ $plan->plan_id }}" 
                     data-pay-type="{{ $plan->type }}" 
                     data-payment-type="{{ $plan->payment_type }}"
                     @if($payment_pending) style="pointer-events: none; opacity: 0.5;" @endif>
                    
                    <div class="plan-header">
                        <h3 class="plan-name">{{ $plan->plans_name }}</h3>
                        <div class="plan-price">
                            {{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : currency_symbol() . round($plan->price, 2) }}
                        </div>
                        <div class="plan-duration">{{ $plan->days }} Days Membership</div>
                    </div>
                    
                    <div class="plan-features">
                        <p>{!! html_entity_decode($plan->plan_content) !!}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="summary-card slide-up" id="payment_summary">
                <h3 class="summary-title">Order Summary</h3>
                
                <div class="summary-item">
                    <span class="summary-label">Plan:</span>
                    <span class="summary-value" id="selected_plan_name">Select a plan</span>
                </div>
                
                <div class="summary-item">
                    <span class="summary-label">Payment Method:</span>
                    <span class="summary-value" id="selected_payment_method">Select payment method</span>
                </div>
                
                <div class="summary-item">
                    <span class="summary-label">Total Due Today:</span>
                    <span class="summary-value plan_price">
                        Select a plan
                    </span> 
                </div>
                
                @if($signup_payment_content)
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #dee2e6;">
                    <small class="text-muted">{{ $signup_payment_content }}</small>
                </div>
                @endif
            </div>

            <!-- Payment Actions -->
            <div class="payment-actions">
                <!-- Stripe -->
                <div class="stripe_payment" style="display: none;">
                    <button type="button" class="payment-btn stripe_button" @if($payment_pending) disabled @endif>
                        <span class="btn-text">Complete Payment</span>
                        <span class="spinner" style="display: none;"></span>
                    </button>
                </div>

                <!-- PayPal -->
                <div class="PaypalPayment" style="display: none;">
                    <div id="paypal-button-container"></div>
                </div>

                <!-- Razorpay -->
                <div class="Razorpay_payment" style="display: none;">
                    <button type="button" class="payment-btn Razorpay_button" @if($payment_pending) disabled @endif>
                        <span class="btn-text">Pay with Razorpay</span>
                        <span class="spinner" style="display: none;"></span>
                    </button>
                </div>

                <!-- Paystack -->
                <div class="paystack_payment" style="display: none;">
                    <button type="button" class="payment-btn paystack_button" @if($payment_pending) disabled @endif>
                        <span class="btn-text">Pay with PayStack</span>
                        <span class="spinner" style="display: none;"></span>
                    </button>
                </div>

                <!-- CinetPay -->
                <div class="cinetpay_payment" style="display: none;">
                    <button type="button" class="payment-btn cinetpay_button" onclick="cinetpay_checkout()" @if($payment_pending) disabled @endif>
                        <span class="btn-text">Pay with CinetPay</span>
                    </button>
                </div>

                <!-- Paydunya -->
                <div class="Paydunya_payment" style="display: none;">
                    <button type="button" class="payment-btn Paydunya_button" @if($payment_pending) disabled @endif>
                        <span class="btn-text">Pay with Paydunya</span>
                        <span class="spinner" style="display: none;"></span>
                    </button>
                </div>

                <!-- Recurly -->
                <div class="Recurly_payment" style="display: none;">
                    <form action="{{ route('Recurly.checkout_page') }}" method="post">
                        @csrf
                        <input type="hidden" id="recurly_plan_name" name="recurly_plan_id" value="{{ $plan->plans_name ?? '' }}">
                        <input type="hidden" id="payment_current_route_uri" name="payment_current_route_uri" value="{{ $payment_current_route_uri ?? '' }}">
                        <button type="submit" class="payment-btn" @if($payment_pending) disabled @endif>
                            <span class="btn-text">Pay with Recurly</span>
                        </button>
                    </form>
                </div>

                <div style="text-align: center; margin-top: 2rem;">
                    <a href="{{ URL::to('/home') }}" class="secondary-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9,22 9,12 15,12 15,22"></polyline>
                        </svg>
                        Go to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Inputs -->
<input type="hidden" id="base_url" value="{{ URL::to('/') }}">
<input type="hidden" id="plan_name" name="plan_name" value="{{ $SubscriptionPlan ? $SubscriptionPlan->plan_id : '' }}">
<input type="hidden" id="payment_type" name="payment_type" value="{{ $SubscriptionPlan ? $SubscriptionPlan->payment_type : '' }}">
<input type="hidden" id="currency_symbol" value="{{ currency_symbol() }}">
<input type="hidden" id="Cinetpay_Price" name="Cinetpay_Price" value="">
<input type="hidden" id="payment_image" value="{{ URL::to('/') }}/public/Thumbnai_images">
<input type="hidden" id="payment_pending_status" value="{{ $payment_pending ? 'true' : 'false' }}">

<!-- Scripts -->
<script src="https://js.stripe.com/v3/"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://cdn.cinetpay.com/seamless/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    const planCards = document.querySelectorAll('.plan-card');
    const paymentSections = document.querySelectorAll('[class*="_payment"], .PaypalPayment');
    const base_url = document.getElementById('base_url').value;
    const payment_images = document.getElementById('payment_image').value;
    const paymentPending = document.getElementById('payment_pending_status').value === 'true';
    
    let selectedPlan = null;
    let selectedPayment = null;

    // Check if payment is pending and disable interactions
    if (paymentPending) {
        showPaymentPendingAlert();
        return; // Don't initialize any payment functionality
    }

    // Auto-select if only one payment method is available
    if (paymentMethods.length === 1) {
        const singleMethod = paymentMethods[0];
        const radio = singleMethod.querySelector('input[type="radio"]');
        const paymentType = radio.value;
        
        // Auto-select the single payment method
        singleMethod.classList.add('selected');
        radio.checked = true;
        selectedPayment = paymentType;
        
        updateSummary();
        loadPlansForPayment(paymentType);
        showPaymentSection(paymentType);
    }

    // Payment Method Selection
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            if (paymentPending) return;
            
            const radio = this.querySelector('input[type="radio"]');
            const paymentType = radio.value;
            
            // Update UI
            paymentMethods.forEach(m => m.classList.remove('selected'));
            this.classList.add('selected');
            radio.checked = true;
            
            selectedPayment = paymentType;
            updateSummary();
            loadPlansForPayment(paymentType);
            showPaymentSection(paymentType);
        });
    });

    // Plan Selection
    planCards.forEach(card => {
        card.addEventListener('click', function() {
            if (paymentPending) return;
            
            planCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            
            selectedPlan = {
                id: this.dataset.planId,
                name: this.querySelector('.plan-name').textContent,
                price: this.dataset.planPrice,
                plan_id: this.dataset.plan_id,
                payment_type: this.dataset.paymentType,
                pay_type: this.dataset.payType
            };
            
            updateHiddenInputs();
            updateSummary();
            
            if (selectedPlan.pay_type === 'PayPal') {
                initializePayPal();
            }
        });
    });

    // function showPaymentPendingAlert() {
    //     showAlert('Payment is currently pending. Please wait for the current transaction to complete or wait 5 minutes before trying again. If your last payment was successful, please wait a couple of minutes for the system to update.', 'warning');
    // }

    function updateSummary() {
        document.getElementById('selected_plan_name').textContent = selectedPlan ? selectedPlan.name : 'Select a plan';
        document.getElementById('selected_payment_method').textContent = selectedPayment ? selectedPayment : 'Select payment method';
        
        if (selectedPlan) {
            document.querySelectorAll('.plan_price').forEach(el => {
                el.textContent = selectedPlan.price;
            });
        }
    }

    function updateHiddenInputs() {
        if (selectedPlan) {
            document.getElementById('plan_name').value = selectedPlan.plan_id;
            document.getElementById('payment_type').value = selectedPlan.payment_type;
            document.getElementById('Cinetpay_Price').value = selectedPlan.price;
            document.getElementById('recurly_plan_name').value = selectedPlan.name;
        }
    }

    function showPaymentSection(paymentType) {
        // Hide all payment sections
        paymentSections.forEach(section => {
            section.style.display = 'none';
        });

        // Show selected payment section
        const sectionMap = {
            'stripe': '.stripe_payment',
            'paypal': '.PaypalPayment',
            'Razorpay': '.Razorpay_payment',
            'paystack': '.paystack_payment',
            'CinetPay': '.cinetpay_payment',
            'Paydunya': '.Paydunya_payment',
            'Recurly': '.Recurly_payment'
        };

        const sectionSelector = sectionMap[paymentType];
        if (sectionSelector) {
            const section = document.querySelector(sectionSelector);
            if (section) {
                section.style.display = 'block';
            }
        }
    }

    function loadPlansForPayment(paymentType) {
        showLoading();

        fetch('{{ route("BecomeSubscriber_Plans") }}?' + new URLSearchParams({
            payment_gateway: paymentType,
            _token: '{{ csrf_token() }}'
        }))
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.data && data.data.status && data.data.plans_data.length > 0) {
                updatePlansDisplay(data.data.plans_data);
            } else {
                showAlert('No plans found for this payment method', 'warning');
            }
        })
        .catch(error => {
            hideLoading();
            showAlert('Error loading plans', 'error');
            console.error('Error:', error);
        });
    }

    function updatePlansDisplay(plansData) {
        const plansContainer = document.querySelector('.data-plans');
        plansContainer.innerHTML = '';

        plansData.forEach(plan => {
            const planCard = document.createElement('div');
            planCard.className = 'plan-card';
            planCard.dataset.planId = `${plan.id}`;
            planCard.dataset.planPrice = plan.price;
            planCard.dataset.plan_id = plan.plan_id;
            planCard.dataset.payType = plan.type;
            planCard.dataset.paymentType = plan.payment_type;

            planCard.innerHTML = `
                <div class="plan-header">
                    <h3 class="plan-name">${plan.plans_name}</h3>
                    <div class="plan-price">${plan.price}</div>
                    <div class="plan-duration">${plan.days || ''} Days Membership</div>
                </div>
                <div class="plan-features">
                    <p>${plan.plan_content || ''}</p>
                </div>
            `;

            planCard.addEventListener('click', function() {
                if (paymentPending) return;
                
                document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                
                selectedPlan = {
                    id: this.dataset.planId,
                    name: plan.plans_name,
                    price: plan.price,
                    plan_id: plan.plan_id,
                    payment_type: plan.payment_type,
                    pay_type: plan.type
                };
                
                updateHiddenInputs();
                updateSummary();
                
                if (selectedPlan.pay_type === 'PayPal') {
                    initializePayPal();
                }
            });

            plansContainer.appendChild(planCard);
        });
    }

    function initializePayPal() {
        if (!selectedPlan || !window.paypal || paymentPending) return;

        const container = document.getElementById('paypal-button-container');
        container.innerHTML = '';

        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'blue',
                layout: 'vertical',
                label: 'subscribe',
                height: 50
            },
            createSubscription: function(data, actions) {
                return actions.subscription.create({
                    plan_id: selectedPlan.plan_id
                });
            },
            onApprove: function(data, actions) {
                showLoading('Processing payment...');
                
                fetch(base_url + '/paypal-subscription', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        payment_type: selectedPlan.payment_type,
                        amount: selectedPlan.price,
                        plan: selectedPlan.plan_id,
                        plans_id: selectedPlan.plan_id,
                        subscriptionID: data.subscriptionID,
                        orderID: data.orderID,
                        userId: '{{ Auth::user()->id }}'
                    })
                })
                .then(response => response.json())
                .then(result => {
                    hideLoading();
                    showAlert('Subscription purchased successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = base_url + '/myprofile';
                    }, 2000);
                })
                .catch(error => {
                    hideLoading();
                    showAlert('Payment failed. Please try again.', 'error');
                    console.error('Error:', error);
                });
            },
            onError: function(err) {
                console.error('PayPal Error:', err);
                showAlert('Payment failed. Please try again.', 'error');
            }
        }).render('#paypal-button-container');
    }

    // Payment Button Handlers
    document.addEventListener('click', function(e) {
        if (paymentPending) {
            showPaymentPendingAlert();
            return;
        }
        
        if (e.target.closest('.stripe_button')) {
            handleStripePayment();
        } else if (e.target.closest('.Razorpay_button')) {
            handleRazorpayPayment();
        } else if (e.target.closest('.paystack_button')) {
            handlePaystackPayment();
        } else if (e.target.closest('.Paydunya_button')) {
            handlePaydunyaPayment();
        }
    });

    function handleStripePayment() {
        if (!selectedPlan || paymentPending) {
            showAlert('Please select a plan first', 'warning');
            return;
        }

        const button = document.querySelector('.stripe_button');
        setButtonLoading(button, true);

        fetch('{{ route("Stripe_authorization_url") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                Stripe_Plan_id: selectedPlan.plan_id
            })
        })
        .then(response => response.json())
        .then(data => {
            setButtonLoading(button, false);
            if (data.status) {
                window.location.href = data.authorization_url;
            } else {
                showAlert(data.message || 'Payment failed', 'error');
            }
        })
        .catch(error => {
            setButtonLoading(button, false);
            showAlert('Payment failed. Please try again.', 'error');
            console.error('Error:', error);
        });
    }

    function handleRazorpayPayment() {
        if (!selectedPlan || paymentPending) {
            showAlert('Please select a plan first', 'warning');
            return;
        }

        const button = document.querySelector('.Razorpay_button');
        setButtonLoading(button, true);

        // Updated to redirect to the new route format
        const razorpayUrl = base_url + '/subscribe/razorpay/' + selectedPlan.id;
        window.location.href = razorpayUrl;
    }

    function handlePaystackPayment() {
        if (!selectedPlan || paymentPending) {
            showAlert('Please select a plan first', 'warning');
            return;
        }

        const button = document.querySelector('.paystack_button');
        setButtonLoading(button, true);

        fetch('{{ route("Paystack_CreateSubscription") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                paystack_plan_id: selectedPlan.plan_id
            })
        })
        .then(response => response.json())
        .then(data => {
            setButtonLoading(button, false);
            if (data.status) {
                window.location.href = data.authorization_url;
            } else {
                showAlert(data.message || 'Payment failed', 'error');
            }
        })
        .catch(error => {
            setButtonLoading(button, false);
            showAlert('Payment failed. Please try again.', 'error');
            console.error('Error:', error);
        });
    }

    function handlePaydunyaPayment() {
        if (!selectedPlan || paymentPending) {
            showAlert('Please select a plan first', 'warning');
            return;
        }

        const button = document.querySelector('.Paydunya_button');
        setButtonLoading(button, true);

        fetch('{{ route("Paydunya_checkout") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                Paydunya_plan_id: selectedPlan.plan_id
            })
        })
        .then(response => response.json())
        .then(data => {
            setButtonLoading(button, false);
            if (data.status) {
                window.location.href = data.authorization_url;
            } else {
                showAlert(data.message || 'Payment failed', 'error');
            }
        })
        .catch(error => {
            setButtonLoading(button, false);
            showAlert('Payment failed. Please try again.', 'error');
            console.error('Error:', error);
        });
    }

    // CinetPay Payment Handler
    window.cinetpay_checkout = function() {
        if (!selectedPlan || paymentPending) {
            showAlert('Please select a plan first', 'warning');
            return;
        }

        const user_name = '{{ Auth::user()->username ?? "" }}';
        const email = '{{ Auth::user()->email ?? "" }}';
        const mobile = '{{ Auth::user()->mobile ?? "" }}';
        const CinetPay_APIKEY = '{{ $CinetPay_payment_settings->CinetPay_APIKEY ?? "" }}';
        const CinetPay_SITE_ID = '{{ $CinetPay_payment_settings->CinetPay_SITE_ID ?? "" }}';
        const user_id = '{{ Auth::user()->id ?? "" }}';
        const transaction_id = Math.floor(Math.random() * 100000000).toString();
        const currency = '{{ currency_symbol() }}';

        if (typeof CinetPay === 'undefined') {
            showAlert('CinetPay is not loaded', 'error');
            return;
        }

        CinetPay.setConfig({
            apikey: CinetPay_APIKEY,
            site_id: CinetPay_SITE_ID,
            notify_url: window.location.href,
            return_url: window.location.href
        });

        CinetPay.getCheckout({
            transaction_id: transaction_id,
            amount: selectedPlan.price,
            currency: currency,
            channels: 'ALL',
            description: 'Subscription Payment',
            customer_name: user_name,
            customer_surname: user_name,
            customer_email: email,
            customer_phone_number: mobile,
            customer_address: "Address",
            customer_city: "City",
            customer_country: "CM",
            customer_state: "CM",
            customer_zip_code: "00000"
        });

        CinetPay.waitResponse(function(data) {
            if (data.status === "REFUSED") {
                showAlert('Payment failed', 'error');
            } else if (data.status === "ACCEPTED") {
                fetch('{{ route("CinetPay_Subscription") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        amount: selectedPlan.price,
                        plan_name: selectedPlan.plan_id,
                        email: email,
                        user_name: user_name,
                        user_id: user_id,
                        transaction_id: transaction_id
                    })
                })
                .then(response => response.json())
                .then(result => {
                    showAlert('Payment successful!', 'success');
                    setTimeout(() => {
                        window.location.href = base_url + '/myprofile';
                    }, 2000);
                })
                .catch(error => {
                    showAlert('Payment processing failed', 'error');
                    console.error('Error:', error);
                });
            }
        });

        CinetPay.onError(function(data) {
            showAlert('Payment error occurred', 'error');
            console.error('CinetPay Error:', data);
        });
    };

    // Utility Functions
    function showLoading(message = 'Loading...') {
        if (typeof swal !== 'undefined') {
            swal({
                title: message,
                text: "Please wait",
                icon: payment_images + '/Loading.gif',
                buttons: false,
                closeOnClickOutside: false,
                closeOnEsc: false
            });
        }
    }

    function hideLoading() {
        if (typeof swal !== 'undefined') {
            swal.close();
        }
    }

    function showAlert(message, type = 'info') {
        if (typeof swal !== 'undefined') {
            const iconMap = {
                success: payment_images + '/Successful_Payment.gif',
                error: 'error',
                warning: 'warning',
                info: 'info'
            };
            
            swal({
                title: type === 'success' ? 'Success!' : type === 'error' ? 'Error!' : 'Notice',
                text: message,
                icon: iconMap[type] || 'info'
            });
        } else {
            alert(message);
        }
    }

    function setButtonLoading(button, loading) {
        if (!button) return;
        
        const textSpan = button.querySelector('.btn-text');
        const spinner = button.querySelector('.spinner');
        
        if (loading) {
            button.disabled = true;
            button.classList.add('loading');
            if (textSpan) textSpan.style.display = 'none';
            if (spinner) spinner.style.display = 'inline-block';
        } else {
            button.disabled = false;
            button.classList.remove('loading');
            if (textSpan) textSpan.style.display = 'inline';
            if (spinner) spinner.style.display = 'none';
        }
    }
});
</script>

@php include public_path('themes/default/views/footer.blade.php'); @endphp

@endsection