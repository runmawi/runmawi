@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<div class="container mt-4 mb-4"
    style="background-color: white;border-radius: 10px; padding:20px;box-shadow: 0px 4px 20px rgb(0 0 0 / 5%);">
    <div class="row justify-content-center page-height">
        <div class="col-md-12 ">

            <div class="login-block ">

                <div class="d-flex justify-content-between">
                    <h4 class="my_profile" style="color: black;"> <i class="fa fa-edit"></i>{{ __('Transaction History') }}</h4>
                    <a href="{{ URL::to('/myprofile') }}"><button class="btn bd">{{ __('Back') }}</button></a>
                </div>
                <hr>

                <div class="mt-5">

                    <table id="transactiondetails" class="table-bordered text-center display">
                        <thead>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Payment type') }}</th>
                                <th>{{ __('Payment In') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $key => $subscription)
                                <tr>
                                    @if($subscription->stripe_status == 'active')
                                        <td class="bg-success"> {{ 'Approved'}} </td>
                                    @elseif($subscription->stripe_status == 'Cancelled')
                                        <td class="bg-danger" style="background: #c62929 !important;" > {{ 'Cancelled' }} </td>
                                    @else
                                        <td class="bg-warning"> {{ 'Pending' }}></td>
                                    @endif
                                    <td>{{  Carbon\Carbon::parse( $subscription->created_at)->format('F jS, Y')  }}</td>
                                    <td>{{ $subscription->price }}</td>
                                    <td>Card</td>
                                    <td>Subscriptions</td>
                                </tr>
                            @endforeach

                            @foreach ($ppvcharse as $key => $ppv)
                                <tr>
                                    @if($ppv->status == 'active')
                                        <td class = "bg-success"> {{ 'Approved' }} </td>
                                    @elseif($ppv->status == 'Cancelled')
                                        <td class="bg-danger" style="background: #c62929 !important;" > {{ 'Cancelled' }} </td>
                                    @else
                                        <td class = "bg-warning"> {{ 'Pending' }}</td>
                                    @endif

                                    <td>{{ Carbon\Carbon::parse( $ppv->created_at)->format('F jS, Y') }}</td>
                                    <td>{{ $ppv->total_amount }}</td>
                                    <td>Card</td>
                                    <td>PPV Purchase</td>
                                </tr>
                            @endforeach

                            @foreach ($livepurchase as $key => $live)
                                <tr>
                                    @if($live->status == 1)
                                        <td class = "bg-success"> {{ 'Approved' }}</td>
                                    @elseif($live->status == 2)
                                        <td class="bg-danger" style="background: #c62929 !important;" > {{ 'Cancelled' }} </td>
                                    @else
                                        <td class = "bg-warning"> {{ 'Pending' }}</td>
                                    @endif
                                    <td>{{  Carbon\Carbon::parse( $live->created_at)->format('F jS, Y') }}</td>
                                    <td>{{ $live->amount }}</td>
                                    <td>{{ __('Card') }}</td>
                                    <td>PPV Purchase</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
</div>

@php include public_path("themes/{$current_theme}/views/footer.blade.php"); @endphp

<link rel="stylesheet" href="//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
<script src="//cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    let table = new DataTable('#transactiondetails', {
        responsive: true,
        columnDefs: [
            { className: 'dt-center', targets: '_all' } 
        ]
    });
});

</script>

<style>
    .dt-center {
        text-align: center !important;
    }
</style>