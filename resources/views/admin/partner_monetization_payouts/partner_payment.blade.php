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
                            <h4><i class="entypo-globe"></i>New Payout Entry</h4>
                            <h4><i class="entypo-globe"></i>Channel Name : {{ $partnerpayment->channeluser->channel_name }}
                            </h4>
                        </div>
                    </div>
                    <hr>
                    <div class="clear"></div>
                    <form method="POST" action="{{ URL::to('admin/partner_monetization_payouts/store') }}"
                        accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <div class="panel-heading">
                                            <div class="panel-title"><label>Amount</label></div>
                                            <div class="panel-options">
                                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="display: block;">
                                            <input type="text" class="form-control" name="amount" id="amount" required />
                                            <small id="amountError" class="text-danger" style="display: none;">Amount exceeds available balance.</small>
                                            <small id="amountNumericError" class="text-danger" style="display: none;">Please enter a valid amount.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <div class="panel-heading">
                                            <div class="panel-title"><label>Payment Date</label></div>
                                            <div class="panel-options"> <a href="#" data-rel="collapse"><i
                                                        class="entypo-down-open"></i></a> </div>
                                        </div>
                                        <div class="panel-body" style="display: block;">
                                            <input type="date" class="form-control" name="payment_date"
                                                id="payment_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <div class="panel-heading">
                                            <div class="panel-title"><label>Comment , if any(max.256 cars)</label></div>
                                            <div class="panel-options"> <a href="#" data-rel="collapse"><i
                                                        class="entypo-down-open"></i></a> </div>
                                        </div>
                                        <div class="panel-body" style="display: block;">
                                            <input type="text" class="form-control" name="notes" id="notes" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3" style="display: flex; justify-content: flex-start;">
                                        <div class="">
                                            <input type="submit" value="Submit" class="btn btn-primary" onclick="return validateAmount();" />
                                        </div>
                                        <div class="px-2">
                                            <button type="button" class="btn btn-danger" onclick="location.reload();">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <div>
                                        <h6 class="card-title border-bottom">Channel ID: {{ $partnerpayment->user_id }}</h6>

                                        <p class="text-center font-weight-bold">Payouts Summary</p>

                                        <div class="d-flex justify-content-between border-top mt-3 pt-3">
                                            <div>
                                                <p class="mb-0">Overall Amount</p>
                                            </div>
                                            <div class="font-weight-bold">
                                                <p class="mb-0">{{ $totalCommission ?? 0 }}</p>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between pt-3">
                                            <div>
                                                <p class="mb-0">Total Amount Paid</p>
                                            </div>
                                            <div class="font-weight-bold">
                                                <p class="mb-0">{{ $totalAmountPaid ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2 pt-2">
                                            <div>
                                                <p class="mb-0">Balance Amount Payable</p>
                                            </div>
                                            <div class="font-weight-bold">
                                                <p class="mb-0">{{ $payment_details->balance_amount ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" name="user_id"
                            value="<?= isset($partnerpayment->user_id) ? $partnerpayment->user_id : '' ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop

<script>
    function validateAmount() {
        const amountInput = document.getElementById('amount');
        const amount = parseFloat(amountInput.value);
        const balanceAmount = parseFloat("{{ $totalCommission ?? 0 }}");
        
        const errorMsg = document.getElementById('amountError');
        const numericErrorMsg = document.getElementById('amountNumericError');
        errorMsg.style.display = 'none';
        numericErrorMsg.style.display = 'none';
        if (isNaN(amount) || amount < 0) {
            numericErrorMsg.style.display = 'block';
            return false;
        }
        if (amount > balanceAmount) {
            errorMsg.style.display = 'block'; 
            return false; 
        }
        return true; 
    }
</script>