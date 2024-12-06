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

                            <button class="button-87" role="button" id="clear_views_cache"> {{ ucwords('clear views cache') }} </button>

                            <button class="button-87" role="button" id="view_buffer_cache"> {{ ucwords('view buffer cache') }} </button>

                            <button class="button-87" role="button" id="clear_buffer_cache"> {{ ucwords('clear buffer cache') }} </button>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){

        $("#clear_cache").click(function(){

            var check = confirm("Are you sure you  to Clear Cache?");  

            if(check == true){ 
                $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/clear_caches') }}",
                              data: {
                                 _token  : "{{csrf_token()}}" ,
                        },
                        success: function(data) {
                              if(data.message == 'true'){
                                  alert('Clear Cached Successfully');
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
                                    location.href = '{{ URL::to('admin/clear_cache') }}';
                                 });
                              }
                           },
                });
            }
        });

        $("#clear_views_cache").click(function(){

            var check = confirm("Are you sure you  to Clear Views Cache?");  

            if(check == true){ 
                $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/clear_view_cache') }}",
                              data: {
                                 _token  : "{{csrf_token()}}" ,
                        },
                        success: function(data) {
                              if(data.message == 'true'){
                                  alert('Clear Cached Successfully');
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
                                    location.href = '{{ URL::to('admin/clear_cache') }}';
                                 });
                              }
                           },
                });
            }
        });

        $("#view_buffer_cache").click(function(){

            var check = confirm("Are you sure you to view buffer cache?");  

            if(check == true){ 
                $.ajax({
                    type: "POST", 
                    dataType: "json", 
                    url: "{{ route('view_buffer_cache') }}",
                    data: {
                        _token  : "{{csrf_token()}}" ,
                    },
                    success: function(data) {
                        if(data.message == 'true'){
                            alert('view buffer cache Successfully');
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
                                location.href = '{{ URL::to('admin/clear_cache') }}';
                            });
                        }
                    },
                });
            }
        });

        $("#clear_buffer_cache").click(function(){

            var check = confirm("Are you sure you to clear buffer cache?");  

            if(check == true){ 
                $.ajax({
                    type: "POST", 
                    dataType: "json", 
                    url: "{{ route('clear_buffer_cache') }}",
                    data: {
                        _token  : "{{csrf_token()}}" ,
                    },
                    success: function(data) {
                        if(data.message == 'true'){
                            alert('Clear buffer cache Successfully');
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
                                location.href = '{{ URL::to('admin/clear_cache') }}';
                            });
                        }
                    },
                });
            }
        });
    });
</script>

@stop


