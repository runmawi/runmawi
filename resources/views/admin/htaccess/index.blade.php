@extends('admin.master')

@include('admin.favicon')

@include('admin.cache.style')

@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid p-0">
        <div id="webhomesetting">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">{{ ('Video Access Forbidden Management')}}</h4>
                    </div>
                </div>

                <div class="panel panel-primary mt-3" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row align-items-center p-2">
                            <div class="col-sm-3">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <button class="button-87" role="button" id="debug_true"> {{ ucwords('Enable Video Access') }} </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                    <div class="d-flex align-items-center justify-content-around">
                                        <button class="button-87" role="button" id="debug_false"> {{ ucwords('Disable Video Access') }} </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row align-items-center p-2">
                           
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@stop


@section('javascript')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){

        $("#debug_true").click(function(){

            var check = confirm("Are you sure you to change Enable Video's Forbidden ?");  

            if(check == true){ 
                $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/access-forbidden-update') }}",
                              data: {
                                 _token  : "{{csrf_token()}}" ,
                                 action  : 1,
                        },
                        success: function(data) {
                              if(data.message == 'true'){
                                  alert('Enable Forbidden changed Successfully');
                                 location.reload();
                              }
                              else if(data.message == 'false'){
                                 swal.fire({
                                 title: 'Oops', 
                                 text: 'Something went wrong!', 
                                 allowOutsideClick:false,
                                 icon: 'error',
                                 title: 'Oops...',
                                 }).then(function() {
                                    location.href = '{{ URL::to('admin/access-forbidden') }}';
                                 });
                              }
                           },
                });
            }
        });


         $("#debug_false").click(function(){

            var check = confirm("Are you sure you to change Disable Video's Forbidden ?");  

            if(check == true){ 
                $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/access-forbidden-update') }}",
                              data: {
                                 _token  : "{{csrf_token()}}" ,
                                 action  : 0,
                        },
                        success: function(data) {
                              if(data.message == 'true'){
                                alert('Disable Forbidden changed Successfully');
                                 location.reload();
                              }
                              else if(data.message == 'false'){
                                 swal.fire({
                                 title: 'Oops', 
                                 text: 'Something went wrong!', 
                                 allowOutsideClick:false,
                                 icon: 'error',
                                 title: 'Oops...',
                                 }).then(function() {
                                    location.href = '{{ URL::to('admin/access-forbidden') }}';
                                 });
                              }
                           },
                });
            }
        });
    });
</script>

@stop
