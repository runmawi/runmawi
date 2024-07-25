@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<script src="https://js.recurly.com/v4/recurly.js"></script>
<link href="https://js.recurly.com/v4/recurly.css" rel="stylesheet" type="text/css">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="checkout-page">
    <header class="header">
        <h1 class="mt-5"><img src="https://images.recurly.com/checkout-style/webnexs-1512514655-logo.png"
                class="max-h-16 max-w-auto" alt="NemaTV Logo" style="width: 100px;"></h1>
        <div class="lg:max-w-lg mx-auto lg:mx-0 lg:pr-8 mt-4">
            <a class="backButton" href="history.back()">← Back </a>
        </div>
    </header>

    <section class="container d-flex justify-content-around">
        <form class="mb-5" id='my-form'>
            <div class="form-group">
                <h5 class="mt-5 mb-3" for="email">Contact Information</h5>
                <label class="form-label">Email <span class="text-red-500">&nbsp;*</span> </label>
                <input type="email" class="form-control" id="email" placeholder="Email" value={{ @($user_details->email) }} required readonly>
            </div>

            <div class="form-group">
                <h5 class="mt-5 mb-3" for="card-details">Billing Information</h5>
                <label class="form-label">Card Details <span class="text-red-500">&nbsp;*</span> </label>
                <div class="col-md-12" id="recurly-elements"></div>
            </div>

            <div class="form-group">
                <h5 class="mt-5 mb-3">Billing Address</h5>
                <label class="form-label">Country <span class="text-red-500">&nbsp;*</span> </label>
                <select class="form-control" required data-recurly="country">
                    <option value="AF">Afghanistan</option>
                    <option value="AX">Åland Islands</option>
                    <option value="AL">Albania</option>
                    <option value="DZ">Algeria</option>
                    <option value="AS">American Samoa</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AQ">Antarctica</option>
                    <option value="AG">Antigua and Barbuda</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahrain</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BY">Belarus</option>
                    <option value="BE">Belgium</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ">Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BT">Bhutan</option>
                    <option value="BO">Bolivia</option>
                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                    <option value="BA">Bosnia and Herzegovina</option>
                    <option value="BW">Botswana</option>
                    <option value="BV">Bouvet Island</option>
                    <option value="BR">Brazil</option>
                    <option value="IO">British Indian Ocean Territory</option>
                    <option value="BN">Brunei Darussalam</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="KH">Cambodia</option>
                    <option value="CM">Cameroon</option>
                    <option value="CA">Canada</option>
                    <option value="CV">Cape Verde</option>
                    <option value="KY">Cayman Islands</option>
                    <option value="CF">Central African Republic</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CX">Christmas Island</option>
                    <option value="CC">Cocos (Keeling) Islands</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros</option>
                    <option value="CK">Cook Islands</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Cote d'Ivoire</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cuba</option>
                    <option value="CW">Curaçao</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="CD">Democratic Republic of the Congo</option>
                    <option value="DK">Denmark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="DO">Dominican Republic</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="GQ">Equatorial Guinea</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="SZ">Eswatini</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FK">Falkland Islands (Malvinas)</option>
                    <option value="FO">Faroe Islands</option>
                    <option value="FJ">Fiji</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="GF">French Guiana</option>
                    <option value="PF">French Polynesia</option>
                    <option value="TF">French Southern Territories</option>
                    <option value="GA">Gabon</option>
                    <option value="GE">Georgia</option>
                    <option value="DE">Germany</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR">Greece</option>
                    <option value="GL">Greenland</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GW">Guinea-Bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="HM">Heard Island and McDonald Islands</option>
                    <option value="VA">Holy See (Vatican City State)</option>
                    <option value="HN">Honduras</option>
                    <option value="HK">Hong Kong</option>
                    <option value="HU">Hungary</option>
                    <option value="IS">Iceland</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Ireland</option>
                    <option value="IR">Islamic Republic of Iran</option>
                    <option value="IM">Isle of Man</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japan</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="XK">Kosovo</option>
                    <option value="KW">Kuwait</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="LA">Lao People's Democratic Republic</option>
                    <option value="LV">Latvia</option>
                    <option value="LB">Lebanon</option>
                    <option value="LS">Lesotho</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libya</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macao</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MH">Marshall Islands</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mexico</option>
                    <option value="FM">Micronesia, Federated States of</option>
                    <option value="MD">Moldova, Republic of</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolia</option>
                    <option value="ME">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MA">Morocco</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="NL">Netherlands</option>
                    <option value="NC">New Caledonia</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="NF">Norfolk Island</option>
                    <option value="KP">North Korea</option>
                    <option value="MP">Northern Mariana Islands</option>
                    <option value="NO">Norway</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="CN">People's Republic of China</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="CG">Republic of the Congo</option>
                    <option value="GM">Republic of The Gambia</option>
                    <option value="RE">Reunion</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russian Federation</option>
                    <option value="RW">Rwanda</option>
                    <option value="BL">Saint Barthélemy</option>
                    <option value="SH">Saint Helena</option>
                    <option value="KN">Saint Kitts and Nevis</option>
                    <option value="LC">Saint Lucia</option>
                    <option value="MF">Saint Martin (French part)</option>
                    <option value="PM">Saint Pierre and Miquelon</option>
                    <option value="VC">Saint Vincent and the Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="ST">Sao Tome and Principe</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SX">Sint Maarten (Dutch part)</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SB">Solomon Islands</option>
                    <option value="SO">Somalia</option>
                    <option value="ZA">South Africa</option>
                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                    <option value="KR">South Korea</option>
                    <option value="SS">South Sudan</option>
                    <option value="ES">Spain</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="PS">State of Palestine</option>
                    <option value="SD">Sudan</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard and Jan Mayen</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                    <option value="SY">Syrian Arab Republic</option>
                    <option value="TW">Taiwan, Province of China</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TH">Thailand</option>
                    <option value="MK">The Republic of North Macedonia</option>
                    <option value="TL">Timor-Leste</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad and Tobago</option>
                    <option value="TN">Tunisia</option>
                    <option value="TR">Türkiye</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TC">Turks and Caicos Islands</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates</option>
                    <option value="GB">United Kingdom</option>
                    <option value="TZ">United Republic of Tanzania</option>
                    <option value="UM">United States Minor Outlying Islands</option>
                    <option value="US">United States of America</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela</option>
                    <option value="VN">Vietnam</option>
                    <option value="VG">Virgin Islands, British</option>
                    <option value="VI">Virgin Islands, U.S.</option>
                    <option value="WF">Wallis and Futuna</option>
                    <option value="EH">Western Sahara</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                    <!-- Add more countries as needed -->
                </select>

                <div class="row">
                    <div class="col">
                        <label class="form-label"> First Name <span class="text-red-500">&nbsp;*</span> </label>
                        <input type="text" class="form-control" data-recurly="first_name" placeholder="First Name" value="{{ ($user_details->username) }}" readonly required>
                    </div>
                    <div class="col">
                        <label class="form-label">Last Name <span class="text-red-500">&nbsp;*</span> </label>
                        <input type="text" class="form-control" data-recurly="last_name" placeholder="Last Name"  value="{{ ($user_details->username) }}" required>
                    </div>
                </div>

                <label class="form-label">Address 1 <span class="text-red-500">&nbsp;*</span> </label>
                <input type="text" class="form-control" data-recurly="address1" placeholder="address1"  value="{{ 'Chennai' }}" required>


                <label class="form-label">City <span class="text-red-500">&nbsp;*</span> </label>
                <input type="text" class="form-control" data-recurly="city" placeholder="City"  value="{{ 'Chennai' }}" required>

                <div class="row">
                    <div class="col">
                        <label class="form-label">State <span class="text-red-500">&nbsp;*</span> </label>
                        <input type="text" class="form-control"  placeholder="State" value="{{ 'TN' }}" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Zip/Postal Code <span class="text-red-500">&nbsp;*</span> </label>
                        <input type="text" class="form-control" data-recurly="postal_code" placeholder="Zip/Postal" required  value="{{ "600011" }}" >
                    </div>
                </div>
            </div>

            <input type="hidden" name="recurly-token" data-recurly="token">

            <button type="submit" class="pay_now btn-block">Pay now</button>
        </form>

        <div class="order-summary mt-4 mb-5">
            <div class="flex font-medium items-end lg:flex-wrap">
                <h5 class="flex-auto lg:text-xl">Order Summary</h5>
                <div class="flex-none lg:basis-full lg:mt-7 mt-3 mb-3">
                    <h3 class="lg:text-3xl" style="font-weight:500 !important">₹ {{ $plan_details->getCurrencies()[0]->getUnitAmount() }}
                        <span class="text-xs hidden lg:inline"
                            style="font-size:0.50em;font-weight:500 !important;">&nbsp;{{ $plan_details->getCurrencies()[0]->getcurrency() }}</span>
                    </h3>
                </div>
            </div>
            <div class="border-b border-gray-300">
                <ul>
                    <li class="py-3 dark:border-slate-600 last:border-b-0 last:pb-0">
                        <div class="flex gap-x-2 d-flex justify-content-between" style="font-weight:600">
                            <div class="flex-auto">
                                <span class="font-bold">{{ $plan_details->getname() }}</span>
                            </div>
                            <div class="flex-none font-bold">₹{{ $plan_details->getCurrencies()[0]->getUnitAmount() .'/'. $plan_details->getIntervalunit() }}</div>
                        </div>
                        <div class="basis-full">
                            <div class="mt-2 pl-4 border-l-2 border-gray-300 text-sm leading-6 text-checkout-subtle">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <hr>
            <div class="pt-6">
                <div class="grid grid-cols-2 items-start my-2 d-flex justify-content-between">
                    <div class="text-right">Subtotal</div>
                    <div>₹{{ $plan_details->getCurrencies()[0]->getUnitAmount() }}</div>
                </div>

                <div class="coupons-card">
                    <label class="col-span-4 add-gift" style="color: rgb(91 38 102) !important; cursor: pointer;">Add
                        gift card or promo code</label>
                </div>
                <div class="flex-grow promo">
                    <label for=":rd:" class="text-gray-500">Gift card or promo code</label>
                    <div class="d-flex justify-content-between">
                        <input
                            class="form-control w-full mt-2 p-2 ring-1 appearance-none rounded-md shadow-sm bg-transparent text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none ring-gray-400"
                            type="text">
                        <div class="apply-button">
                            <button style="height: 100%;width: 75%;">Apply</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="font-medium">Total</div>
                    <div class="text-right">
                        <span class="font-medium">₹ {{ $plan_details->getCurrencies()[0]->getUnitAmount() }}</span>
                    </div>
                </div>
                <p class="text-xs mt-5 text-checkout-subtle" style="font-size:0.7em">Subscription billing powered by
                    <a href="#" class="text-checkout-subtle" target="_blank">Recurly</a>
                </p>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    recurly.configure('ewr1-vqBCG3NdYAcm94MqtiVWlb');

    const elements = recurly.Elements();

    const cardElement = elements.CardElement({
        inputType: 'mobileSelect',
        style: {
            fontSize: '1em',
            placeholder: {
                color: 'gray !important',
                fontWeight: 'normal',
                displayIcon: 'true',
                content: {
                    number: 'Card number',
                    cvv: 'CVC',
                    expiry: 'MM / YY'
                }
            },
            invalid: {
                fontColor: 'red'
            }
        }
    });
    cardElement.attach('#recurly-elements');

    document.querySelector('#my-form').addEventListener('submit', function(event) {
        const form = this;
        event.preventDefault();
        recurly.token(elements, form, function(err, token) {
            if (err) {
                alert('Token creation failed: ' + err.message);
                // handle error using err.code and err.fields
            } else {
                // createSubscription(token.id);
                console.log(token.id);
                console.log(token);

            }
        });
    });

    function createSubscription(tokenId) {
        fetch('recurly/subscription', {
            method: 'get',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ tokenId: tokenId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Subscription created successfully!');
            } else {
                alert('Failed to create subscription: ' + data.error);
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    }

</script>


<style>
    .checkout-page {
        background-color: #f8f9fa;
        color: black !important;
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
    }

    .header {
        margin-bottom: 15px;
        margin-left: 15%;
    }

    .order-summary {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        height: 50%;
        width: 30%;
        color: black !important;
    }

    button {
        background-color: rgb(91 38 102) !important;
        color: white;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        padding: 5px;
    }

    .form-control {
        height: 35px !important;
        border-radius: 5px;
        border: 1px solid #dbcfcf !important;
        color: grey !important;
    }

    .form-label {
        color: grey;
    }

    select,
    option,
    h3 {
        color: black;
    }

    .text-red-500 {
        color: red;
    }

    h5 {
        font-weight: 500;
        color: black;
    }

    #recurly-elements {
        border: 1px solid #dbcfcf !important;
        border-radius: 5px !important;
    }

    .recurly-element {
        border: none;
        padding: 0px 0px 0px 0px !important;
        margin-top: 0 !important;
        background-color: #f8f9fa !important;
    }

    ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .apply-button {
        margin-top: 7px;
        margin-left: 10px;
        width: 50%;
        height: 6vh;
    }

    .promo {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.add-gift').addEventListener('click', function(e) {
            console.log("click");
            e.preventDefault();
            document.querySelector('.promo').style.display = 'block';
            this.style.display = 'none';
        });
        document.querySelector('.apply-button').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.promo').style.display = 'none';
            document.querySelector('.add-gift').style.display = 'block';
        })
    });
</script>

<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
