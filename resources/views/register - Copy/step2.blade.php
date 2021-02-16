@extends('layouts.app')

@section('content')
@include('/header')

<style>
* {
  box-sizing: border-box;
}

.columns {
  float: left;
  width: 25%;
  padding: 8px;
}

.price {
  list-style-type: none;
  
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.price .header {
    background-color: #111;
    color: white;
    font-size: 20px;
}

.price li {
 
  padding: 20px;
  text-align: center;
}

.price .grey {
  background-color: #eee;
  font-size: 20px;
}

.button {
  background-color: #ccb209;
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
}
    .plan-block {
        margin-top: 20px;
    }

@media only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
</style>



<div class="container">
    
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
?>
    <div class="row justify-content-center" id="signup-form">
         
                  
        <div class="col-md-10 col-sm-offset-1">
			<div class="login-block">
				<a class="login-logo" href="<?php echo URL::to('/');?>">
                    <?php
                    $settings = App\Setting::find(1);
                    ?>
                    
                    <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
                </a>
            
                 <!-- <div class="panel-heading"><h1></h1></div>-->

<div class="panel-body">
   
    <h2>Our Plans</h2>
    
    <?php 
        $plans = App\Plan::all();
           foreach($plans as $plan) {
        ?>
            <div class="columns">
              <ul class="price">
                <li class="header"><?php echo $plan->plans_name;?></li>
                <li class=""><a href="#" class="button"><?php echo "$".$plan->price;?></a></li>
              </ul>
            </div>
       <?php } ?>
              
     <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register2?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register2'; } ?>" method="POST" id="payment-form" enctype="multipart/form-data">
        @csrf
        
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
         <div class="form-group row">
            <label for="plan_name" class="col-md-4 col-sm-offset-1 col-form-label text-md-right plan-block">{{ __('Choose a Plan') }}</label>
                <div class="col-md-6  plan-block" >
                <select name="plan_name" id="plan_name"  class="form-control" style="margin-top: 0;">
                    <?php 
                        $plans = App\Plan::all();
                        foreach($plans as $plan) {
                    ?>
                        <option value="<?php echo $plan->plan_id;?>"><?php echo $plan->plans_name;?></option>
                    <?php } ?>
                    </select>
                </div>
         </div>
         
         <div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
							<div class="pull-right sign-up-buttons">
							  <button class="btn btn-primary btn-login" type="submit" name="create-account">{{ __('Pay Now') }}</button>
							  <span>Or</span>
							   <a type="button" href="<?php echo URL::to('/').'/registerUser';?>" class="btn btn-warning"><?php echo __('Skip');?></a>
							</div>
							</div>
         </div>
         
<!--
        
          <div class="form-group row">
             
                <div class="pull-right sign-up-buttons">
                <button class="btn btn-primary" type="submit" name="create-account">Sign Up Today </button>
                            <span> Or </span>           
                <a type="button" href="<php echo URL::to('/').'/registerUser';?>" class="btn btn-warning">Skip</a>
                </div>
            </div> 
-->
        </form>
         
         
         </div>
    </div>
</div>
    </div>
</div>

<!--


<div class="container">
    <div class="row justify-content-center">	
    <h1>Step 1</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
     
        
    <form action="<php echo URL::to('/').'/registerUser';?>" method="POST">
        @csrf
        <input type="hidden" name="email" class="form-controll" placeholder="Enter email" value="{{ session()->get('register.email') }}">
        <input type="hidden" name="name" class="form-controll" placeholder="Enter email" value="{{ session()->get('register.name') }}">
        <input type="hidden" name="password" class="form-controll" placeholder="Enter email" value="{{ session()->get('register.password') }}">
        
        <button type="submit" class="btn btn-primary">Skip </button>
     </form>
        
    </div>
</div>
-->
@include('footer')
@endsection 