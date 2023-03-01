@extends('admin.master')

@include('admin.favicon')

@section('content')

    <style>
        .theme_image:hover {
            border: 2px solid rgb(64, 172, 37);

            border-radius: 25px;
        }

        .theme_image {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 25px;
            margin: 0 15px;
        }

        .theme_name {
            color: #000;

            text-align: center;
            /* font-family: 'FontAwesome';*/
        }

        .active {
            color: #1ba31b;
            position: absolute;
            left: 15px;
            font-family: unset;
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

    <div id="content-page" class="content-page">
        <div class="d-flex">
            <a class="black" href="{{ URL::to('admin/home-settings') }}">HomePage</a>
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
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;"
                href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
        </div>

        <div class="container-fluid p-0">

            <div class="admin-section-title">
                <div class="iq-card">
                    <div class="row">
                        <div class="col-md-4">
                            <h4><i class="entypo-list"></i> Slider Setting </h4>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="sign-in-from  m-auto">

                            <div class="row data">

                                    {{-- Slider 1 --}}

                                <div class="theme_image col-md-3 mb-3">
                                    <div class="zoom themes">
                                        <img class="theme_img w-100"
                                            src="{{ URL::asset('public/images/') . '/'  }}"
                                            alt="theme" id={{ '1' }}>
                                    </div>

                                    <div class="theme_name">
                                        {{ "Slider 1" }}
                                        @if ( $slider_choosen == 1 )
                                            <span class="active">
                                                <img height="20" width="20" class="" src="<?php echo URL::to('/assets/img/yes.png'); ?>">
                                                {{ 'Active' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                    {{-- Slider 2 --}}

                                <div class="theme_image col-md-3 mb-3">
                                    <div class="zoom themes">
                                        <img class="theme_img w-100"
                                            src="{{ "http://localhost/flicknexs/public/images/Default-Theme.png"  }}"
                                            alt="theme" id={{ '2' }}>
                                    </div>

                                    <div class="theme_name">
                                        {{ "Slider 2"}}
                                        @if ( $slider_choosen == 2 )
                                            <span class="active">
                                                <img height="20" width="20" class="" src="<?php echo URL::to('/assets/img/yes.png'); ?>">
                                                {{ 'Active' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('javascript')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".theme_img,#test").click(function() {
                slider_id = this.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'To Apply this Slider!',
                    icon: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("admin_slider_set") }}',
                            type: "get",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: slider_id,
                            }
                        }).done(function() {
                            swal.fire({
                                title: 'Applied',
                                text: 'Slider has been successfully Changed',
                                allowOutsideClick: false,
                                type: 'success',
                                icon: 'success',
                            }).then(function() {
                                location.href =
                                    '{{ route("admin_slider_index") }}';
                            });
                        });
                    }
                });
            });

        });
    </script>
@stop
