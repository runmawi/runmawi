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
                            <h4 class="card-title">Cache Management</h4>
                        </div>
                    </div>

                    <div class="panel panel-primary mt-3" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="d-flex " style="justify-content: space-evenly;">
                                <button class="button-87" role="button" id="clear_cache"> {{ ucwords('clear cache') }} </button>

                                <button class="button-87" role="button" id="clear_buffer_cache"> {{ ucwords('clear buffer cache') }} </button>

                                <button class="button-87" role="button" id="view_buffer_cache"> {{ ucwords('view buffer cache') }} </button>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row align-items-center p-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

    <script>

        $(document).ready(function(){

            $("#clear_cache").click(function(){

                var check = confirm("Are you sure you to clear cache ?");  

                if(check == true){ 
                    $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/clear_caches') }}",
                            data: {
                                _token  : "{{csrf_token()}}" ,
                        },
                        success: function(data) {
                            alert( data.message );
                            window.location.href = '{{ url("admin/clear-cache") }}';
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                            window.location.href = '{{ url("admin/clear-cache") }}';
                        }
                    });
                }
            });

            $("#view_buffer_cache").click(function(){

                var check = confirm("Are you sure you to view buffer cache?");  

                if (check == true) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('view_buffer_cache') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.status == true) {
                                alert(
                                    "Total Memory: " + data.data.memory.total +
                                    "\nTotal used: " + data.data.memory.used +
                                    "\nTotal free: " + data.data.memory.free +
                                    "\nTotal shared: " + data.data.memory.shared +
                                    "\nTotal buff cache: " + data.data.memory.buff_cache +
                                    "\nTotal available: " + data.data.memory.available +
                                    "\nTotal Swap: " + data.data.swap.total +
                                    "\nSwap used: " + data.data.swap.used +
                                    "\nSwap free: " + data.data.swap.free
                                );
                            } else if (data.status == false) {
                                alert('Oops... Something went wrong!');
                                window.location.href = '{{ url("admin/clear-cache") }}';
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                            window.location.href = '{{ url("admin/clear-cache") }}';
                        }
                    });
                }
            });

            $("#clear_buffer_cache").click(function () {

                let password = prompt("Please enter your password to clear the buffer cache:");

                if (password) {
                    $.ajax({
                        type: "POST", 
                        dataType: "json",
                        url: "{{ route('clear_buffer_cache') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            password: password,
                        },
                        success: function (data) {
                            if (data.status) {
                                alert(
                                    " Message : " + data.message +
                                    "\output: " + data.output +
                                    "\error_output: " + data.error_output 
                                );

                                location.reload();
                            } else {
                                alert(data.message || 'Oops... Something went wrong!');
                                location.reload();
                            }
                        },
                        error: function (xhr) {
                            alert(xhr.responseJSON?.message || 'An error occurred.');
                            location.reload();
                        },
                    });
                } else {
                    alert("Password is required to clear the buffer cache.");
                }
            });
        });
    </script>
@stop