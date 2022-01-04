@extends('layouts.app')
@include('/header')

<head>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>
@section('content')
<div class="container">
    <div class="row  align-items-center height-self-center">
        <div class="col-md-12">
            <div class="">            
                    <div class="sign-in-from  m-auto" >
                        <h3 class="manage">Manage Profile</h3>
                        <div class="col-md-12">
                            @foreach ($multiprofile as $profile)
                            <div>
                                <div class="member">
                                    <a  href="{{ route('Multiprofile.edit', $profile->id)}}">
                                        <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                                    </a> 

                                    <div class="circle">
                                        <i class="fa fa-pencil"></i>
                                    </div>

                                    <div class="name">{{ $profile ? $profile->user_name : ''  }}</div>
                                </div>
                            </div>
                            @endforeach   
                            <li class=""> 
                                <a class="fa fa-plus-circle fa-10x" href="{{route('Multiprofile.create') }}"></a>
                            </li>  
                        </div>    
                        
                        {{-- <button type="button" class="btn btn-outline-light"> Done</button> --}}

                    </div> 
             </div>
         </div>
    </div>
</div>

@include('/footer')

 @endsection

 <style>
.sign-in-from {
    padding: 282px 291px 311px 203px;
    background-image: linear-gradient( rgb(10 10 10 / 50%), rgb(0 0 0 / 50%)  ),
     url(public/uploads/avatars/Movies.jpg);
}
.manage{
    font-family: ui-rounded;
    font-size: xx-large;
    margin: top;
    margin-top: -254px;
    color: #efe3e3;
}
.multiuser_img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
  margin-top: 15%;
}

.multiuser_img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
.member {
    float:left;
    width:20%;
    margin:1% 1% 45px 1%;
}
.name{
    font-size: larger;
    font-family: auto;
    color: white;
    text-align: center;
}
.fa-plus-circle:before {
    color: white;
    font-size: 63px;
}
a.fa.fa-plus-circle.fa-10x {
    margin-top: 10%;
}

.icon-background3 {
    color: #c0ffff;
}

.icon-background4 {
    color: #c2cdc2;
}

.icon-background6 {
    color: #e5efe5;
}

.circle{
  border:2px solid white;
  border-radius:50%;
  background:rgba(0,0,0,0);
  color:white;
  width:50px;
  height:50px;
  text-align:center;
  line-height:50px;
}

 </style>


