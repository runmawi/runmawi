
<!-- Pop-up Video page -->

<div class="modal fade pop_up_register_user" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:100%!important;">
      <div class="modal-content" style="background-image:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>')!important;border:none;">
        <div class="modal-header" style="border-bottom:none!important;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="border:none!important;">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="text-center">
                    <img class="img__img " src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid" width="200" alt="" >
                <h4>please subscribe to watch</h4>
            </div>
                </div>
                <div class="col-lg-8">
                    <div class="text-center">
                        <h2>PICK YOUR PLAN</h2>
                    <p class="text-white">Change Plans Anytime</p>
                    </div>
                <table class="table table-striped table-dark" style="width:100%;">
  <thead>
    <tr>
     
      <th scope="col"></th>
      <th scope="col">Free <br> <p class="flk mb-0">Ads</p><button type="button" class="btn btn-warning pay">Watch Now</button>
</th>
      <th scope="col">Premium<br> <p class="flk mb-0">Limited Ads</p><button type="button" class="btn btn-primary pay">$ 154/month</button>
</th>
      <th scope="col">Pro+<br> <p class="flk mb-0">Ads Free</p><button type="button" class="btn btn-primary pay">$ 384/month</button>
</th>
    </tr>
  </thead>
  <tbody>
    <tr>
     
      <td>Watch 40,000+ hours of hit movies,TV shows, and more.</td>
      <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
       <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
         <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
    </tr>
    <tr>
      <td>All Content Movies, Live sports,TV, Special Shows</td>
       <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
         <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
         <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
    </tr>
    <tr>
      <td>Number of devices that can be logged in.</td>
       <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
      <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
          <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
    </tr>
      <tr>
      <td>All our live sports and events, including Premier League, WWE, Sunday Night Football, and MLB Sunday Leadoff</td>
      <td></td>
      <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
           <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
    </tr>
      <tr>
      <td>Download and watch select titles offline.</td>
      <td></td>
       <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
            <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
    </tr>
       <tr>
      <td>Enjoy 50+ alway-on channels</td>
      <td></td>
      <td></td>
           <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
    </tr>
      <tr>
      <td>Watch ad-free.*</td>
      <td></td>
      <td></td>
           <td class="text-center"><i class="fa fa-check" aria-hidden="true"></i></td>
    </tr>
  </tbody>
</table>
<div class="row">
    <div class="col-lg-4">
        <h5>Basic Plan</h5>
    </div>
    <div class="col-lg-4">
        <h5>VIP Plan</h5>
    </div>
    <div class="col-lg-4">
        <h5>Premium Plan</h5>
    </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!--<div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>-->
      </div>
    </div>
  </div>

<script>
  $(document).ready(function(){
      $(".pop_up_register_user").click(function(){
        $('#exampleModal').modal('show');
      });
  });
</script>