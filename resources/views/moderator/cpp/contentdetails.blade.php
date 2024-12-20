@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection
@section('content')
   <script src="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css"></script>
   <script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
   <script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Content Details</h4>
                            </div>

                            <div class="iq-card-header-toolbar d-flex align-items-baseline">
                                <div class="form-group mr-2">
                                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-body table-responsive p-0">
                            <div class="table-view">
                                <table class="data-tables table table-striped table-bordered iq-card text-center" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Content Partner Name</th>
                                            <th>Commission Percentage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_datas as $data)
                                        @if($all_datas)
                                            <tr>
                                                <td>{{ $data['id'] }}</td>
                                                <td>{{ $data['title'] }}</td>
                                                <td>{{ $data['type'] }}</td>
                                                <td>{{ $data['content_partner'] }}</td>
                                                @if($data['video_commission_percentage'])
                                                <td>{{ $data['video_commission_percentage'] }}%</td>
                                                @else
                                                <td>{{ $data['moderator_commission_percentage'] }}%</td>
                                                @endif
                                                <td>
                                                    @if ($data['type'] === 'Video')
                                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit Meta" href="{{ URL::to('admin/videos/edit/' . $data['id']) }}"><img
                                                                class="ply" src="<?php echo URL::to('/') . '/assets/img/icon/edit.svg'; ?>"></a>
                                                    @elseif ($data['type'] === 'Series')
                                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit Meta"
                                                            href="{{ URL::to('admin/series/edit/' . $data['id']) }}"><img class="ply"
                                                                src="<?php echo URL::to('/') . '/assets/img/icon/edit.svg'; ?>"></a>
                                                    @elseif ($data['type'] === 'Season')
                                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit Meta"
                                                            href="{{ URL::to('admin/season/edit/' . $data['id']) }}"><img class="ply"
                                                                src="<?php echo URL::to('/') . '/assets/img/icon/edit.svg'; ?>"></a>

                                                    @elseif ($data['type'] === 'Episode')
                                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit Meta"
                                                            href="{{ URL::to('admin/episode/edit/' . $data['id']) }}"><img class="ply"
                                                                src="<?php echo URL::to('/') . '/assets/img/icon/edit.svg'; ?>"></a>
                                                    @elseif ($data['type'] === 'Live Stream')
                                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit Meta"
                                                            href="{{ URL::to('admin/livestream/edit/' . $data['id']) }}"><img class="ply"
                                                                src="<?php echo URL::to('/') . '/assets/img/icon/edit.svg'; ?>"></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5">No content available</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <div style="position: relative;top: -50px;" class="pagination-outter mt-3 pull-right"><?= $all_datas->appends(Request::only('s'))->render(); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
             $('#DataTables_Table_0_paginate').hide();
         });
     </script>
@stop


