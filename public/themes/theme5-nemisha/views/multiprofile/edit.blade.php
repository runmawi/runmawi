@extends('layouts.app')
<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/variable.css';?>" />
    <!-- Style -->
      <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/style.css') ?>" rel="stylesheet">
       <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/typography.css') ?>" rel="stylesheet">
       <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/responsive.css') ?>" rel="stylesheet">
              <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css') ?>" rel="stylesheet">

     

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@extends('multiprofile.style')

<style>
    #mySidebar{
        display: none !important;
    }
    body{
        background: #000!important;
    }
    .btn-success {
    background: #ED553B!important;
    border: 1px solid #ED553B;
}
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center  align-items-center height-self-center">
       
        <div class="col-lg-4 col-12 col-md-12 align-self-center">

            <div class="sign-user_card ">                    
                <div class="sign-in-page-data">
                    <div class="sign-in-from  m-auto" align="center">
                        <div align="center">
                      </div>
                        <form method="POST" action="{{ route('Choose-profile.update', $multiprofile->id)}}" class="mt-4" autocomplete="off" enctype="multipart/form-data">
                            @method('PATCH')  
                            @csrf
                            <div class="form-group">
                                <h4> Edit Profile</h4>
                            </div>

                            <div class="form-group">  
                                <img src="{{URL::asset('public/multiprofile/').'/'.$multiprofile->Profile_Image}}" id="upfile1"  />
                                     <p class="" style="color:#fff "  style="cursor:pointer" id="upfile"  >Change</p>
                                <input type="file" id="subuser_image"  name="image" style="display:none"  />
                            </div>
                            

                            <div class="form-group">  
                                <input id="subuser_name" type="text" class="form-control" name="name" placeholder="{{ __('Enter Name') }}" value="{{ $multiprofile->user_name }}" required autocomplete="" autofocus>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                         <h5 style="text-align: left"> Kids Profile ?</h5>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="switch">
                                        <div class="form-group">
                                             <input type="checkbox" name="user_type" @if($multiprofile->user_type == "Kids") checked  @endif value="{{ $multiprofile->user_type == "Kids" ? 'Kids' :'Normal' }}" >
                                              <span class="slider round"></span>
                                        </div>
                                    </label>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                     <p align="left" class="kid">TV shows and movies for ages 12 and under <br>
                                       
                                     </p>
                            </div>
                        </div>   
                    </div>

                    <div class="row sumbit_btn">
                        <a href="{{ url('choose-profile') }}"><button type="button"  class="btn btn-hover ab">{{ __('Cancel') }}</button></a>
                        <button type="submit" class="btn btn-success ml-2" >Save Changes</button>
                    </div>

                    </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php include(public_path('themes/theme5-nemisha/views/footer.blade.php'));  ?>

@endsection 

<script>

    $( document ).ready(function() {
        $("#upfile").click(function () {
        $("#subuser_image").trigger('click');
         });
    });
    
</script>

