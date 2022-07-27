@extends('admin.master')

@include('admin.favicon')

@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Content Partners Payouts :</h4>
                </div>
            </div>
             

                <div class="clear"></div>

                <h4 class="card-title">Content Partners </h4>


                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="cpp_payouts_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Username Name</th>
                                            <!-- <th>Video Title</th> -->
                                            <th>Purchases Count</th>
                                            <th>Total Commission</th>
                                            <th>Moderator Commission</th>
                                            <th>Paid Amount</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                <tbody>
                                @foreach($payouts as $key => $payout)
                                    <tr>
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $payout->username  }}</td>   
                                        <td>{{ $payout->count  }}</td>   
                                        <td>{{ $payout->total_amount  }}</td>   
                                        <td>{{ $payout->moderator_commssion  }}</td>   
                                        <td>
                                            @foreach($last_paid_amount as $keys => $paid_amount)
                                                @if ($payout->user_id == $keys && $paid_amount  )
                                                    {{ $paid_amount }}
                                                    <!-- @break -->
                                                    @break
                                                @else                                
                                                 @continue
                                                @endif
                                            @endforeach
                                        </td>  
                                        <!-- <td>{{ @$last_paid }}</td>    -->
                                        <td>
                                            <a href="{{ URL::to('/admin/moderator/view_payouts/') }}/{{ $payout->user_id }}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                            <a href="{{ URL::to('/admin/moderator/edit_payouts/') }}/{{ $payout->user_id }}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
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
</div>
    
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

     $(document).ready(function(){
        $('#cpp_payouts_table').DataTable();
    });
</script>
