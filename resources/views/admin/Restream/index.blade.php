@extends('admin.master')
<style>
    .bg-color{
        background-color: #696969	;
        margin: 5px;
        padding: 40px;
        text-align: center;
        border-radius: 10px;
        font-size: 20px;
        font-weight: 700;
        height: 200px;
        margin-top: 40px;
        
    }
    .bg-color:hover{
        background-color: #24a0ed;
    }
    .bg-color i{
        font-size: 50px;
            color:#fff;
        
    }
    .bg-color p{
        font-size: 18px;
        margin-top: 15px;
        color: #fff;
    }
</style>
@section('content')
     <div id="content-page" class="content-page">

<div class="admin-section-title">
        <div class="iq-card">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-video"></i> Restream</h3>
                <hr>
			</div>
			
		</div> 
            <div class="text-center mt-4">
                <p>Welcome to Restream!</p>
                <h5>What would you like to do ?</h5>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div class="bg-color">
                        <i class="fa fa-video-camera" aria-hidden="true"></i>

                        <p>Start With Your Studio</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="bg-color">
                        <i class="fa fa-bars" aria-hidden="true"></i>

                         <p>Set up for OBS, ZOOM, ETC,..</p>
                    </div>
                  
                </div>
                <div class="col-lg-3">
                     <div class="bg-color">
                         <i class="fa fa-file-video-o" aria-hidden="true"></i>

                         <p>Stream A Video File</p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div class="bg-color">
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>


                        <p>Schedule Event</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="bg-color">
<i class="fa fa-camera-retro" aria-hidden="true"></i>

                         <p>Record Only..</p>
                    </div>
                  
                </div>
               
            </div>
	

		
		

</div>
            </div>
    </div>
    

	
@stop