@extends('admin.master')

@include('admin.favicon')

@section('content')

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
          <div class="col-sm-12">
             <div class="iq-card">
                
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Email Logs</h4>
                  </div>
                  
                   <div class="iq-card-header-toolbar d-flex align-items-baseline">
                       <div class="form-group mr-2"> <a href="{{ route('email_settings') }}" class="btn btn-primary" > Email Setting </a> </div>
                  </div>
               </div>

               <div class="iq-card-body table-responsive">
                  <div class="table-view">
                     <table id="template" class="table table-striped table-bordered text-center table movie_table " style="width:100%">
                        <thead>
                              <tr class="r1">
                                 <th>S.No</th>
                                 <th>Name</th>
                                 <th>logs</th>
                                 <th>Email Template</th>
                                 <th>Status</th>
                                 <th>User Id</th>
                              </tr>
                           </thead>

                            @forelse ($email_logs as $key => $email_logs_details)
                                @php
                                  $name =  App\User::where('id',$email_logs_details->user_id)->pluck('username')->first();
                                @endphp
                                <tbody>
                                    <td> {{ $key+1 }} </td>
                                    <td> {{ $name ? $name : "-" }} </td>
                                    <td  style="color:{{ $email_logs_details->color }}"> 
                                        {{ $email_logs_details->email_logs }} 
                                    </td>
                                    <td> {{ $email_logs_details->email_template }} </td>
                                    <td> {{ $email_logs_details->email_status }} </td>
                                    <td> {{ $email_logs_details->user_id ?  $email_logs_details->user_id : "-" }} </td>
                                </tbody>
                            @empty
                                
                            @endforelse
                        </table>
                     </div>
                  </div>
               </div>
         </div>
      </div>
   </div>
</div>

@section('javascript')

<script>
    $(document).ready( function () {
        $('#template').DataTable();
    } );
</script>

@stop
