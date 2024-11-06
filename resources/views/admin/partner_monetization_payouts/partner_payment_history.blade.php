@extends('admin.master')
<style type="text/css">
    .has-switch .switch-on label {
        background-color: #FFF;
        color: #000;
    }

    .make-switch {
        z-index: 2;
    }

    .iq-card {
        padding: 15px;
    }

    .p1 {
        font-size: 12px;
    }
</style>
@section('css')
    <style type="text/css">
        .make-switch {
            z-index: 2;
        }
    </style>

@stop

@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="iq-card">

                <div id="admin-container">

                    <div class="admin-section-title">
                        <div class="d-flex justify-content-between">
                            <h4><i class="entypo-globe"></i>Partner Payment History</h4>
                            <div class="col-sm-6 form-group">
                                <select class="form-control" id="channelSelect">
                                    <option value="">Select Channel</option>
                                    @foreach ($payment_details as $partner)
                                        <option value="{{ $partner->id }}"> {{ $partner->channel_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="clear"></div>

                    <div id="channelDetails" style="display: none;">
                        <table class="table">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Month / Year</th>
                                    <th>Paid Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Payment Method</th>
                                </tr>
                            </thead>
                            <tbody id="detailsContent"></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



@stop


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#channelSelect').on('change', function() {
            const userId = $(this).val();
            console.log('User ID selected:', userId); // Debugging output

            if (userId) {
                $.ajax({
                    url: '{{ route("get.channel.data", ":id") }}'.replace(':id', userId),
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Data received:', data); // Check what data looks like

                        // Ensure we are dealing with an array
                        if (Array.isArray(data)) {
                            const detailsContent = data.map(payment => `
                                <tr style="text-align: center;">
                                    <td>${payment.payment_date}</td>
                                    <td>${payment.paid_amount ?? 0}</td>
                                    <td>${payment.balance_amount ?? 0}</td>
                                    <td>${payment.payment_method}</td>
                                </tr>
                            `).join('');

                            $('#detailsContent').html(detailsContent);
                            $('#channelDetails').show();
                        } else {
                            // Handle the case where data is not an array
                            console.error('Expected an array but got:', data);
                            alert('No payment records found or an error occurred.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching channel data:', xhr.status, error, xhr.responseText);
                        alert('Failed to fetch channel data: ' + xhr.responseText);
                    }
                });
            } else {
                $('#channelDetails').hide(); // Hide details if no channel is selected
            }
        });
    });
</script>
