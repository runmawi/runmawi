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
        <form class="mb-5" id='my-form' action="{{ route('Recurly.subscription') }}">
            <div class="form-group">
                <h5 class="mt-5 mb-3" for="email">Contact Information</h5>
                <label class="form-label">Email <span class="text-red-500">&nbsp;*</span> </label>
                <input type="email" class="form-control" id="email" placeholder="Email" value={{ @($user_details->email) }} required readonly>
            </div>

            <div class="form-group">
                <h5 class="mt-5 mb-3" for="card-details">Billing Information</h5>
                <label class="form-label">Card Details <span class="text-red-500">&nbsp;*</span> </label>
                <div class="col-md-12 row">
                    <div class="col-md-6"><input  type="text" inputmode="numeric" autocomplete="cc-number" minlength="19" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" required class="form-control" name="card_number"  id="cardNumber" required></div>
                    <div class="col-md-3"><input type="text" class="form-control" id="exp_month" name="exp_month" placeholder="MM / YYYY"  minlength="7" maxlength="7" required></div>
                    <div class="col-md-3"><input type="text" inputmode="numeric"  class="form-control" name="cvc" placeholder="CVC"  minlength="3" maxlength="4" required> </div>
                </div>
            </div>

            <div class="form-group">
                <h5 class="mt-5 mb-3">Billing Address</h5>
                <label class="form-label">Country <span class="text-red-500">&nbsp;*</span> </label>
                <select class="form-control" required name="country">
                    <option value="AF" {{ $Country_code == "AF" ? 'selected' : '' }}>Afghanistan</option>
                    <option value="AX" {{ $Country_code == "AX" ? 'selected' : '' }}>Åland Islands</option>
                    <option value="AL" {{ $Country_code == "AL" ? 'selected' : '' }}>Albania</option>
                    <option value="DZ" {{ $Country_code == "DZ" ? 'selected' : '' }}>Algeria</option>
                    <option value="AS" {{ $Country_code == "AS" ? 'selected' : '' }}>American Samoa</option>
                    <option value="AD" {{ $Country_code == "AD" ? 'selected' : '' }}>Andorra</option>
                    <option value="AO" {{ $Country_code == "AO" ? 'selected' : '' }}>Angola</option>
                    <option value="AI" {{ $Country_code == "AI" ? 'selected' : '' }}>Anguilla</option>
                    <option value="AQ" {{ $Country_code == "AQ" ? 'selected' : '' }}>Antarctica</option>
                    <option value="AG" {{ $Country_code == "AG" ? 'selected' : '' }}>Antigua and Barbuda</option>
                    <option value="AR" {{ $Country_code == "AR" ? 'selected' : '' }}>Argentina</option>
                    <option value="AM" {{ $Country_code == "AM" ? 'selected' : '' }}>Armenia</option>
                    <option value="AW" {{ $Country_code == "AW" ? 'selected' : '' }}>Aruba</option>
                    <option value="AU" {{ $Country_code == "AU" ? 'selected' : '' }}>Australia</option>
                    <option value="AT" {{ $Country_code == "AT" ? 'selected' : '' }}>Austria</option>
                    <option value="AZ" {{ $Country_code == "AZ" ? 'selected' : '' }}>Azerbaijan</option>
                    <option value="BS" {{ $Country_code == "BS" ? 'selected' : '' }}>Bahamas</option>
                    <option value="BH" {{ $Country_code == "BH" ? 'selected' : '' }}>Bahrain</option>
                    <option value="BD" {{ $Country_code == "BD" ? 'selected' : '' }}>Bangladesh</option>
                    <option value="BB" {{ $Country_code == "BB" ? 'selected' : '' }}>Barbados</option>
                    <option value="BY" {{ $Country_code == "BY" ? 'selected' : '' }}>Belarus</option>
                    <option value="BE" {{ $Country_code == "BE" ? 'selected' : '' }}>Belgium</option>
                    <option value="BZ" {{ $Country_code == "BZ" ? 'selected' : '' }}>Belize</option>
                    <option value="BJ" {{ $Country_code == "BJ" ? 'selected' : '' }}>Benin</option>
                    <option value="BM" {{ $Country_code == "BM" ? 'selected' : '' }}>Bermuda</option>
                    <option value="BT" {{ $Country_code == "BT" ? 'selected' : '' }}>Bhutan</option>
                    <option value="BO" {{ $Country_code == "BO" ? 'selected' : '' }}>Bolivia</option>
                    <option value="BQ" {{ $Country_code == "BQ" ? 'selected' : '' }}>Bonaire, Sint Eustatius and Saba</option>
                    <option value="BA" {{ $Country_code == "BA" ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                    <option value="BW" {{ $Country_code == "BW" ? 'selected' : '' }}>Botswana</option>
                    <option value="BV" {{ $Country_code == "BV" ? 'selected' : '' }}>Bouvet Island</option>
                    <option value="BR" {{ $Country_code == "BR" ? 'selected' : '' }}>Brazil</option>
                    <option value="IO" {{ $Country_code == "IO" ? 'selected' : '' }}>British Indian Ocean Territory</option>
                    <option value="BN" {{ $Country_code == "BN" ? 'selected' : '' }}>Brunei Darussalam</option>
                    <option value="BG" {{ $Country_code == "BG" ? 'selected' : '' }}>Bulgaria</option>
                    <option value="BF" {{ $Country_code == "BF" ? 'selected' : '' }}>Burkina Faso</option>
                    <option value="BI" {{ $Country_code == "BI" ? 'selected' : '' }}>Burundi</option>
                    <option value="KH" {{ $Country_code == "KH" ? 'selected' : '' }}>Cambodia</option>
                    <option value="CM" {{ $Country_code == "CM" ? 'selected' : '' }}>Cameroon</option>
                    <option value="CA" {{ $Country_code == "CA" ? 'selected' : '' }}>Canada</option>
                    <option value="CV" {{ $Country_code == "CV" ? 'selected' : '' }}>Cape Verde</option>
                    <option value="KY" {{ $Country_code == "KY" ? 'selected' : '' }}>Cayman Islands</option>
                    <option value="CF" {{ $Country_code == "CF" ? 'selected' : '' }}>Central African Republic</option>
                    <option value="TD" {{ $Country_code == "TD" ? 'selected' : '' }}>Chad</option>
                    <option value="CL" {{ $Country_code == "CL" ? 'selected' : '' }}>Chile</option>
                    <option value="CX" {{ $Country_code == "CX" ? 'selected' : '' }}>Christmas Island</option>
                    <option value="CC" {{ $Country_code == "CC" ? 'selected' : '' }}>Cocos (Keeling) Islands</option>
                    <option value="CO" {{ $Country_code == "CO" ? 'selected' : '' }}>Colombia</option>
                    <option value="KM" {{ $Country_code == "KM" ? 'selected' : '' }}>Comoros</option>
                    <option value="CK" {{ $Country_code == "CK" ? 'selected' : '' }}>Cook Islands</option>
                    <option value="CR" {{ $Country_code == "CR" ? 'selected' : '' }}>Costa Rica</option>
                    <option value="CI" {{ $Country_code == "CI" ? 'selected' : '' }}>Cote d'Ivoire</option>
                    <option value="HR" {{ $Country_code == "HR" ? 'selected' : '' }}>Croatia</option>
                    <option value="CU" {{ $Country_code == "CU" ? 'selected' : '' }}>Cuba</option>
                    <option value="CW" {{ $Country_code == "CW" ? 'selected' : '' }}>Curaçao</option>
                    <option value="CY" {{ $Country_code == "CY" ? 'selected' : '' }}>Cyprus</option>
                    <option value="CZ" {{ $Country_code == "CZ" ? 'selected' : '' }}>Czech Republic</option>
                    <option value="CD" {{ $Country_code == "CD" ? 'selected' : '' }}>Democratic Republic of the Congo</option>
                    <option value="DK" {{ $Country_code == "DK" ? 'selected' : '' }}>Denmark</option>
                    <option value="DJ" {{ $Country_code == "DJ" ? 'selected' : '' }}>Djibouti</option>
                    <option value="DM" {{ $Country_code == "DM" ? 'selected' : '' }}>Dominica</option>
                    <option value="DO" {{ $Country_code == "DO" ? 'selected' : '' }}>Dominican Republic</option>
                    <option value="EC" {{ $Country_code == "EC" ? 'selected' : '' }}>Ecuador</option>
                    <option value="EG" {{ $Country_code == "EG" ? 'selected' : '' }}>Egypt</option>
                    <option value="SV" {{ $Country_code == "SV" ? 'selected' : '' }}>El Salvador</option>
                    <option value="GQ" {{ $Country_code == "GQ" ? 'selected' : '' }}>Equatorial Guinea</option>
                    <option value="ER" {{ $Country_code == "ER" ? 'selected' : '' }}>Eritrea</option>
                    <option value="EE" {{ $Country_code == "EE" ? 'selected' : '' }}>Estonia</option>
                    <option value="SZ" {{ $Country_code == "SZ" ? 'selected' : '' }}>Eswatini</option>
                    <option value="ET" {{ $Country_code == "ET" ? 'selected' : '' }}>Ethiopia</option>
                    <option value="FK" {{ $Country_code == "FK" ? 'selected' : '' }}>Falkland Islands (Malvinas)</option>
                    <option value="FO" {{ $Country_code == "FO" ? 'selected' : '' }}>Faroe Islands</option>
                    <option value="FJ" {{ $Country_code == "FJ" ? 'selected' : '' }}>Fiji</option>
                    <option value="FI" {{ $Country_code == "FI" ? 'selected' : '' }}>Finland</option>
                    <option value="FR" {{ $Country_code == "FR" ? 'selected' : '' }}>France</option>
                    <option value="GF" {{ $Country_code == "GF" ? 'selected' : '' }}>French Guiana</option>
                    <option value="PF" {{ $Country_code == "PF" ? 'selected' : '' }}>French Polynesia</option>
                    <option value="TF" {{ $Country_code == "TF" ? 'selected' : '' }}>French Southern Territories</option>
                    <option value="GA" {{ $Country_code == "GA" ? 'selected' : '' }}>Gabon</option>
                    <option value="GE" {{ $Country_code == "GE" ? 'selected' : '' }}>Georgia</option>
                    <option value="DE" {{ $Country_code == "DE" ? 'selected' : '' }}>Germany</option>
                    <option value="GH" {{ $Country_code == "GH" ? 'selected' : '' }}>Ghana</option>
                    <option value="GI" {{ $Country_code == "GI" ? 'selected' : '' }}>Gibraltar</option>
                    <option value="GR" {{ $Country_code == "GR" ? 'selected' : '' }}>Greece</option>
                    <option value="GL" {{ $Country_code == "GL" ? 'selected' : '' }}>Greenland</option>
                    <option value="GD" {{ $Country_code == "GD" ? 'selected' : '' }}>Grenada</option>
                    <option value="GP" {{ $Country_code == "GP" ? 'selected' : '' }}>Guadeloupe</option>
                    <option value="GU" {{ $Country_code == "GU" ? 'selected' : '' }}>Guam</option>
                    <option value="GT" {{ $Country_code == "GT" ? 'selected' : '' }}>Guatemala</option>
                    <option value="GG" {{ $Country_code == "GG" ? 'selected' : '' }}>Guernsey</option>
                    <option value="GN" {{ $Country_code == "GN" ? 'selected' : '' }}>Guinea</option>
                    <option value="GW" {{ $Country_code == "GW" ? 'selected' : '' }}>Guinea-Bissau</option>
                    <option value="GY" {{ $Country_code == "GY" ? 'selected' : '' }}>Guyana</option>
                    <option value="HT" {{ $Country_code == "HT" ? 'selected' : '' }}>Haiti</option>
                    <option value="HM" {{ $Country_code == "HM" ? 'selected' : '' }}>Heard Island and McDonald Islands</option>
                    <option value="VA" {{ $Country_code == "VA" ? 'selected' : '' }}>Holy See (Vatican City State)</option>
                    <option value="HN" {{ $Country_code == "HN" ? 'selected' : '' }}>Honduras</option>
                    <option value="HK" {{ $Country_code == "HK" ? 'selected' : '' }}>Hong Kong</option>
                    <option value="HU" {{ $Country_code == "HU" ? 'selected' : '' }}>Hungary</option>
                    <option value="IS" {{ $Country_code == "IS" ? 'selected' : '' }}>Iceland</option>
                    <option value="IN" {{ $Country_code == "IN" ? 'selected' : '' }}>India</option>
                    <option value="ID" {{ $Country_code == "ID" ? 'selected' : '' }}>Indonesia</option>
                    <option value="IR" {{ $Country_code == "IR" ? 'selected' : '' }}>Islamic Republic of Iran</option>
                    <option value="IQ" {{ $Country_code == "IQ" ? 'selected' : '' }}>Iraq</option>
                    <option value="IE" {{ $Country_code == "IE" ? 'selected' : '' }}>Ireland</option>
                    <option value="IM" {{ $Country_code == "IM" ? 'selected' : '' }}>Isle of Man</option>
                    <option value="IL" {{ $Country_code == "IL" ? 'selected' : '' }}>Israel</option>
                    <option value="IT" {{ $Country_code == "IT" ? 'selected' : '' }}>Italy</option>
                    <option value="JM" {{ $Country_code == "JM" ? 'selected' : '' }}>Jamaica</option>
                    <option value="JP" {{ $Country_code == "JP" ? 'selected' : '' }}>Japan</option>
                    <option value="JE" {{ $Country_code == "JE" ? 'selected' : '' }}>Jersey</option>
                    <option value="JO" {{ $Country_code == "JO" ? 'selected' : '' }}>Jordan</option>
                    <option value="KZ" {{ $Country_code == "KZ" ? 'selected' : '' }}>Kazakhstan</option>
                    <option value="KE" {{ $Country_code == "KE" ? 'selected' : '' }}>Kenya</option>
                    <option value="KI" {{ $Country_code == "KI" ? 'selected' : '' }}>Kiribati</option>
                    <option value="XK" {{ $Country_code == "XK" ? 'selected' : '' }}>Kosovo</option>
                    <option value="KW" {{ $Country_code == "KW" ? 'selected' : '' }}>Kuwait</option>
                    <option value="KG" {{ $Country_code == "KG" ? 'selected' : '' }}>Kyrgyzstan</option>
                    <option value="LA" {{ $Country_code == "LA" ? 'selected' : '' }}>Lao People's Democratic Republic</option>
                    <option value="LV" {{ $Country_code == "LV" ? 'selected' : '' }}>Latvia</option>
                    <option value="LB" {{ $Country_code == "LB" ? 'selected' : '' }}>Lebanon</option>
                    <option value="LS" {{ $Country_code == "LS" ? 'selected' : '' }}>Lesotho</option>
                    <option value="LR" {{ $Country_code == "LR" ? 'selected' : '' }}>Liberia</option>
                    <option value="LY" {{ $Country_code == "LY" ? 'selected' : '' }}>Libya</option>
                    <option value="LI" {{ $Country_code == "LI" ? 'selected' : '' }}>Liechtenstein</option>
                    <option value="LT" {{ $Country_code == "LT" ? 'selected' : '' }}>Lithuania</option>
                    <option value="LU" {{ $Country_code == "LU" ? 'selected' : '' }}>Luxembourg</option>
                    <option value="MO" {{ $Country_code == "MO" ? 'selected' : '' }}>Macao</option>
                    <option value="MO" {{ $Country_code == "MO" ? 'selected' : '' }}>Macao</option>
                    <option value="MG" {{ $Country_code == "MG" ? 'selected' : '' }}>Madagascar</option>
                    <option value="MW" {{ $Country_code == "MW" ? 'selected' : '' }}>Malawi</option>
                    <option value="MY" {{ $Country_code == "MY" ? 'selected' : '' }}>Malaysia</option>
                    <option value="MV" {{ $Country_code == "MV" ? 'selected' : '' }}>Maldives</option>
                    <option value="ML" {{ $Country_code == "ML" ? 'selected' : '' }}>Mali</option>
                    <option value="MT" {{ $Country_code == "MT" ? 'selected' : '' }}>Malta</option>
                    <option value="MH" {{ $Country_code == "MH" ? 'selected' : '' }}>Marshall Islands</option>
                    <option value="MQ" {{ $Country_code == "MQ" ? 'selected' : '' }}>Martinique</option>
                    <option value="MR" {{ $Country_code == "MR" ? 'selected' : '' }}>Mauritania</option>
                    <option value="MU" {{ $Country_code == "MU" ? 'selected' : '' }}>Mauritius</option>
                    <option value="YT" {{ $Country_code == "YT" ? 'selected' : '' }}>Mayotte</option>
                    <option value="MX" {{ $Country_code == "MX" ? 'selected' : '' }}>Mexico</option>
                    <option value="FM" {{ $Country_code == "FM" ? 'selected' : '' }}>Micronesia, Federated States of</option>
                    <option value="MD" {{ $Country_code == "MD" ? 'selected' : '' }}>Moldova, Republic of</option>
                    <option value="MC" {{ $Country_code == "MC" ? 'selected' : '' }}>Monaco</option>
                    <option value="MN" {{ $Country_code == "MN" ? 'selected' : '' }}>Mongolia</option>
                    <option value="ME" {{ $Country_code == "ME" ? 'selected' : '' }}>Montenegro</option>
                    <option value="MS" {{ $Country_code == "MS" ? 'selected' : '' }}>Montserrat</option>
                    <option value="MA" {{ $Country_code == "MA" ? 'selected' : '' }}>Morocco</option>
                    <option value="MZ" {{ $Country_code == "MZ" ? 'selected' : '' }}>Mozambique</option>
                    <option value="MM" {{ $Country_code == "MM" ? 'selected' : '' }}>Myanmar</option>
                    <option value="NA" {{ $Country_code == "NA" ? 'selected' : '' }}>Namibia</option>
                    <option value="NR" {{ $Country_code == "NR" ? 'selected' : '' }}>Nauru</option>
                    <option value="NP" {{ $Country_code == "NP" ? 'selected' : '' }}>Nepal</option>
                    <option value="NL" {{ $Country_code == "NL" ? 'selected' : '' }}>Netherlands</option>
                    <option value="NC" {{ $Country_code == "NC" ? 'selected' : '' }}>New Caledonia</option>
                    <option value="NZ" {{ $Country_code == "NZ" ? 'selected' : '' }}>New Zealand</option>
                    <option value="NI" {{ $Country_code == "NI" ? 'selected' : '' }}>Nicaragua</option>
                    <option value="NE" {{ $Country_code == "NE" ? 'selected' : '' }}>Niger</option>
                    <option value="NG" {{ $Country_code == "NG" ? 'selected' : '' }}>Nigeria</option>
                    <option value="NU" {{ $Country_code == "NU" ? 'selected' : '' }}>Niue</option>
                    <option value="NF" {{ $Country_code == "NF" ? 'selected' : '' }}>Norfolk Island</option>
                    <option value="KP" {{ $Country_code == "KP" ? 'selected' : '' }}>North Korea</option>
                    <option value="MP" {{ $Country_code == "MP" ? 'selected' : '' }}>Northern Mariana Islands</option>
                    <option value="NO" {{ $Country_code == "NO" ? 'selected' : '' }}>Norway</option>
                    <option value="OM" {{ $Country_code == "OM" ? 'selected' : '' }}>Oman</option>
                    <option value="PK" {{ $Country_code == "PK" ? 'selected' : '' }}>Pakistan</option>
                    <option value="PW" {{ $Country_code == "PW" ? 'selected' : '' }}>Palau</option>
                    <option value="PA" {{ $Country_code == "PA" ? 'selected' : '' }}>Panama</option>
                    <option value="PG" {{ $Country_code == "PG" ? 'selected' : '' }}>Papua New Guinea</option>
                    <option value="PY" {{ $Country_code == "PY" ? 'selected' : '' }}>Paraguay</option>
                    <option value="PE" {{ $Country_code == "PE" ? 'selected' : '' }}>Peru</option>
                    <option value="PH" {{ $Country_code == "PH" ? 'selected' : '' }}>Philippines</option>
                    <option value="PN" {{ $Country_code == "PN" ? 'selected' : '' }}>Pitcairn</option>
                    <option value="PL" {{ $Country_code == "PL" ? 'selected' : '' }}>Poland</option>
                    <option value="PT" {{ $Country_code == "PT" ? 'selected' : '' }}>Portugal</option>
                    <option value="PR" {{ $Country_code == "PR" ? 'selected' : '' }}>Puerto Rico</option>
                    <option value="QA" {{ $Country_code == "QA" ? 'selected' : '' }}>Qatar</option>
                    <option value="CG" {{ $Country_code == "CG" ? 'selected' : '' }}>Republic of the Congo</option>
                    <option value="RE" {{ $Country_code == "RE" ? 'selected' : '' }}>Reunion</option>
                    <option value="RO" {{ $Country_code == "RO" ? 'selected' : '' }}>Romania</option>
                    <option value="RU" {{ $Country_code == "RU" ? 'selected' : '' }}>Russian Federation</option>
                    <option value="RW" {{ $Country_code == "RW" ? 'selected' : '' }}>Rwanda</option>
                    <option value="BL" {{ $Country_code == "BL" ? 'selected' : '' }}>Saint Barthélemy</option>
                    <option value="SH" {{ $Country_code == "SH" ? 'selected' : '' }}>Saint Helena</option>
                    <option value="KN" {{ $Country_code == "KN" ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                    <option value="LC" {{ $Country_code == "LC" ? 'selected' : '' }}>Saint Lucia</option>
                    <option value="MF" {{ $Country_code == "MF" ? 'selected' : '' }}>Saint Martin (French part)</option>
                    <option value="PM" {{ $Country_code == "PM" ? 'selected' : '' }}>Saint Pierre and Miquelon</option>
                    <option value="VC" {{ $Country_code == "VC" ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
                    <option value="WS" {{ $Country_code == "WS" ? 'selected' : '' }}>Samoa</option>
                    <option value="SM" {{ $Country_code == "SM" ? 'selected' : '' }}>San Marino</option>
                    <option value="ST" {{ $Country_code == "ST" ? 'selected' : '' }}>Sao Tome and Principe</option>
                    <option value="SA" {{ $Country_code == "SA" ? 'selected' : '' }}>Saudi Arabia</option>
                    <option value="SN" {{ $Country_code == "SN" ? 'selected' : '' }}>Senegal</option>
                    <option value="RS" {{ $Country_code == "RS" ? 'selected' : '' }}>Serbia</option>
                    <option value="SC" {{ $Country_code == "SC" ? 'selected' : '' }}>Seychelles</option>
                    <option value="SL" {{ $Country_code == "SL" ? 'selected' : '' }}>Sierra Leone</option>
                    <option value="SG" {{ $Country_code == "SG" ? 'selected' : '' }}>Singapore</option>
                    <option value="SX" {{ $Country_code == "SX" ? 'selected' : '' }}>Sint Maarten (Dutch part)</option>
                    <option value="SK" {{ $Country_code == "SK" ? 'selected' : '' }}>Slovakia</option>
                    <option value="SI" {{ $Country_code == "SI" ? 'selected' : '' }}>Slovenia</option>
                    <option value="SB" {{ $Country_code == "SB" ? 'selected' : '' }}>Solomon Islands</option>
                    <option value="SO" {{ $Country_code == "SO" ? 'selected' : '' }}>Somalia</option>
                    <option value="ZA" {{ $Country_code == "ZA" ? 'selected' : '' }}>South Africa</option>
                    <option value="GS" {{ $Country_code == "GS" ? 'selected' : '' }}>South Georgia and the South Sandwich Islands</option>
                    <option value="KR" {{ $Country_code == "KR" ? 'selected' : '' }}>South Korea</option>
                    <option value="SS" {{ $Country_code == "SS" ? 'selected' : '' }}>South Sudan</option>
                    <option value="ES" {{ $Country_code == "ES" ? 'selected' : '' }}>Spain</option>
                    <option value="LK" {{ $Country_code == "LK" ? 'selected' : '' }}>Sri Lanka</option>
                    <option value="SD" {{ $Country_code == "SD" ? 'selected' : '' }}>Sudan</option>
                    <option value="SR" {{ $Country_code == "SR" ? 'selected' : '' }}>Suriname</option>
                    <option value="SJ" {{ $Country_code == "SJ" ? 'selected' : '' }}>Svalbard and Jan Mayen</option>
                    <option value="SE" {{ $Country_code == "SE" ? 'selected' : '' }}>Sweden</option>
                    <option value="CH" {{ $Country_code == "CH" ? 'selected' : '' }}>Switzerland</option>
                    <option value="SY" {{ $Country_code == "SY" ? 'selected' : '' }}>Syrian Arab Republic</option>
                    <option value="TW" {{ $Country_code == "TW" ? 'selected' : '' }}>Taiwan, Province of China</option>
                    <option value="TJ" {{ $Country_code == "TJ" ? 'selected' : '' }}>Tajikistan</option>
                    <option value="TZ" {{ $Country_code == "TZ" ? 'selected' : '' }}>United Republic of Tanzania</option>
                    <option value="TH" {{ $Country_code == "TH" ? 'selected' : '' }}>Thailand</option>
                    <option value="MK" {{ $Country_code == "MK" ? 'selected' : '' }}>The Republic of North Macedonia</option>
                    <option value="TL" {{ $Country_code == "TL" ? 'selected' : '' }}>Timor-Leste</option>
                    <option value="TG" {{ $Country_code == "TG" ? 'selected' : '' }}>Togo</option>
                    <option value="TK" {{ $Country_code == "TK" ? 'selected' : '' }}>Tokelau</option>
                    <option value="TO" {{ $Country_code == "TO" ? 'selected' : '' }}>Tonga</option>
                    <option value="TT" {{ $Country_code == "TT" ? 'selected' : '' }}>Trinidad and Tobago</option>
                    <option value="TN" {{ $Country_code == "TN" ? 'selected' : '' }}>Tunisia</option>
                    <option value="TR" {{ $Country_code == "TR" ? 'selected' : '' }}>Türkiye</option>
                    <option value="TM" {{ $Country_code == "TM" ? 'selected' : '' }}>Turkmenistan</option>
                    <option value="TC" {{ $Country_code == "TC" ? 'selected' : '' }}>Turks and Caicos Islands</option>
                    <option value="TV" {{ $Country_code == "TV" ? 'selected' : '' }}>Tuvalu</option>
                    <option value="UG" {{ $Country_code == "UG" ? 'selected' : '' }}>Uganda</option>
                    <option value="UA" {{ $Country_code == "UA" ? 'selected' : '' }}>Ukraine</option>
                    <option value="AE" {{ $Country_code == "AE" ? 'selected' : '' }}>United Arab Emirates</option>
                    <option value="GB" {{ $Country_code == "GB" ? 'selected' : '' }}>United Kingdom</option>
                    <option value="US" {{ $Country_code == "US" ? 'selected' : '' }}>United States of America</option>
                    <option value="UM" {{ $Country_code == "UM" ? 'selected' : '' }}>United States Minor Outlying Islands</option>
                    <option value="UY" {{ $Country_code == "UY" ? 'selected' : '' }}>Uruguay</option>
                    <option value="UZ" {{ $Country_code == "UZ" ? 'selected' : '' }}>Uzbekistan</option>
                    <option value="VU" {{ $Country_code == "VU" ? 'selected' : '' }}>Vanuatu</option>
                    <option value="VE" {{ $Country_code == "VE" ? 'selected' : '' }}>Venezuela</option>
                    <option value="VN" {{ $Country_code == "VN" ? 'selected' : '' }}>Vietnam</option>
                    <option value="VG" {{ $Country_code == "VG" ? 'selected' : '' }}>Virgin Islands, British</option>
                    <option value="VI" {{ $Country_code == "VI" ? 'selected' : '' }}>Virgin Islands, U.S.</option>
                    <option value="WF" {{ $Country_code == "WF" ? 'selected' : '' }}>Wallis and Futuna</option>
                    <option value="EH" {{ $Country_code == "EH" ? 'selected' : '' }}>Western Sahara</option>
                    <option value="YE" {{ $Country_code == "YE" ? 'selected' : '' }}>Yemen</option>
                    <option value="ZM" {{ $Country_code == "ZM" ? 'selected' : '' }}>Zambia</option>
                    <option value="ZW" {{ $Country_code == "ZW" ? 'selected' : '' }}>Zimbabwe</option>
                </select>

                <div class="row">
                    <div class="col">
                        <label class="form-label"> First Name <span class="text-red-500">&nbsp;*</span> </label>
                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ ($user_details->username) }}" readonly required>
                    </div>
                    <div class="col">
                        <label class="form-label">Last Name <span class="text-red-500">&nbsp;*</span> </label>
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">Zip/Postal Code <span class="text-red-500">&nbsp;*</span> </label>
                        <input type="text" class="form-control" name="postal_code" placeholder="Zip/Postal" required  >
                    </div>
                </div>
            </div>

            <input type="hidden" name="plan_code"  value="{{ $plan_details->getcode() }}">
            <input type="hidden" name="getCurrencies"  value="{{ $plan_details->getCurrencies()[0]->getcurrency() }}">


            
            <button type="submit" class="btn-block">Pay now</button>
        </form>

        <div class="order-summary mt-4 mb-5">
            <div class="flex font-medium items-end lg:flex-wrap">
                <h5 class="flex-auto lg:text-xl">Order Summary</h5>
                <div class="flex-none lg:basis-full lg:mt-7 mt-3 mb-3">
                    <h3 class="lg:text-3xl" style="font-weight:500 !important"> {{ $plan_details->getCurrencies()[0]->getUnitAmount() }}
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
                            <div class="flex-none font-bold"> {{ $plan_details->getCurrencies()[0]->getUnitAmount() ." ". $plan_details->getCurrencies()[0]->getcurrency()  .'/'. $plan_details->getIntervalunit() }}</div>
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
                    <div> {{ $plan_details->getCurrencies()[0]->getUnitAmount() ." ".$plan_details->getCurrencies()[0]->getcurrency() }}</div>
                </div>

                {{-- <div class="coupons-card">
                    <label class="col-span-4 add-gift" style="color: rgb(91 38 102) !important; cursor: pointer;">Add
                        gift card or promo code</label>
                </div> --}}
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
                        <span class="font-medium">{{  $plan_details->getCurrencies()[0]->getUnitAmount() ." ". $plan_details->getCurrencies()[0]->getcurrency() }}</span>
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

    const cardNumberInput = document.getElementById('cardNumber');

    cardNumberInput.addEventListener('input', (event) => {

        let value = event.target.value.replace(/\D/g, '');
        if (value.length > 16) {
            value = value.substring(0, 16);
        }
        value = value.match(/.{1,4}/g)?.join('-') ?? value;
        event.target.value = value;

    });

    const expmonthInput = document.getElementById('exp_month');

    expmonthInput.addEventListener('input', (event) => {
        let value = event.target.value.replace(/\D/g, '');
        
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }

        if (value.length > 7) {
            value = value.substring(0, 7);
        }

        event.target.value = value;
    });


    // recurly.configure('ewr1-vqBCG3NdYAcm94MqtiVWlb');

    // const elements = recurly.Elements();

    // const cardElement = elements.CardElement({
    //     inputType: 'mobileSelect',
    //     style: {
    //         fontSize: '1em',
    //         placeholder: {
    //             color: 'gray !important',
    //             fontWeight: 'normal',
    //             displayIcon: 'true',
    //             content: {
    //                 number: 'Card number',
    //                 cvv: 'CVC',
    //                 expiry: 'MM / YY'
    //             }
    //         },
    //         invalid: {
    //             fontColor: 'red'
    //         }
    //     }
    // });
    // cardElement.attach('#recurly-elements');

   
</script>

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
