@extends('layouts.app')
@include('/header')

<style>

#ck-button {
    margin:4px;
/*    background-color:#EFEFEF;*/
    border-radius:4px;
/*    border:1px solid #D0D0D0;*/
    overflow:auto;
    float:left;
}

#ck-button label {
    float:left;
    width:4.0em;
}

#ck-button label span {
    text-align:center;
   
    display:block;
  
    color: #fff;
    background-color: #3daae0;
    border: 1px solid #3daae0;
    padding: 0;
}

#ck-button label input {
    position:absolute;
/*    top:-20px;*/
}

#ck-button input:checked + span {
    background-color:#3daae0;
    color:#fff;
}

</style>

@section('content')




<div class="row" id="signup-form">
    
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay">
            <div class="panel-heading">

              <div class="row nomargin text-center">

                    <h1 class="panel-title">Enter your Info below to signup for an account.</h1>
                  
              </div>
            </div>
          <form action="<?php echo URL::to('/').'/register1';?>" method="POST" id="payment-form" enctype="multipart/form-data">
                    <div class="panel-body">
<!--
                           <div class="form-group row">
                                <label class="col-md-4 control-label" for="username">Username</label>

                                <div class="col-md-8">
                                  <input type="text" class="form-control" id="username" name="username" value="<?= old('username'); ?>" required="" />
                                </div>
                            </div> 
-->
                    @csrf
                        <?php $username_error = $errors->first('name'); ?>
                        <?php if (!empty($errors) && !empty($username_error)): ?>
                            <div class="alert alert-danger"><?= $errors->first('name'); ?></div>
                        <?php endif; ?>
                        <?php $email_error = $errors->first('email'); ?>
                        <?php if (!empty($errors) && !empty($email_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('email'); ?></div>
                        <?php endif; ?>
                        <?php $password_error = $errors->first('password'); ?>
                        <?php if (!empty($errors) && !empty($password_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('password'); ?></div>
                        <?php endif; ?>
                        <?php $confirm_password_error = $errors->first('password_confirmation'); ?>
                        <?php if (!empty($errors) && !empty($confirm_password_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('password_confirmation'); ?></div>
                        <?php endif; ?>
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>
                                <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ session()->get('register.name') }}">
                                </div>
                        </div>
                        <div class="form-group row">
                            
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"  value="{{ session()->get('register.email') }}" required autocomplete="email">
                                </div>
                        </div> 
                                     
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Desired Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" value="{{ session()->get('register.password') }}" required autocomplete="email">
                                    </div>
                            </div> 

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ session()->get('register.password_confirmation') }}" required autocomplete="email">
                                    </div>
                            </div>
                                     
<!--                            <button type="submit" class="btn btn-primary">Continue</button>-->
                          <div class="pull-right sign-up-buttons">
                            <button class="btn btn-primary" type="submit" name="create-account">Sign Up Today </button>
                              <span> Or </span>
                            <a href="/login" class="btn">Log In</a>
                          </div>
              </div>
                        </form>
                        
                    </div>
        
         </div>
         </div>
    


@endsection 
