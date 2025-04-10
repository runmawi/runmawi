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
        </div>

        <div class="d-flex">
            <a class="black" href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
            <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
            <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>
            <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
            <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;"
                href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">OTP Credentials Setting</a>
        </div>

        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container">
                    <div class="admin-section-title">
                        <h4><i class="entypo-globe"></i> OTP Credentials Setting </h4>
                        <hr>
                    </div>
                    <div class="clear"></div>

                    <form method="POST" action="{{ route('admin.OTP-Credentials-update') }}" accept-charset="UTF-8">
                        @csrf

                        <div class="row col-md-6">
                            <label>{{ ucfirst(trans('Enable OTP')) }} <small>( signup & Login )</small> </label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="status" class="status" id="status" type="checkbox"@if (!is_null($AdminOTPCredentials) && $AdminOTPCredentials->status == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Enable</div>
                            </div>
                        </div>
                        <br>

                        <div class="row md-12">
                            <div class="col-md-6">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>OTP Through</label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <select class="form-control otp_vai" name="otp_vai">
                                            <option value=" "> Select the OTP Through</option>
                                            <option value="fast2sms"{{ @$AdminOTPCredentials->otp_vai == 'fast2sms' ? 'selected' : null }}> fast2sms </option>
                                            <option value="24x7sms"{{ @$AdminOTPCredentials->otp_vai == '24x7sms' ? 'selected' : null }}> 24x7 sms </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 fast2sms_div"style="{{ @$AdminOTPCredentials->otp_vai == 'fast2sms' ? 'display=none !important;' : 'display: none !important' }} ">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> API KEY - fast2sms </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" class="form-control" name="otp_fast2sms_api_key" id="otp_fast2sms_api_key" value="{{ !empty($AdminOTPCredentials->otp_fast2sms_api_key) ? $AdminOTPCredentials->otp_fast2sms_api_key : null }}" placeholder="fast2sms API Key" />
                                    </div>
                                </div>
                            </div>

                            {{-- 24x7sms div --}}
                            <div class="col-md-6 24x7sms_div" style="{{ @$AdminOTPCredentials->otp_vai == '24x7sms' ? 'display=none !important;' : 'display: none !important' }} ">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> API KEY - 24x7sms </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" class="form-control" name="otp_24x7sms_api_key" id="otp_24x7sms_api_key" value="{{ !empty($AdminOTPCredentials->otp_24x7sms_api_key) ? $AdminOTPCredentials->otp_24x7sms_api_key : null }}" placeholder="xxxxxxxxxxxxxx" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        {{-- 24x7sms div --}}
                        <div class="24x7sms_div" style="{{ @$AdminOTPCredentials->otp_vai == '24x7sms' ? '' : 'display: none;' }}">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-link text-dark font-weight-bold text-uppercase" 
                                        data-toggle="collapse" data-target="#TEMPLATE-BASED-div" 
                                        aria-expanded="false" aria-controls="TEMPLATE-BASED-div">
                                    TEMPLATE BASED
                                </button>
                                
                                <button type="button" class="btn btn-link text-dark font-weight-bold text-uppercase" 
                                        data-toggle="collapse" data-target="#INTL-TEMPLATE-div" 
                                        aria-expanded="false" aria-controls="INTL-TEMPLATE-div">
                                    INTL TEMPLATE
                                </button>
                            </div>
                        </div>
                        
                        <div class="accordion" id="smsTemplatesAccordion">
                            <!-- TEMPLATE BASED SECTION -->
                            <div id="TEMPLATE-BASED-div" class="collapse" aria-labelledby="headingOne" data-parent="#smsTemplatesAccordion">
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0">
                                            <div class="panel-heading">
                                                <div class="panel-title"><label> Sender ID </label></div>
                                                <div class="panel-options">
                                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                                </div>
                                            </div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="otp_24x7sms_sender_id" id="otp_24x7sms_sender_id" 
                                                       value="{{ !empty($AdminOTPCredentials->otp_24x7sms_sender_id) ? $AdminOTPCredentials->otp_24x7sms_sender_id : null }}" 
                                                       placeholder="xxxxxxxxxxxxxx" />
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0">
                                            <div class="panel-heading">
                                                <div class="panel-title"><label> DLT Template ID </label></div>
                                                <div class="panel-options">
                                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                                </div>
                                            </div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="DLTTemplateID" id="DLTTemplateID" 
                                                       value="{{ !empty($AdminOTPCredentials->DLTTemplateID) ? $AdminOTPCredentials->DLTTemplateID : null }}" 
                                                       placeholder="xxxxxxxxxxxxxx" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row col-md-12 mt-10">
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0">
                                            <div class="panel-heading">
                                                <div class="panel-title"><label> Template Message </label></div>
                                                <div class="panel-options">
                                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                                </div>
                                            </div>
                                            <div class="panel-body" style="display: block;">
                                                <textarea class="form-control" name="template_message" cols="30" rows="5" 
                                                        placeholder="Template custom Message">{{ @$AdminOTPCredentials->template_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- INTL TEMPLATE SECTION -->
                            <div id="INTL-TEMPLATE-div" class="collapse" aria-labelledby="headingTwo" data-parent="#smsTemplatesAccordion">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0">
                                            <div class="panel-heading">
                                                <div class="panel-title"><label> Sender ID </label></div>
                                                <div class="panel-options">
                                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                                </div>
                                            </div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="otp_24x7sms_INTL_sender_id" id="otp_24x7sms_INTL_sender_id" 
                                                       value="{{ !empty($AdminOTPCredentials->otp_24x7sms_INTL_sender_id) ? $AdminOTPCredentials->otp_24x7sms_INTL_sender_id : null }}" 
                                                       placeholder="xxxxxxxxxxxxxx" />
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0">
                                            <div class="panel-heading">
                                                <div class="panel-title"><label> Template Message </label></div>
                                                <div class="panel-options">
                                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                                </div>
                                            </div>
                                            <div class="panel-body" style="display: block;">
                                                <textarea class="form-control" name="INTL_template_message" cols="30" rows="5" 
                                                    placeholder="Template custom Message">{{ @$AdminOTPCredentials->INTL_template_message }}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-body mt-3 ml-2 text-right">
                            <input type="submit" value="Update" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        {{-- OTP Logs --}}

        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container">
                    <div class="admin-section-title">
                        <h4><i class="entypo-globe"></i> OTP Logs </h4>
                        <hr>
                    </div>
                    <div class="clear"></div>

                    <div class="iq-card-body table-responsive">
                        <div class="table-view">
                            <table id="otp-logs-table"
                                class="table table-striped table-bordered text-center table movie_table "
                                style="width:100%">
                                <thead>
                                    <tr class="r1">
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>logs</th>
                                        <th>Request id</th>
                                        <th>Mobile number</th>
                                        <th>OTP Platform</th>
                                        <th>Status</th>
                                        <th>User Id</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($OTP_Logs as $key => $OTP_Logs_details)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ @$OTP_Logs_details->name ??  '-' }} </td>
                                            <td style="color:{{  @$OTP_Logs_details->status == "true" ? "green" : "red"  }}">
                                                {{ @$OTP_Logs_details->message }}
                                            </td>
                                            <td> {{ @$OTP_Logs_details->request_id ?? "-" }} </td>
                                            <td> {{ @$OTP_Logs_details->Mobile_number }} </td>
                                            <td> {{ @$OTP_Logs_details->otp_vai }} </td>
                                            <td> {{ @$OTP_Logs_details->status == "true" ? "Sent" : "Not Sent" }} </td>
                                            <td> {{ @$OTP_Logs_details->User_id ??  '-' }}</td>
                                            <td> {{ @$OTP_Logs_details->created_at_format ?? "-"}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.collapse').on('show.bs.collapse', function() {
                $('.collapse').not(this).collapse('hide');
            });
        
            $('.otp_vai').on('change', function() {
                $('#smsTemplatesAccordion .collapse').not(this).collapse('hide');
                $('.24x7sms_div, .fast2sms_div').hide();
                var selectedProvider = $(this).val();
                $('.' + selectedProvider + '_div').show();
                
                $('.collapse').collapse('hide');
            });
        
            $('#smsTemplatesAccordion .collapse').on('shown.bs.collapse', function() {
                $('#smsTemplatesAccordion .collapse').not(this).collapse('hide');
            });
            
            $('#otp-logs-table').DataTable();

        });
    </script>
@stop