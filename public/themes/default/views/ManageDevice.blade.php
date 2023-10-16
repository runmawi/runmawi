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
    <h1>Manage Login Devices</h1>

  <div class="card">
    <div class="card-content ">
      <p>Register Another Device</p>

      Register Your Device for the best experience and access to platform.

      <div class="pull-right">
        <a href="{{ URL::to('register-new-devices') }}">
        <button type="button" class="btn btn-default">Register New Device</button></a>
      </div>
    </div>
    
    <div class="card-content ">
      @foreach($devices as $key => $value)

      <p>{{ @$value->tv_name  }}</p>

      <div class="text-info">
        Date of registration : {{  date('M d, Y', strtotime($value->created_at)) }}.
      </div>
      
      <div class="pull-right">
        <a href="{{ URL::to('/device/deregister').'/'.$value->id }}"><button type="button" class="btn btn-danger">Deregister</button></a>
      </div>
      @endforeach
    </div>

</div>

</section>
@php
include(public_path('themes/default/views/footer.blade.php'));
@endphp

