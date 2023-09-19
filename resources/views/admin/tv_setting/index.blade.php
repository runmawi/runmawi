@extends('admin.master')
<style type="text/css">
    .has-switch .switch-on label {
        background-color: #FFF;
        color: #000;
    }
    label {
        font-size: 16px!important;
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

    .black {
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
        border-radius: 0px 4px 4px 0px;
    }

    .black:hover {
        background: #fff;
        padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
    
</style>
@section('css')
    <style type="text/css">
        .code_editor {
            min-height: 300px;
        }

        .has-switch .switch-on label {
            background-color: #FFF;
            color: #000;
        }

        .make-switch {
            z-index: 2;
        }
    </style>
@stop
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css" />
<link rel="stylesheet" type="text/css"
    href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@section('content')
    <div id="content-page" class="content-page">
        <div class="d-flex">
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;"
                href="{{ URL::to('admin/home-settings') }}">HomePage</a>
            <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
            <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
            <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
            <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
            <a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
        </div>

        <div class="d-flex">
            <a class="black" href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
            <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
            <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>
            <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
            <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
        </div>

        <div class="container-fluid p-0">

        
    <div class="clear"></div>

<div class="col-md-8 p-0">
    <div class="panel panel-primary menu-panel" data-collapsed="0">

        <div class="panel-heading">
            <div class="panel-title">
            </div>

            <div class="panel-options">
                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            </div>
        </div>


        <div class="">

            <table id="table " class="table table-bordered iq-card text-center">
                <thead>
                    <tr class="r1 ">
                        <th width="30px">#</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tablecontents">
                    @foreach ($TVSetting as $key => $Setting)
                        <tr class="row1" data-id="{{ $Setting->id }}">

                            <td class="pl-3"><i class="fa fa-sort"></i>{{ $Setting->id }}</td>

                            <td>{{ $Setting->name }}  <span style="color:#7a7474; font-size: 12px; "> {{ $key == '23' || $key == '24' || $key == '25' ? "(Only for Mobile Home Setting )" : "" }} </span> </td>

                            <td><a href="{{ URL::to('/admin/tv-settings/edit/') }}/{{ $Setting->id }}"
                                    class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="Edit"><img class="ply" src="{{ URL::to('assets/img/icon/edit.svg') }}"></a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>