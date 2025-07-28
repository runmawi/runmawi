@extends('layouts.app')
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
   
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css') ?>" rel="stylesheet">
        <title> {{ $Website_name ? $Website_name->website_name : 'Website Name' }} </title>
    <style>
        li{list-style:none;}
        body{background: #000;padding: 20px;vertical-align: middle;height: 100%;}
        .login-success {border: 2px solid black;width: 20%;height: 50px;font-size: 18px;font-weight: 600;background: #ed1c24;align-items: center;float: inline-end;justify-content: center;}
    </style>
</head>
<div class="message">
    <div class="login-success d-flex">
        <span style="color: #ffffff ">Logged in successfully !</span>
    </div>
</div>

@section('content')
<div class="container">
    <div class="row justify-content-center">
       
  
                 

    <div class="col-md-5">
        <div class="row1">
    <h1 class="mt-5">Who's Watching ?</h1>
            <p class="text-center">You can setup up to {{ $multiuser_limit }} profiles for your <br> family or friends</p>
                    <div class="row-data row justify-content-center align-items-center"  >
                      
                    
                        <div class="member col-md-4">
                            <a  href="{{ route('home')}}">
                                <img src="{{URL::asset('public/multiprofile/chooseimage.jpg')}}" alt="user" class="multiuser_img" width="120">
                            </a> 

                            <div class="name text-center">{{ $subcriber_user ? $subcriber_user->username : ''  }}</div>
                        </div>

                            @foreach ($users as $profile)
                                <div class="member col-md-4">
                                    <a  href="{{ route('subuser', $profile->id)}}">
                                        <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                                    </a> 
                                    <div class="dk">
                                         <div class="name text-center">{{ $profile ? $profile->user_name : ''  }}</div>
                                    <div class="circle">
                                            <a class="fa fa-edit" href="{{ route('Choose-profile.edit', $profile->id)}}"></a>
                                    </div>

                                   </div>
                                </div>
                            @endforeach  
                            <div class="col-md-3">
                            @if ($sub_user_count < $multiuser_limit)
                                 
                                    <a class="fa fa-plus-circle fa-100x" href="{{route('Choose-profile.create') }}"></a>
                               
                            @endif 
                          </div>
                    </div>
                </div>
        </div>
    </div>


 @endsection
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script>
    setTimeout(() => {
        document.querySelector('.message').style.display = 'none';
    }, 3000);
</script>

 <style>
     .row1{
       background: linear-gradient(180deg, rgba(21, 30, 41, 0.85) 0%, rgba(21, 63, 95, 1) 100%);
mix-blend-mode: hard-light;
border-radius: 10px;
         border-radius:30px;
         padding: 20px;   

     }
     .row1 h1{
         text-align: center;
          color: white;
         font-family: 'futuramedium';

      
     }
     h2{
        text-align: center;
     
       
        color: white;
     }
     .multiuser_img{
        padding: 10px;
        transition: 0.3s;
         border-radius: 20px;
         background: rgba(196, 196, 196, 0.2);

        
     }
     .multiuser_img:hover {
         background: rgba(196, 196, 196, 0.2);
border-radius: 30px;

        -ms-transform: scale(1.1); /* IE 9 */
        -webkit-transform: scale(1.1); /* Safari 3-8 */
        transform: scale(1.1); 
    }
    ul#top-menu {
    display: none;
    }
    .navbar-right.menu-right {
        display: none;
    }
    .member {
       /* float:left;
       
        margin:4%;
        margin-top: -10%;*/
        padding: 15px;
    }
    .name{
font-family: 'futuralight';
        font-size: larger;
     
        color: white;
        text-align: center;
    }
    .sign-in-from {
/*    padding: 20%;*/
    /* background-image: linear-gradient( rgb(10 10 10 / 50%), rgb(0 0 0 / 50%)  ), 
    background-image: linear-gradient( rgb(10 10 10 / 100%), rgb(0 0 0 / 100%)  ),
   /* url(public/uploads/avatars/Movies.jpg);  
        url("{{ $screen }}") ;*/
        background-color: rgb(14 14 14);
        background-repeat: no-repeat;
        background-size: cover;
      
}
.fa-plus-circle:before {
    color: white;
    font-size: 25px;
}
a.fa.fa-plus-circle.fa-10x {
    margin-top: 20%;
    display: none;
}
html.js-focus-visible {
    background: #141414;
}
.circle{
    color: white;
   
   
    font-size: 20px;
    text-align: center;
}
a.fa.fa-edit {
    color: white;
}
     .fa-plus-circle{
         text-decoration: none!important;
     }
     .dk{
         display: flex;
    justify-content: space-around;
    align-items: center;
   
     }
     p{
     font-family: 'futuralight';  
font-style: normal;
font-weight: 400;
font-size: 15px;
line-height: 20px;
/* or 154% */


text-align: center;

color: #FFFFFF;

     }
     a{
        text-decoration: none!important;  
     }
     @media (max-width: 768px) {
    
 .row-data{
    flex-wrap: wrap!important;
}
    } 
 </style>

