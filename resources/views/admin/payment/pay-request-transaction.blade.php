@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
@endsection

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<style>
    .card-title {
        font-size: 24px;
    }

    .form-label {
        margin-bottom: 0.25rem;
        font-size: 12px;
        line-height: 18px;
        font-weight: 500;
        color: #6D7175;
    }

    select.selectpicker {
        background: #fff;
        font-size: 14px;
        line-height: 20px;
        padding: .375rem .85rem;
        border: 1px solid #e5e5e5;
        border-radius: .25rem;
        min-height: calc(2em + 0.625rem)
    }

    .custom-cc-heading {
        color: #202223;
        font-size: 13px;
        font-style: normal;
        font-weight: 500;
        line-height: 19px;
    }

    .custom-cc-top {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    div#customDateRange {
        position: absolute;
        right: 0;
        top: 20%;
        z-index: 9;
        background: white;
        border: 1px solid;
        border-radius: 5px;
        padding: 10px;
    }


    /* table css */


    #table_data a {
        text-decoration: none !important;
        min-width: fit-content;
        width: fit-content;
        width: -webkit-fit-content;
        width: -moz-fit-content;
    }

    #table_data a,
    #table_data button {
        transition: 0.5s;
    }

    #table_data a {
        font-size: 16px;
    }

    #table_data a {
        outline: none !important;
    }

    #table_data .padding_1 {
        padding: 1rem;
    }

    #table_data .padding_2 {
        padding: 2rem;
    }

    #table_data .padding_3 {
        padding: 3rem;
    }

    #table_data .padding_4 {
        padding: 4rem;
    }

    #table_data .relative {
        position: relative;
    }

    /*********************************
         MEDIA QUERY
**********************************/
    @media (max-width: 720px) {
        #table_data .flex {
            flex-wrap: wrap;
        }

        #table_data .padding_1,
        #table_data .padding_2,
        #table_data .padding_3,
        #table_data .padding_4 {
            padding: 1rem;
        }

        #table_data a {
            font-size: 12px;
        }
    }

    /*SMALL SCREEN*/
    @media (max-width: 300px) {

        #table_data .padding_1,
        #table_data .padding_2,
        #table_data .padding_3,
        #table_data .padding_4 {
            padding: 0.5rem;
        }

        #table_data a {
            font-size: 10px;
        }
    }

    /*********************************
            MAIN
**********************************/


    #table_data main {
        width: 100%;
        overflow-x: auto;
        padding: 1rem;
    }

    #table_data table {
        margin: auto;
        width: 100%;
        overflow: hidden;
        background-color: #fff;
        border-radius: 10px;
        position: relative;
        border-collapse: collapse;
        z-index: 1;
        color: var(--gray);
        white-space: nowrap;
    }

    #table_data tbody tr:not(:last-child) {
        border-bottom: 1px solid rgba(1, 1, 1, 0.2);
    }

    #table_data th,
    #table_data td {
        padding: 1rem;
        gap: 10px;
        position: relative;
        cursor: default;
        text-align: left;
        font-size: 13px;
    }

    #table_data td:last-child:hover a {
        color: #000;
    }

    #table_data thead {
        background-color: #e4ecfe;
    }

    #table_data th {
        text-transform: uppercase;
    }

    #table_data td img {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 5px;
    }

    tr td:last-child,
    tr td:nth-last-child(2),
    tr td:nth-last-child(3),
    tr td:nth-last-child(4),
    tr td:nth-last-child(6),
    tr td:nth-last-child(7),
    tr td:nth-last-child(8),
    tr td:nth-last-child(9) {
        text-align: center;
    }

    #table_data tr:hover {
        background-color: #f9f9f9;
    }


    #table_data table a {
        color: #2b3c56;
        font-size: 13px;
    }

    #table_data table a:hover {
        color: var(--primary);
    }

    #table_data .table thead th {
        font-size: 13px;
    }

    /*ICONS*/
    #table_data .fa-arrow-up {
        color: var(--green);
    }

    #table_data .fa-arrow-down {
        color: var(--red);
    }

    #table_data .fa-mars {
        color: var(--blue);
    }

    #table_data .fa-venus {
        color: var(--pink);
    }

    #table_data .active,
    #table_data .inactive {
        /* padding: 0rem 0.8rem; */
        border-radius: 40px;
    }

    .pagination {
        justify-content: end;
    }

    #table_data .active {
        background-color: #eef2fe;
        color: var(--primary);
    }

    #table_data .inactive {
        background-color: #fff0ee;
        color: var(--red);
    }

    /*PROGRESS BAR*/
    #table_data .progress {
        display: inline-block;
        background-color: var(--lite);
        border-radius: 40px;
        width: 60px;
        height: 10px;
        position: relative;
        overflow: hidden;
    }

    #table_data .progress em {
        position: absolute;
        left: 0;
        top: 0;
        height: 10px;
        background-color: var(--primary);
    }


    @media (max-width: 720px) {
        #table_data main {
            background: var(--primary);
        }

        #table_data table {
            background-color: transparent;
        }

        #table_data main {
            overflow-y: auto;
            height: 100%;
        }

        #table_data table thead {
            display: none;
        }

        #table_data table td {
            width: 100%;
            display: block;
            text-align: right;
        }


        #table_data table td:not(:last-child) {
            border-bottom: 1px solid rgba(1, 1, 1, 0.2);
        }

        #table_data table td:before {
            content: attr(data-label);
            z-index: 1;
            float: left;
            color: var(--black);
        }

        #table_data tr {
            background-color: var(--white);
            border-radius: 5px;
            display: block;
            margin: 0.5rem 0;
        }

        #table_data tbody tr {
            border-bottom: none;
        }

        #table_data tr td {
            text-align: center !important;
        }

        #table_data td span.bg-lightgreen {
            background-color: #eef2fe;
            color: #5487fa;
        }

        #table_data td span.bg-lightcoral {
            background-color: #fff0ee;
            color: #f33e5d;
            padding: 5px 14px;
            border-radius: 20px;
        }

        #table_data td:last-child:hover:after {
            left: auto;
            right: 10%;
            transform: translate(50%, 50%);
        }

        #table_data th,
        #table_data td {
            padding: 0.5rem 1rem;
        }
    }
</style>

@section('content')
    <div id="content-page" class="content-page">
        <h4 class="card-title text-primary mb-4">Pay Request Transaction:</h4>

        <div class="table_data" id="table_data">
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered text-center table movie_table" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col" class="text-center">User ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Source ID</th>
                                <th scope="col">Source Type</th>
                                <th scope="col">Platform</th>
                                <th scope="col">Transform form</th>
                                <th scope="col">Amount</th>
                                <th scope="col">date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Pay_Request_Transaction as $key => $data)
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td class="text-center">{{ $data->user_id ?? 'N/A' }}</td>
                                    <td>
                                        <img src="https://i.postimg.cc/FR5xjr4g/user.png" alt="User Icon" />
                                        {{ $data->user_id->username ?? 'N/A' }}
                                    </td>
                                    <td>{{  $data->source_id ? $data->source_id : 'N/A' }}</td>
                                    <td>{{  $data->source_type ? ucwords($data->source_type) : 'N/A' }}</td>
                                    <td>{{  $data->platform ? ucwords($data->platform) : 'N/A' }}</td>
                                    <td>{{ $data->transform_form ? ucwords($data->transform_form) : 'N/A' }}</td>
                                    <td>${{ number_format($data->amount, 2) }}</td>
                                    <td>{{ $data->date ? $data->date : 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection