@include('/header')
    <div class="container" style="height: 450px;text-align: center;">
      <div class="h-100 row align-items-center">
        <div class="col">
          <h1 class="m-0">404</h1><br>
              <h6>Page not found - Flicknexs</h6><br>
              <h6><a href="{{URL::to('/')}}">Click Here</a> to go Home</h6>
        </div>
      </div>
    </div>
@include('footer')