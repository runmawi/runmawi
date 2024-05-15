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

    .media-body {
        border-left: 0px !important;
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
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <div id="content-page" class="content-page">
        <div class="d-flex">
            <a class="black" href="{{ URL::to('admin/home-settings') }}">HomePage</a>
            <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
            <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
            <a class="black" href="{{ URL::to('admin/AdminOTPCredentials    ') }}">Email Settings</a>
            <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
            <a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
            <a class="black" href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
        </div>

        <div class="d-flex">
            <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
            <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>
            <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
            <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
            <a class="black"  href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">OTP Credentials Setting</a>
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ route('admin.users-package') }}" class="iq-waves-effect">Users Package Management</a>

        </div>

        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container">
                    <div class="admin-section-title">
                        <h4><i class="entypo-globe"></i> Users Package Management </h4>
                        <hr>
                    </div>
                    <div class="clear"></div>

                    <form method="POST" action="{{ route('admin.users-package-update') }}" accept-charset="UTF-8" >
                        @csrf

                        <div class="row md-12">
                            <div class="col-md-4">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> {{ _('Users') }}</label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                       <select  class="form-control"  name="user_id" >
                                            <option value= {{ null }} > {{ _('select the user') }} </option>
                                            @foreach( $users as $key => $user )
                                                <option value="{{ $user->id }}"> {{ $user->email }} </option>
                                            @endforeach
                                       </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> {{ _('Package') }} </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <select  class="form-control"  name="package" >
                                            <option value= {{ null }} > {{ _('select the package') }} </option>
                                           <option value="Basic"> Basic </option>
                                           <option value="Pro">   Pro </option>
                                           <option value="Business"> Business </option>
                                           <option value="CPP"> CPP </option>
                                           <option value="Channel "> Channel  </option>
                                        </select>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> {{ _('Package Ends Date') }}</label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <input type="Date" class="form-control" name="package_ends" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="panel-body mt-3 ml-2 text-right">
                            <input type="submit" value="Update" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop