@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">View Templates</h4>
                        </div>
                        <div class="iq-header-template">
                        <a href="{{ URL::to('admin/template/edit'). '/' . $email_template->id }}" class="btn btn-primary">Edit <i class="ri-pencil-line"></i></a>
                        </div>
                        </div>

                        <br>

                        <div class="col-sm-6"> 

					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Template Type</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">{{ $email_template->template_type }}</p> 
						</div> 
					</div>

				</div>
                <div class="col-sm-6"> 
				</div>
<br>
                <div class="col-sm-6"> 

<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
    <div class="panel-title"><label>Subject</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
    <div class="panel-body" style="display: block;"> 
        <p class="p1">{{ $email_template->heading }}</p> 
    </div> 
</div>

</div>
<div class="col-sm-6"> 
				</div>
                <br>

                <div class="col-sm-6"> 

<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
    <div class="panel-title"><label>Content</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
    <div class="panel-body" style="display: block;"> 
        <p class="p1">{{ $email_template->description }}</p> 
    </div> 
</div>

</div>
                        

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      
        
@stop

