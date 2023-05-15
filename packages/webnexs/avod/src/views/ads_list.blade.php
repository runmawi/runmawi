@include('avod::ads_header')

<div id="main-admin-content">
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="justify-content-between d-flex">
                           <h2 class=" mb-3">Advertisement List</h2>
                            <a href="{{ URL::to('advertiser/upload_ads') }}" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> Add New Ads</a>
                        </div>
                       
                        <div id="nestable" class="nested-list dd with-margins">
                            <table class="data-tables table audio_table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Ads Name </th>
                                        <th> Ads Type </th>
                                        <th> Ads Category </th>
                                        <th> Ads Position Play </th>
                                        <th> Location </th>
                                        <th> Total Views </th>
                                        <th> Status </th>
                                        <th> Created At </th>
                                        <th> Action </th>

                                        {{-- <th> Total cost per click </th>
                                        <th> Total cost per View </th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($advertisements as $key => $advertisement)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $advertisement->ads_name }}</td>
                                            <td>{{ ucwords($advertisement->ads_upload_type) }}</td>
                                            <td>{{ ucwords($advertisement->ads_category) ?  ucwords($advertisement->ads_category) : "-" }}</td>
                                            <td>{{ ucfirst($advertisement->ads_position) }}</td>
                                            <td>{{ ucfirst($advertisement->location) }}</td>
                                            <td>{{ get_views($advertisement->id) }}</td>
                                            <td>
                                                <span class="badge {{ $advertisement->status == 1 ? 'badge-success' : ($advertisement->status == 2 ? 'badge-danger' : 'badge-info') }}">
                                                   {{ $advertisement->status == 1 ? 'Approved' : ($advertisement->status == 2 ? 'Disapproved' : 'Pending') }}
                                                </span>
                                             </td>
                                            <td>{{ $advertisement->created_at->format('d/M/y') }}</td>
                                            <td>
                                                <a href="#" target="_blank" class="iq-bg-warning"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                                <a href="#" class="iq-bg-success ml-2 mr-2"><img class="ply " src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                                <a href="#" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                            </td>

                                             {{-- <td>{{ get_revenue($advertisement->id) }}</td>
                                            <td>{{ get_cpv($advertisement->id) }}</td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12">No advertisements found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('avod::ads_footer')


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
