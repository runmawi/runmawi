@extends('admin.master')

@include('admin.life_time_subscription.style')

@section('content')

    <div id="content-page" class="content-page">
        <div class="iq-card">

            @if (Session::has('message'))
                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
            @endif 
            
            @if(count($errors) > 0) 
                @foreach( $errors->all() as $message )
                    <div class="alert alert-danger display-hide" id="successMessage">
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                    </div>
                @endforeach 
            @endif

            <div class="admin-section-title">
                <h4 class="fs-title"> {{  ucwords('Life time subscription')}}</h4>
            </div>
            <hr/>

            <form id="life_time_form" method="POST" action="{{ route('Life-time-subscription-update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                @csrf

                <div class="col-sm-12">
                    <div class="row mt-3 p-0">
                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <label class="m-0"> {{ ucwords ( 'Life time subscription Name ') }}  </label>
                            <div class="panel-body">
                                <input type="text" placeholder="Life time subscription Name" class="form-control" name="name" value="@if(!empty($AdminLifeTimeSubscription->name)){{ $AdminLifeTimeSubscription->name }}@endif" />
                            </div>
                        </div>
                        
                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <label class="m-0"> {{ ucwords( "Life time subscription price (". $allCurrency->symbol.")"  ) }}  </label>
                            <div class="panel-body">
                                <input type="text"  placeholder="Life time subscription price" class="form-control" name="price"  value="@if(!empty($AdminLifeTimeSubscription->price)){{ $AdminLifeTimeSubscription->price }}@endif" />   
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 p-3 align-items-center">

                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <label class="m-0"> {{ ucwords('Status') }}</label>
                            <div class="panel-body">
                                <div class="mt-1 col-md-4">
                                    <label class="switch">
                                        <input name="status" id="" class="" type="checkbox" {{ !empty($AdminLifeTimeSubscription->status) == "1" ? 'checked' : ''  }}  >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <label class="m-0"> {{ ucwords('Devices') }}</label>
                            <div class="panel-body">
                                @forelse($devices as $val)
                                    <div class="col-md-5 " style="width:35%; float:left;" >
                                        <div class="d-flex align-items-center justify-content-around">
                                            <div> <label> {{ $val->devices_name }}</label>  </div>
                                            <div>
                                                 <label class="switch">
                                                    <input type="checkbox"  name="devices[]"  value="{{ $val->id }}">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                       <span> {{ " No Devices Found"}} </span> 
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class=" p-0 mt-4">
                        <input type="submit" value="Update" class="btn btn-primary mr-2" />
                    </div>
                </div>
                <div class="clear"></div>
            </form>
            <div class="clear"></div>
        </div>
    </div>

    @section('javascript')

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#successMessage").fadeOut("fast");
            }, 3000);
        });
    </script>


    {{-- validation --}}

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $('form[id="life_time_form"]').validate({
            rules: {
                name: "required",
                price: {
                        required: true,
                        number: true
                    }
                // status: "required",
                // 'devices[]': "required",
            },
            submitHandler: function (form) {
                form.submit();
            },
        });

    </script>

    @stop 
@stop
