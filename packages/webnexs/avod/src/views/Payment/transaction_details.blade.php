@include('avod::ads_header')

<div id="main-admin-content">
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="justify-content-between d-flex">
                           <h2 class=" mb-3">Transaction Details</h2>
                        </div>
                       
                        <div class="nested-list dd with-margins">
                            <table class="data-tables table audio_table " id="transaction_details" style="width:100%">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> {{ ucwords('subscription id') }} </th>
                                        <th> {{ ucwords('plan name') }} </th>
                                        <th> {{ ucwords('plan price') }} </th>
                                        <th> {{ ucwords('platform') }} </th>
                                        <th> {{ ucwords('Payment Gateway') }} </th>
                                        <th> {{ ucwords('status') }} </th>
                                        <th> {{ ucwords('subscription start') }} </th>
                                        <th> {{ ucwords('subscription ends') }} </th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @forelse ($adverister_subscription as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ ucfirst($item->subscription_id) }}</td>
                                            <td>{{ $item->plan_name }}</td>
                                            <td>{{ currency_symbol() . $item->plan_price }}</td>
                                            <td>{{ ucwords($item->platform) }}</td>
                                            <td>{{ ucwords($item->PaymentGateway)  }}</td>
                                            <td>
                                                <span class="badge {{ $item->status == 'active' ? 'badge-success' : ($item->status == 2 ? 'badge-danger' : 'badge-info') }}">
                                                   {{ $item->status == 'active' ? 'Approved' : ($item->status == 2 ? 'Disapproved' : 'Pending') }}
                                                </span>
                                             </td>
                                            <td>{{ $item->subscription_start }}</td>
                                            <td>{{ $item->subscription_ends_at  }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12">No Transcation found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('avod::ads_footer')

@yield('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <script>
        $(document).ready( function () {
            $('#transaction_details').DataTable();
        });
    </script>           