@extends('layouts.app')
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title> {{ $Website_name ? $Website_name->website_name : 'Website Name' }} </title>
    <style>
        li{        list-style:none;}

    </style>
</head>
      
@section('content')
<div class="container">
    <div class="row  align-items-center ">
        <div class="col-md-12 align-items-center">

                    <div class="sign-in-from  m-auto" >

                    <div class="row data" style="display:flex;justify-content: space-evenly;">

                    
                        <div class="member ">
                            <a  href="{{ route('home')}}">
                                <img src="{{URL::asset('public/multiprofile/chooseimage.jpg')}}" alt="user" class="multiuser_img" style="width:120px">
                            </a> 

                            <div class="name text-center">{{ $subcriber_user ? $subcriber_user->username : ''  }}</div>
                        </div>

                            @foreach ($users as $profile)
                                <div class="member">
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
                            
                            <li> 
                                <a class="fa fa-plus-circle fa-10x" href="{{route('Choose-profile.create') }}"></a>
                            </li> 
                    </div>
                </div>
        </div>
    </div>
</div>

 @endsection

 <style>

     h2{
        text-align: center;
        font-family: auto;
        font-family: cursive;
        color: white;
     }
     .multiuser_img{
        width: 120px;
        border-radius: 50;
        border-radius: 50%;
        padding: 5px;
        border: 5px solid #9f9191
     }
     .multiuser_img:hover {
        -ms-transform: scale(1.5); /* IE 9 */
        -webkit-transform: scale(1.5); /* Safari 3-8 */
        transform: scale(1.5); 
    }
    ul#top-menu {
    display: none;
    }
    .navbar-right.menu-right {
        display: none;
    }
    .member {
        float:left;
       
        margin:4%;
        margin-top: -10%;
    }
    .name{
        margin-top: 1rem;
        font-size: larger;
        font-family: auto;
        color: white;
        text-align: center;
    }
    .sign-in-from {
    padding: 22%;
    /* background-image: linear-gradient( rgb(10 10 10 / 50%), rgb(0 0 0 / 50%)  ), */
    background-image: linear-gradient( rgb(10 10 10 / 50%), rgb(0 0 0 / 50%)  ),
   /* url(public/uploads/avatars/Movies.jpg);  */
        url("{{ $screen }}") ;
        background-repeat: no-repeat;
        background-size: cover;
}
.fa-plus-circle:before {
    color: white;
    font-size: 63px;
}
a.fa.fa-plus-circle.fa-10x {
    margin-top: -10%;
}
html.js-focus-visible {
    background: #141414;
}
.circle{
    color: white;
   
   
    font-size: 27px;
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
    margin-top: 10px;
     }
     a{
        text-decoration: none!important;  
     }
 </style>

