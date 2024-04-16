@extends('layouts.app')
<?php include(public_path('themes/theme7/views/header.php')); ?>
@extends('multiprofile.style')


@section('content')
<div class="container">
    <div class="row  align-items-center height-self-center">
        <div class="col-lg-3  col-12">
        </div>
        <div class="col-lg-5 col-12 col-md-12 align-self-center">

            <div class="sign-user_card ">                    
                <div class="sign-in-page-data">
                    <div class="sign-in-from  m-auto" align="center">
                        <div align="center">
                      </div>
                      
                        <form method="POST" action="{{ route('Choose-profile.store') }}" class="mt-4" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <h4> {{ __('New Profile') }}</h4>
                            </div>

                            <div class="form-group">  
                                <img src="{{URL::asset('public/multiprofile/chooseimage.jpg')}}" id="upfile1"  />
                                     <p class="" style="color:#fff "  style="cursor:pointer" id="upfile"  >{{ __('Change') }}</p>
                                <input type="file" id="subuser_image"  name="image" style="display:none"  />
                            </div>
  
                            <div class="form-group">  
                                <input id="subuser_name" type="text" class="form-control" name="name" placeholder="{{ __('Enter Name') }}" value="" required autocomplete="" autofocus>
                            </div>

                            <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                             <h5 style="text-align: left"> {{ __("kid's profile ?") }}</h5>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="switch">
                                            <div class="form-group">
                                                 <input type="checkbox" name="user_type" >
                                                  <span class="slider round"></span>
                                            </div>
                                        </label>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                         <p align="left" class="kid">{{ __('TV shows and movies for ages 12 and under') }} <br>
                                             <a class="learn_more" href="">{{ __('Learn More') }} </a> 
                                         </p>
                                </div>
                            </div>   
                        </div>

                        <div class="row sumbit_btn">
                            <a href="{{ url('choose-profile') }}"><button type="button"  class="btn btn-hover ab">{{ __('Cancel') }}</button></a>
                            <button type="submit" class="btn btn-hover ab" >{{ __('Save Changes') }}</button>
                        </div>

                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php include(public_path('themes/theme7/views/footer.blade.php'));  ?>

@endsection 

<script>

$( document ).ready(function() {
    $("#upfile").click(function () {
    $("#subuser_image").trigger('click');
});
});

</script>

