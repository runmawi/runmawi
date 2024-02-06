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
</style>
@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid" style=" overflow: scroll">
            <div class="admin-section-title">
                <div class="">
                    <div class="row">

                        <div class="col-md-4">
                            <h4><i class="entypo-archive"></i>Translation Languages </h4>
                        </div>

                        <div class="col-md-8" align="right">
                            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i
                                    class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>


                    <!-- Add New Modal -->
                    <div class="modal fade" id="add-new">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">New Language</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>

                                </div>

                                <div class="modal-body">
                                    <form id="new-cat-form" accept-charset="UTF-8"
                                        action="{{ URL::to('admin/translate-languages-store') }}" method="post"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                                        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                                            <label>Name:</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Language Name">
                                        </div>

                                        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                                            <label>Language Code:</label>
                                            <input type="text" id="code" name="code" class="form-control"
                                                placeholder="Language Code">
                                        </div>

                                        <label for="name">Active</label>
                                            <div class="mt-1 d-flex align-items-center justify-content-around">
                                                <div class="mr-2">OFF</div>
                                                    <label class="switch mt-2">
                                                        <input  type="checkbox"  name="status">
                                                        <span class="slider round"></span>
                                                    </label>
                                                <div class="ml-2">ON</div>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Modal -->
                    <div class="modal fade" id="update-category">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">New Language</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form id="new-cat-form" accept-charset="UTF-8"
                                        action="{{ URL::to('admin/languages/store') }}" method="post"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                                        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                                            <label>Name:</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Language Name">
                                        </div>

                                        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                                            <label>Language Code:</label>
                                            <input type="text" id="code" name="code" class="form-control"
                                                placeholder="Language Code">
                                        </div>

                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>


                    <div class="panel panel-primary category-panel" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                <label class="">Organize the Languages below: </label>
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div id="nestable p-0" class="nested-list dd with-margins">
                                <table class="table table-bordered iq-card text-center">
                                    <tr class="table-header r1">
                                        <th><label> S.No </label></th>
                                        <th><label> Name </label></th>
                                        <th><label> Action</label></th>
                                    <tr>
                                        @forelse($TranslationLanguage as $key => $language)
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $language->name ? $language->name : 'No Language Name Found' }}</td>

                                            <td class="">
                                                <div class=" align-items-center list-user-action">

                                                    <a href="{{ URL::to('admin/translate-languages-edit/'.$language->id) }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="Edit"><img class="ply" src="{{ URL::to('assets/img/icon/edit.svg') }}">
													</a>

                                                    <a href="{{ URL::to('admin/translate-languages-delete/'.$language->id ) }}" onclick="return confirm('Are you sure?')"
														class="iq-bg-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete">
														<img class="ply" src="{{ URL::to('assets/img/icon/delete.svg') }}">
													</a>
                                                </div>
                                            </td>
                                    </tr>
                                @empty
                                    @endforelse
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />
        </div>

        @section('javascript')

            <script src="<?= URL::to('/assets/admin/js/jquery.nestable.js') ?>"></script>

            <script type="text/javascript">
                jQuery(document).ready(function($) {

                    $('#nestable').nestable({
                        maxDepth: 3
                    });

                    // Add New Category
                    $('#submit-new-cat').click(function() {
                        $('#new-cat-form').submit();
                    });

                    $('.actions .edit').click(function(e) {
                        $('#update-category').modal('show', {
                            backdrop: 'static'
                        });
                        e.preventDefault();
                        href = $(this).attr('href');
                        $.ajax({
                            url: href,
                            success: function(response) {
                                $('#update-category .modal-content').html(response);
                            }
                        });
                    });

                    $('.actions .delete').click(function(e) {
                        e.preventDefault();
                        if (confirm("Are you sure you want to delete this category?")) {
                            window.location = $(this).attr('href');
                        }
                        return false;
                    });

                    $('.dd').on('change', function(e) {
                        $('.category-panel').addClass('reloading');
                        $.post('<?= URL::to('admin/videos/categories/order') ?>', {
                            order: JSON.stringify($('.dd').nestable('serialize')),
                            _token: $('#_token').val()
                        }, function(data) {
                            console.log(data);
                            $('.category-panel').removeClass('reloading');
                        });

                    });
                });
            </script>

            {{-- validation --}}

            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

            <script>
                $('form[id="new-cat-form"]').validate({
                    rules: {
                        name: "required",
                        // language_image: "required",
                    },
                    submitHandler: function(form) {
                        form.submit();
                    },
                });
            </script>
        @stop
    @stop