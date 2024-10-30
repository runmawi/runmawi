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
        <div class="d-flex">
            <a class="black" href="{{ URL::to('admin/home-settings') }}">HomePage</a>
            <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
            <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
            <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
            <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
            <a class="black" href="{{ URL::to('admin/mobileapp') }}">RTMP URL Settings</a>
        </div>

        <div class="d-flex">
            <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
            <a class="black" href="{{ URL::to('admin/partner_monetization_setting/index') }}">Revenue Settings</a>
            <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
            <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
            <a class="black" href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;"
                href="{{ URL::to('admin/partner_monetization_settings/index') }}">Partner Monetization Settings</a>
        </div>

        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container">

                    <div class="admin-section-title">
                        <h4><i class="entypo-globe"></i> Update Partner Monetization Settings</h4>
                        <hr>
                    </div>
                    <div class="clear"></div>
                    <form method="POST" action="{{ URL::to('admin/partner_monetization_settings/update') }}"
                        accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        <div class="row mt-4">

                            <div class="col-md-4">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>Monetization View Limit</label></div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i
                                                    class="entypo-down-open"></i></a> </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" class="form-control" name="viewcount_limit"
                                            id="viewcount_limit"
                                            value="@if (!empty($partner_monetization_settings->viewcount_limit)) {{ $partner_monetization_settings->viewcount_limit }} @endif" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>Amount per view</label></div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i
                                                    class="entypo-down-open"></i></a> </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" class="form-control" name="views_amount"
                                            id="views_amount"
                                            value="@if (!empty($partner_monetization_settings->views_amount)) {{ $partner_monetization_settings->views_amount }} @endif" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" name="id" value="<?= isset($partner_monetization_settings->id) ?>" />
                        <div class="panel-body mt-3" style="display: flex; justify-content: flex-end;">
                            <input type="submit" value="Update Partner Monetization Settings"
                                class="btn btn-primary " />
                        </div>                                                     
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
