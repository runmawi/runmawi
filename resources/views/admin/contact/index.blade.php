@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
  <link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection
<script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
@section('content')

<div id="content-page" class="content-page">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header  justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Contact Request</h4>
                           </div>
                            </div>
                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " id="player_table" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Attach Screenshot</th>
                                 </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    @foreach($contact as $key => $request)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $request->fullname  }}</td>   
                                        <td>{{ $request->email  }}</td>   
                                        <td>{{ $request->phone_number  }}</td>   
                                        <td>{{ $request->subject  }}</td>   
                                        <td>{{ $request->message  }}</td>   
                                        <td>
                                        <a href="{{ URL::to('/public/uploads/contact_image/').'/'.$request->screenshot }}">
                                        <img src="{{ URL::to('/public/uploads/contact_image/').'/'.$request->screenshot }}"  alt="" style = "width: 100px;">    
                                        </a>
                                        <!-- {{ $request->screenshot  }} -->
                                    </td>   
                                        </tr>

                                    @endforeach
                              </tbody>
                           </table>
                        </div>
                  </div>
               </div>
         </div>
    </div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
         $(document).ready(function(){
            $('#player_table').DataTable();
         });
</script>
