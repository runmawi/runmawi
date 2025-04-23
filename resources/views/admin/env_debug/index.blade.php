@extends('admin.master')

@include('admin.favicon')


<style>

    .button-87 {
        margin: 10px;
        padding: 15px 30px;
        text-align: center;
        text-transform: uppercase;
        transition: 0.5s;
        background-size: 200% auto;
        color: white;
        border-radius: 10px;
        display: block;
        border: 0px;
        font-weight: 700;
        box-shadow: 0px 0px 14px -7px #f09819;
        background-image: linear-gradient(45deg, #FF512F 0%, #F09819  51%, #FF512F  100%);
        cursor: pointer;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
    }

    .button-87:hover {
        background-position: right center;
        color: #fff;
        text-decoration: none;
    }

    .button-87:active {
        transform: scale(0.95);
    }
</style>
@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid p-0">
        <div id="webhomesetting">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">{{ ('ENV APP DEBUG Management')}}</h4>
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
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <button class="button-87" role="button" id="debug_true"> {{ ucwords('App debug True') }} </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                    <div class="d-flex align-items-center justify-content-around">
                                        <button class="button-87" role="button" id="debug_false"> {{ ucwords('App debug false') }} </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                    <div class="d-flex align-items-center justify-content-around">
                                        <a  href="{{ URL::to('/logs')}}" target="_blank" rel="noopener noreferrer">
                                        <button class="button-87" role="button" id="debug_false"> {{ ucwords('Server Logs') }} </button>
                                        </a>
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

            var check = confirm("Are you sure you to change APP DEBUG true?");  

            if(check == true){ 
                $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/Env_AppDebug') }}",
                              data: {
                                 _token  : "{{csrf_token()}}" ,
                                 status  : "true",
                        },
                        success: function(data) {
                              if(data.message == 'true'){
                                  alert('APP DEBUG changed Successfully');
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
                                    location.href = '{{ URL::to('admin/debug') }}';
                                 });
                              }
                           },
                });
            }
        });


         $("#debug_false").click(function(){

            var check = confirm("Are you sure you to change APP DEBUG False?");  

            if(check == true){ 
                $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/Env_AppDebug') }}",
                              data: {
                                 _token  : "{{csrf_token()}}" ,
                                 status  : "false",
                        },
                        success: function(data) {
                              if(data.message == 'true'){
                                alert('APP DEBUG changed Successfully');
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
                                    location.href = '{{ URL::to('admin/Env_AppDebug') }}';
                                 });
                              }
                           },
                });
            }
        });
    });
</script>

@stop
