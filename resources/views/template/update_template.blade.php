@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Edit Templates</h4>
                        </div>
                        </div>

                        <br>
                        @if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage" >
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                        </div>
                        @endforeach
                        @endif
                        <div class="clear"></div>

                    <form method="POST" action="{{ URL::to('admin/template/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

                        <div class="col-sm-12"> 

					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Template Type</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
                        <input type="hidden" class="form-control" name="id" id="id" value="@if(!empty($email_template->id)){{ $email_template->id }}@endif" />
                        <input type="text" class="form-control" name="template_type" id="template_type" placeholder="Template" value="@if(!empty($email_template->template_type)){{ $email_template->template_type }}@endif" />
						</div> 
					</div>

				</div>

<br>
                <div class="col-sm-12"> 

<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
    <div class="panel-title"><label>Subject</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
    <div class="panel-body" style="display: block;"> 
    <input type="text" class="form-control" name="heading" id="heading" placeholder="Heading" value="@if(!empty($email_template->heading)){{ $email_template->heading }}@endif" />
    </div> 
</div>

</div>

                <br>

                <div class="col-sm-12"> 

<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
    <div class="panel-title"><label>Content</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
    <div class="panel-body" style="display: block;"> 
    <textarea  rows="5" class="form-control" name="description" id="summary-ckeditor"
    placeholder="Description">@if(!empty($email_template->description)){{ ($email_template->description) }}@endif</textarea>
    <!-- <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="@if(!empty($email_template->description)){{ $email_template->description }}@endif" /> -->
    </div> 
</div>

</div>
                        
<div class="mt-2 p-2"  style="display: flex;
    justify-content: flex-end;">
			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
     <input type="submit" value="Update Template" class="btn btn-primary pull-right" /></div>

		</form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace( 'summary-ckeditor', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
</script>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
@stop

