<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Container for logo and header title */
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        /* Logo alignment */
        .header-logo {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .header-logo img {
            object-fit: contain;
            width: 100px;
            height: 50px;
        }

        /* Invoice title centered */
        .invoice-header {
            flex-grow: 1;
            text-align: center;
        }

        .invoice-header h1 {
            font-size: 28px;
            color: #333;
            margin: 0;
        }

        /* Table and footer styles */
        .invoice-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .invoice-info-table th, .invoice-info-table td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
            border: none;
        }

        .section-title {
            font-size: 18px;
            color: #333;
            font-weight: bold;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 15px;
        }

        .invoice-table th, .invoice-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #f7f7f7;
            font-weight: bold;
        }

        .invoice-footer {
            text-align: right;
            font-size: 16px;
            color: #555;
            margin-top: 20px;
        }

        .invoice-footer .total {
            font-size: 22px;
            color: #27ae60;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer-note {
            font-size: 12px;
            color: #888;
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header-container">
        <a class="header-logo">
            <img src="{{ $logoSrc }}" class="c-logo" alt="Logo">
            <div class="logo-title">
                <span class="text-primary text-uppercase"></span>
            </div>
        </a>
        <div class="invoice-header">
            <h1>Invoice</h1>
        </div>
    </div>

    <div>       
        <table class="invoice-info-table">
            <tr>
                <th>Invoice Date:</th>
                <td>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</td>
                <th>Invoice Number:</th>
                <td>INV - {{ $partnerpayment->id }}</td>
            </tr>
            <tr>
                <th rowspan="2">From:</th>
                <td rowspan="2">{{$settings->website_name}}<br>
                </td>
                <th>Billed To:</th>
                <td> {{ $partnerpayment->channeluser->channel_name }} <br>{{ $partnerpayment->channeluser->mobile_number }}<br>{{ $partnerpayment->channeluser->email }}</td>
            </tr>
        </table>

        <p class="section-title">Payment Details</p>
        <table class="invoice-table">
            <tr>
                <th>Payment Date</th>
                <td colspan="2">{{ \Carbon\Carbon::parse($partnerpayment->payment_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Commission Paid</th>
                <td colspan="2"> {{ number_format($partnerpayment->paid_amount, 2) }} {{ $currencySymbol }} </td>
            </tr>
            <tr>
                <th>Commission Pending</th>
                <td colspan="2">{{ number_format($partnerpayment->balance_amount, 2) }} {{ $currencySymbol }}</td>
            </tr>
            <tr>
                <th>Transaction ID</th>
                <td colspan="2">{{ $partnerpayment->transaction_id }}</td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td colspan="2">{{ $partnerpayment->payment_method == 0 ? 'Manual Payment' : 'Automatic Payment' }}</td>
            </tr>
        </table>

        <!-- Footer Note -->
        <div class="footer-note">
            <p>Thank you!</p>
        </div>
    </div>

</body>
</html>
