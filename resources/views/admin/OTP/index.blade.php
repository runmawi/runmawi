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
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">OTP Credentials Setting</a>
        </div>

        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container">
                    <div class="admin-section-title">
                        <h4><i class="entypo-globe"></i> OTP Credentials Setting </h4>
                        <hr>
                    </div>
                    <div class="clear"></div>

                    <form method="POST" action="{{ route('admin.OTP-Credentials-update') }}" accept-charset="UTF-8" >
                        @csrf

                        <div class="row col-md-6">
                            <label>{{ ucfirst(trans('Enable OTP')) }} <small>( signup & Login )</small> </label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="status" class="status" id="status" type="checkbox"  @if( !is_null($AdminOTPCredentials) && $AdminOTPCredentials->status == 1 ) checked @endif >
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
                                    <div class="panel-body" >
                                       <select  class="form-control otp_vai"  name="otp_vai" >
                                          <option value=" " > Select the OTP Through</option>
                                          <option value="fast2sms" {{ @$AdminOTPCredentials->otp_vai == "fast2sms" ? 'selected' : null }}  > fast2sms </option>
                                          <option value="24x7sms" {{ @$AdminOTPCredentials->otp_vai == "24x7sms" ? 'selected'  : null }}  > 24x7 sms </option>
                                       </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 fast2sms_div" style="{{ @$AdminOTPCredentials->otp_vai == 'fast2sms' ? 'display=none !important;' : 'display: none !important' }} ">
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

                        <div class="row col-md-12 24x7sms_div" style="{{ @$AdminOTPCredentials->otp_vai == '24x7sms' ? 'display=none !important;' : 'display: none !important' }} ">
                            <div class="col-md-6">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> Sender ID - 24x7 Sms </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" class="form-control" name="otp_24x7sms_sender_id" id="otp_24x7sms_sender_id" value="{{ !empty($AdminOTPCredentials->otp_24x7sms_sender_id) ? $AdminOTPCredentials->otp_24x7sms_sender_id : null }}" placeholder="xxxxxxxxxxxxxx" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> Sevice Name - 24x7 Sms </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>

                                    <div class="panel-body" >
                                        <select  class="form-control sevicename"  name="otp_24x7sms_sevicename" >
                                           <option value=" " > Select the Sevice Name</option>
                                           <option value="TEMPLATE_BASED" {{ @$AdminOTPCredentials->otp_24x7sms_sevicename == "TEMPLATE_BASED" ? 'selected' : null }}  > TEMPLATE_BASED </option>
                                           {{-- <option value="PROMOTIONAL_HIGH" {{ @$AdminOTPCredentials->otp_24x7sms_sevicename == "PROMOTIONAL_HIGH" ? 'selected'  : null }}  > PROMOTIONAL_HIGH </option>
                                           <option value="PROMOTIONAL_SPL" {{ @$AdminOTPCredentials->otp_24x7sms_sevicename == "PROMOTIONAL_SPL" ? 'selected'  : null }}  > PROMOTIONAL_SPL </option>
                                           <option value="OPTIN_OPTOUT" {{ @$AdminOTPCredentials->otp_24x7sms_sevicename == "OPTIN_OPTOUT" ? 'selected'  : null }}  > OPTIN_OPTOUT </option> --}}
                                           <option value="INTERNATIONAL" {{ @$AdminOTPCredentials->otp_24x7sms_sevicename == "INTERNATIONAL" ? 'selected'  : null }}  > INTERNATIONAL </option>
                                        </select>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                        <br>

                        <div class="row col-md-12 24x7sms_div TEMPLATE_BASED_div" style="{{ @$AdminOTPCredentials->otp_vai == '24x7sms' &&  @$AdminOTPCredentials->otp_24x7sms_sevicename == 'TEMPLATE_BASED' ? 'display=none !important;' : 'display: none !important' }} ">
                            
                            <div class="col-md-6">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> DLT Template ID - 24x7 Sms </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>

                                    <div class="panel-body" style="display: block;">
                                        <input type="text" class="form-control" name="DLTTemplateID" id="DLTTemplateID" value="{{ !empty($AdminOTPCredentials->DLTTemplateID) ? $AdminOTPCredentials->DLTTemplateID : null }}" placeholder="xxxxxxxxxxxxxx" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> Template Message - 24x7 Sms </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <textarea  class="form-control" name="template_message" id="" cols="30" rows="10" placeholder="Template custom Message">
                                            {{  @$AdminOTPCredentials->template_message }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row col-md-12 24x7sms_div INTERNATIONAL_div" style="{{ @$AdminOTPCredentials->otp_vai == '24x7sms' &&  @$AdminOTPCredentials->otp_24x7sms_sevicename == 'INTERNATIONAL' ? 'display=none !important;' : 'display: none !important' }} ">
                            <div class="col-md-6">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label> Template Message - 24x7 Sms </label></div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <textarea  class="form-control" name="INTL_template_message" id="" cols="30" rows="10" placeholder="Template custom Message">
                                            {{  @$AdminOTPCredentials->INTL_template_message }}
                                        </textarea>
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
    </div>

    <script>
        $( document ).ready(function() {

            $('.otp_vai').on('change', function() {
                $('.24x7sms_div,.fast2sms_div').hide();
                var otp_vai_div = ( $(this).find(":selected").val() );
                $( '.' + otp_vai_div +'_div' ).show();

                if (otp_vai_div == "24x7sms") {

                    $('.TEMPLATE_BASED_div,.INTERNATIONAL_div').hide();
                    var currentServiceName = $('.sevicename').val();

                    if ( currentServiceName == "INTERNATIONAL")  $('.INTERNATIONAL_div').show();

                    if ( currentServiceName == "TEMPLATE_BASED")  $('.TEMPLATE_BASED_div').show();
                    
                }
            });

            $('.sevicename').on('change', function() {

                $('.TEMPLATE_BASED_div,.INTERNATIONAL_div').hide();
                let TEMPLATE_div= ( $(this).find(":selected").val() );

                $( '.' + TEMPLATE_div +'_div' ).show();
            });
        });
    </script>
@stop