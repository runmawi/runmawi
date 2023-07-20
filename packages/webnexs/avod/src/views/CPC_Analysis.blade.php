@include('avod::ads_header')

<div id="main-admin-content">
    <div id="content-page" class="content-page">
        <div class="iq-card">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="iq-card-body">
                            <h2 class="text-center mb-4"> {{ ucwords('cost pre click Analytics') }}</h2>
                            <div id="nestable" class="nested-list dd with-margins">
                                <div class="panel panel-default ">
                                    <div class="row">
                                        <div class="col-md-12 mx-0">
                                            <div id="nestable" class="nested-list dd with-margins">
                                                <table class="data-tables table audio_table " style="width:100%">

                                                    <thead>
                                                        <tr>
                                                            <th> # </th>
                                                            <th> Ads Id </th>
                                                            <th> Ads Name </th>
                                                            <th> Click Count </th>
                                                            <th> Cost Pre Click </th>
                                                            <th> Total Cost Pre Click </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($CPC_lists as $key => $CPC_list )
                                                            <tr>
                                                                <td> {{ $key + 1 }}</td>
                                                                <td> {{ $CPC_list->adveristment_id ?? '-' }} </td>
                                                                <td> {{ ucfirst(App\Advertisement::where('id', $CPC_list->adveristment_id)->pluck('ads_name')->first()) ?? '-' }} </td>
                                                                <td> {{ $CPC_list->view_count }} </td>
                                                                <td> {{ CPC_advertiser_share() }} </td>
                                                                <td> {{ CPC_advertiser_share() * $CPC_list->view_count }} </td>
                                                                <td> <a href="#" target="_blank" class="iq-bg-warning">
                                                                    <img class="ply" src="{{ URL::to('assets/img/icon/view.svg') }}"></a>
                                                                </td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('avod::ads_footer')

</div>
<input type="hidden" id="base_url" value="<?php echo URL::to('/') . '/advertiser'; ?>">

<!-- Imported styles on this page -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/popper.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/dataTables.bootstrap4.min.js' ?>"></script>
<!-- Appear JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.appear.js' ?>"></script>
<!-- Countdown JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/countdown.min.js' ?>"></script>
<!-- Select2 JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/select2.min.js' ?>"></script>
<!-- Counterup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/waypoints.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.counterup.min.js' ?>"></script>
<!-- Wow JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/wow.min.js' ?>"></script>
<!-- Slick JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/slick.min.js' ?>"></script>
<!-- Owl Carousel JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/owl.carousel.min.js' ?>"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.magnific-popup.min.js' ?>"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/smooth-scrollbar.js' ?>"></script>
<!-- apex Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/apexcharts.js' ?>"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/chart-custom.js' ?>"></script>
<!-- Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/custom.js' ?>"></script>
<!-- End Notifications -->

@yield('javascript')
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript">
    <?php if(session('success')){ ?>
    toastr.success("<?php echo session('success'); ?>");
    <?php }else if(session('error')){  ?>
    toastr.error("<?php echo session('error'); ?>");
    <?php }else if(session('warning')){  ?>
    toastr.warning("<?php echo session('warning'); ?>");
    <?php }else if(session('info')){  ?>
    toastr.info("<?php echo session('info'); ?>");

    <?php } ?>
</script>
</body>

</html>
