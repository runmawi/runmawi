{{-- Header --}}
@php include(public_path('themes/theme3/views/header.php')); @endphp
<style>
    span{
       font-weight: 400;
font-size: 15px;
line-height: 22px;

text-decoration: line-through;
color: #000000;

    }
    .dm{
       background-color: #3B77F5;
        padding: 20px 20px 20px 20px;
        margin: 10px;
        border-radius: 10px;
    }
    .dm1{
       background-color: #6A19C0;
        padding: 20px 20px 20px 20px;
        margin: 10px;
        border-radius: 10px;
    } 
    .dm2{
       background-color: #F67F0D;
        padding: 20px 20px 20px 20px;
        margin: 10px;
        border-radius: 10px;
    }
    .bg-white{
        padding: 10px;
        border-radius: 3px;
        width: 80px;
height: 55px;
        margin: 10px;
    }
    h2{
        font-weight: 600;
font-size: 30px;
line-height: 45px;
    }
    p{
        font-weight: 400;
font-size: 20px;
line-height: 25px;
        color: #fff;
    }
    .per{
        font-weight: 600;
font-size: 28px;
line-height: 30px!important;
        color: #fff;
    }
    .cpp-btn{
        background-color: #F60553;
        font-weight: 600;
font-size: 20px;

        color: #fff!important;
        padding: 10px 70px;
      
        border-radius: 5px;
    }
</style>

    <section class="sign-in-page" style="background: linear-gradient(86.02deg, #04152C 12.81%, rgba(0, 0, 0, 0) 95.61%), url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover; ">
        
            @forelse ($ModeratorUsers_list as  $key => $Moderator_user_list)
                <div class="cpp">
                    <div class="container-fluid">
                <p class="text-white"> Subscription Plans</p>
                    <div class="col-lg-8 p-0">
                    <h1 class="">Introducing bundled subscription plans at special introductory prices</h1>
                    
                </div>
                    <div class="col-lg-4 p-0">
                          <img class="w-100" src="<?php echo  URL::to('/assets/img/pink.png')?>" >
                    </div>
                                      <div class="row justify-content-between mt-4">
                        <div class="col-lg-6 p-0">
                            <div class="row dm align-items-center">
                                <div class="col-md-6">
                                    <h2>Power Play</h2>
                            <p>All 5 OTTs in one pack</p>
                            <h2 class="per mt-4">$ 1999per yr <br><span>Save upto $12500</span></h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 p-0">
                                             <img class="col-md-12 bg-white"  src="<?php echo  URL::to('/assets/img/s1.png')?>" >
                                             <img class="bg-white"   src="<?php echo  URL::to('/assets/img/s3.png')?>" >
                                   <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s4.png')?>" >
                                        </div>
                                        <div class="col-md-4 p-0">
                                            <img class="bg-white" src="<?php echo  URL::to('/assets/img/s2.png')?>" >
                                  
                                   <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s5.png')?>" >
                                        </div>
                                      
                                       <a class="cpp-btn" href="https://www.w3schools.com">Start</a>

                                    </div>
                                  
                                   
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-6 ">
                            <div class="row dm1 align-items-center">
                                <div class="col-md-6">
                                    <h2>Power Play</h2>
                            <p>All 5 OTTs in one pack</p>
                            <h2 class="per mt-4">$ 1999per yr<br><span> Save upto $12500</span></h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 p-0">
                                             <img class="col-md-12 bg-white"  src="<?php echo  URL::to('/assets/img/s1.png')?>" >
                                             <img class="bg-white"   src="<?php echo  URL::to('/assets/img/s3.png')?>" >
                                   <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s4.png')?>" >
                                        </div>
                                        <div class="col-md-4 p-0">
                                            <img class="bg-white" src="<?php echo  URL::to('/assets/img/s2.png')?>" >
                                  
                                   <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s5.png')?>" >
                                        </div>
                                        
                                       <a class="cpp-btn" href="https://www.w3schools.com">Start</a>
                                    </div>
                                  
                                   
                                </div>
                            </div>
                            
                        </div>
                      
                       <div class="col-lg-6 p-0">
                            <div class="row dm2 mt-4 align-items-center">
                                <div class="col-md-6">
                                    <h2>Power Play</h2>
                            <p>All 5 OTTs in one pack</p>
                            <h2 class="mt-4">$ 1999per yr<br><span> Save upto $12500</span></h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="row p-0">
                                        <div class="col-md-4 p-0">
                                             <img class="col-md-12 bg-white"  src="<?php echo  URL::to('/assets/img/s1.png')?>" >
                                             <img class="bg-white"   src="<?php echo  URL::to('/assets/img/s3.png')?>" >
                                   <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s4.png')?>" >
                                        </div>
                                        <div class="col-md-4 p-0">
                                            <img class="bg-white" src="<?php echo  URL::to('/assets/img/s2.png')?>" >
                                  
                                   <img class="bg-white"  src="<?php echo  URL::to('/assets/img/s5.png')?>" >
                                        </div>
                                         <a class="cpp-btn" href="https://www.w3schools.com">Start</a>
                                    </div>
                                  
                                  
                                      
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    </div></div>

            @empty

            @endforelse
        
    </section>

{{-- Footer --}}
@php include(public_path('themes/theme3/views/footer.blade.php')); @endphp
