@php
    $Theme = \App\HomeSetting::pluck('theme_choosen')->first();

    $header_url = 'themes/'.$Theme.'/views/header.php';
    $footer_url = 'themes/'.$Theme.'/views/footer.blade.php'; 

    include(public_path($header_url));
@endphp

    <div class="container" style="height: 450px;text-align: center;">
      <div class="h-100 row align-items-center" style="height:500px!important;">
        <div class="col">
          <h1 class="m-0">404</h1><br>
              <h6>Page not found - <?= GetWebsiteName() ?></h6><br>
              <h6><a href="{{URL::to('/')}}">Click Here to go Home</a> </h6>
        </div>
      </div>
    </div>
    
@php
    include(public_path($footer_url));
@endphp