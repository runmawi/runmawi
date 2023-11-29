@php
include(public_path('themes/theme4/views/header.php'));
$settings = App\Setting::first(); 
@endphp


<style>

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    /* height: 100vh; */
}

.registration-form {
    background-color: #fff;
    padding: 50px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
}

button {
    background-color: #0074d9;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 3px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

</style>
<section>
<div class="container">
        <div class="registration-form">
            <p>{{ __('Register a Device') }}</p>
            <form action="{{ URL::to('device/store-code') }}" method="post">

            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                <!-- <div class="form-group">
                    <label for="device-name">Device Name</label>
                    <input type="text" id="device-name" name="device-name" required>
                </div> -->
                <div class="form-group">
                    <label for="device-type">{{ __('Device Type') }}</label>
                    <select id="device_type" name="device_type" required>
                        <option value="smart-tv">{{ __('Smart TV') }}</option>
                        <option value="fire-stick">{{ __('Fire Stick') }}</option>
                        <option value="andriod-tv">{{ __('Andriod TV') }}</option>
                        <option value="lg-tv">{{ __('Lg TV') }}</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="device-serial">{{ __('Device Code Number') }}</label>
                    <input type="text" id="device_code" name="device_code" required>
                </div>
                <div class="form-group">
                    <button type="submit">{{ __('Register Device') }}</button>
                </div>
            </form>
        </div>
    </div>

</section>
@php
include(public_path('themes/theme4/views/footer.blade.php'));
@endphp

