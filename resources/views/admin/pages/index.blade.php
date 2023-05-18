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
</style>

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="admin-section-title">
                <div class="">
                    <div class="row">
                        <div class="col-md-4">
                            <h4><i class="entypo-newspaper"></i> Page</h4>
                        </div>

                        <div class="col-md-8" align="right">
                            <a href="{{ URL::to('admin/pages/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="clear"></div>

                    <div class="gallery-env" style="padding:15px;">
                        <div class="row">
                            <table class="table table-bordered genres-table text-center iq-card">
                                <tr class="table-header r1">
                                    <th>Page</th>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    @foreach ($pages as $page)
                                <tr>

                                    <td><a href="{{ URL::to('page/'.$page->slug) }}"  target="_blank">{{ $page->title }}</a> </td>
                                    <td valign="bottom"> <p> {{ $page->slug }} </p> </td>
                                    <td> 
										<div class="mt-1">
											<label class="switch">
												<input name="page_status" class="page_status" id="{{ 'page_'.$page->id }}" type="checkbox" @if( $page->active == "1") checked  @endif data-page-id={{ $page->id }}  data-type="pages" onchange="update_page_banner(this)" >
												<span class="slider round"></span>
											</label>
										</div>
									</td>
                                    <td>
                                        <div class="align-items-center list-user-action">
                                            <a href="{{ URL::to('admin/pages/edit/'.$page->id) }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
												<img class="ply" src="{{ URL::to('assets/img/icon/edit.svg') }}">
											</a>
                                            <a href="{{ URL::to('admin/pages/delete/'.$page->id)  }}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top"  data-original-title="Delete">
												<img class="ply" src="{{ URL::to('assets/img/icon/delete.svg') }}" onclick="return confirm('Are you sure?')">
											</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <div class="clear"></div>
                            <div class="pagination-outter"><?= $pages->render() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $ = jQuery;
            $(document).ready(function() {
                $('.delete').click(function(e) {
                    e.preventDefault();
                    if (confirm("Are you sure you want to delete this page?")) {
                        window.location = $(this).attr('href');
                    }
                    return false;
                });
            });
    
		function update_page_banner(ele){

		var page_id = $(ele).attr('data-page-id');
		var status   = '#page_'+page_id;
		var Page_Status = $(status).prop("checked");

		if(Page_Status == true){
			var pge_status  = '1';
			var check = confirm("Are you sure you want to active this Page?");  

		}else{
			var pge_status  = '0';
			var check = confirm("Are you sure you want to remove this Page?");  
		}


		if(check == true){ 

		$.ajax({
					type: "POST", 
					dataType: "json", 
					url: "{{ route('page_status_update') }}",
						data: {
							_token  : "{{csrf_token()}}" ,
							page_id: page_id,
							page_status: pge_status,
					},
					success: function(data) {
						if(data.message == 'true'){
							// location.reload();
						}
						else if(data.message == 'false'){
							swal.fire({
							title: 'Oops', 
							text: 'Something went wrong!', 
							allowOutsideClick:false,
							icon: 'error',
							title: 'Oops...',
							}).then(function() {
								location.href = '{{ URL::to('admin/pages') }}';
							});
						}
					},
				});
		}else if(check == false){
			$(status).prop('checked', true);
		}
		}
	</script>
    @stop