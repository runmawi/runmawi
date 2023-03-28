@extends('admin.master')

<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}

	.make-switch{
		z-index:2;
	}

    .iq-card{
        padding: 15px;
    }

    .lar {
    font-family: 'Line Awesome Free';
    font-weight: 400;
    margin: 4px;
    }

    .form-control {
   
    }
    .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
        border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid p-0">
            <div class="admin-section-title">
                <div class="iq-card">
                    <div class="row">
                                        {{-- Header name --}}
                        <div class="col-md-6"> <h4><i class="entypo-video"></i> Channel Package </h4> </div>
                                             
                                        {{-- Add New --}}
                        <div class="col-md-6" align="right">	
                            <a href="{{ route('channel_package_create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>    
                    
                                         {{-- Success message  --}}
                    <div class="row">
                        <div class="col-md-6" align="right">
                            @if (Session::has('message'))
                                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="gallery-env mt-2">
                        <table class="data-tables table livestream_table iq-card text-center p-0" style="width:100%">
                            <thead>
                                <tr class="r1">
                                    <th> {{  Str::upper('S.No') }} </th>
                                    <th> {{  Str::upper('Package Name') }}  </th>
                                    <th> {{  Str::upper('Package Price') }}  </th>
                                    <th> {{  Str::upper('Package plan id') }}  </th>
                                    <th> {{  Str::upper('Plan Interval') }}  </th>
                                    <th> {{  Str::upper('Status') }} </th>
                                    <th> {{  Str::upper('Action') }} </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($Channel_list as $key =>  $Channel_lists )
                                    <tr>
                                        <td> {{ $key + 1  }}</td>
                                        <td> {{ $Channel_lists->channel_package_name }}</td>
                                        <td> {{ $Channel_lists->channel_package_price }}</td>
                                        <td> {{ $Channel_lists->channel_package_plan_id }}</td>
                                        <td> {{ $Channel_lists->channel_plan_interval }}</td>
                                        <td> {{ $Channel_lists->status == 1 ? "Active" : "Inactive" }}</td>

                                            {{-- Action --}}
                                        <td class=" align-items-center list-inline">								
                                            <a href="{{ route('channel_package_edit', $Channel_lists->id) }}" class="iq-bg-success ml-2 mr-2"><img class="ply " src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                            <a href="{{ route('channel_package_delete', $Channel_lists->id) }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

	@section('javascript')
        <script>
            $(document).ready(function(){
                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 3000);
            })
        </script>
    @stop
@stop

