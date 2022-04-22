@extends('admin.master')
<style>
    .form-control {
    background: #fff!important; */
   
}
</style>
@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-lg-4">
                  <div class="iq-card iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header">
                        <div class="iq-header-title">
                           <h4 class="card-title text-center" style="color: #4295D2;">User's Of {{ GetWebsiteName() }}</h4>
                        </div>
                     </div>
                        <div>
                            <p><h2>Your Package has been Expired !</h2></p>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                  <div class="iq-card iq-card iq-card-block">
                        <div>
                            <p><h2>Please Click here to Purchase/Upgrade Your Package..</h2></p>
                            <a href="#">Buy Now</a>
                        </div>
                </div>
            </div>

    </div>

@stop