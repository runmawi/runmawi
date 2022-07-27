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
             
<br>
                <div class="clear"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="cpp_payouts_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Username Name</th>
                                            <th>Total Commission</th>
                                            <th>Commission Paid</th>
                                            <th>Commission Pending</th>
                                            <th>Payment Type</th>
                                            <th>Invoice</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                <tbody>
                                @foreach($ModeratorPayout as $key => $payout)
                                    <tr>
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $payout->name->username  }}</td>   
                                        <td>{{ $payout->commission_paid + $payout->commission_pending   }}</td>   
                                        <td>{{ $payout->commission_paid	  }}</td>   
                                        <td>{{ $payout->commission_pending  }}</td>
                                        <td>{{ $payout->payment_type  }}</td>   
                                        <td>   
                                        <!-- <a href ="{{ $payout->invoice  }}" attributes-list download > Link Text </a>   -->

                                            <a href="{{ $payout->invoice  }}" download>
                                                <button type="button" data-name="{{ $payout->invoice  }}"  onclick="invoicedownload(this)" class="btn btn-lg btn-outline-primary invoice">Download Invoice</button>
                                            </a>
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

    function invoicedownload(ele) 
        {
            //  var invoice = $(ele).attr('data-name');
            // // alert(invoice);
            //     $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Downloaded User CSV File </div>');
            //                 setTimeout(function() {
            //                     $('.add_watch').slideUp('fast');
            //                 }, 3000);

            //     location.href = invoice;
        }

</script>
