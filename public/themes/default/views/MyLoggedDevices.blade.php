@php
include(public_path('themes/default/views/header.php'));
$settings = App\Setting::first(); 
@endphp


<style>


/** COMPONENTS **/

.card {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  height: 100vh;
  display: flex;
}

.card-content {
  padding: 24px;
}

.card-content + .card-content {
  border-top: 1px solid #ddd;
}


.clearfix::after {
  display: block;
  content: "";
  clear: both;
}

a {
  color: #0087c3;
  text-decoration: none;
}
/* .container {
    display: flex;
    justify-content: center;
    align-items: center;
    
} */

</style>
<section>
<div class="container">
    <h1>{{ __('Manage Login Devices') }} </h1>

  <div class="card">
    <!-- <div class="card-content ">
      <p>{{ __('Register Another Device') }}</p>

      {{ __('Register Your Device for the best experience and access to platform') }}.

      <div class="pull-right">
        <a href="{{ URL::to('register-new-devices') }}">
        <button type="button" class="btn btn-default">{{ __('Register New Device') }}</button></a>
      </div>
    </div> -->
    @if (Session::has('message'))
        <div id="successMessage" class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    

    @if(count($errors) > 0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-danger display-hide" id="successMessage" >
                <button id="successMessage" class="close" data-close="alert"></button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif

    <div class="card-content ">
    <table class="w-100">
        <thead>
          <tr class="text-center">
            <th>{{ __('Device Name') }}</th>
            <th>{{ __('Date of Logged In') }}</th>
            <th>{{ __('Action') }}</th>
          </tr>
        </thead>
        <tbody class="text-center">
          @foreach($MyLoggedDevices['alldevices_register'] as $key => $value)
          <tr>
            <td>{{ @$value->device_name }}</td>
            <td>{{ date('M d, Y', strtotime($value->created_at)) }}</td>
            <td>
              <a href="{{ URL::to('/my-logged-devices-delete').'/'.$value->id }}">
                <button type="button" class="btn btn-danger">{{ __('Deregister') }}</button>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
</div>

</div>

</section>

<script>

$(document).ready(function(){
    // $('#message').fadeOut(120);
    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 5000);
})
</script>
@php
include(public_path('themes/default/views/footer.blade.php'));
@endphp

