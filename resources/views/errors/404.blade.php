@include('/header')
    <div class="container" style="height: 450px;text-align: center;">
      <div class="h-100 row align-items-center" style="height:500px!important;">
        <div class="col">
          <h1 class="m-0">404</h1><br>
              <h6>Page not found - <?php $settings = App\Setting::first(); echo $settings->website_name;?></h6><br>
              <h6><a href="{{URL::to('/')}}">Click Here</a> to go Home</h6>
        </div>
      </div>
    </div>
@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp