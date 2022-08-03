@extends('admin.master')

@include('admin.favicon')

@section('content')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Landing Page</h4>
                  </div>

                  <div class="col-md-6" align="right">	
                     <a href="{{ route('landing_page_create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> Add New</a>
                  </div>
               </div>

                  @if (Session::has('message'))
                     <div id="successMessage" class=" col-md-12 alert alert-info">{{ Session::get('message') }}</div>
                  @endif 

                  <div class="iq-card-body table-responsive p-0" >
                     <div class="table-view">
                       <table class="table table-striped table-bordered table movie_table iq-card" style="width:100%" >
                          <thead>
                             <tr class="r1">
                                <th>S.No</th>
                                <th>Name</th>
                                <th> {{ ucwords('Set as Front Page') }} </th>
                                <th>Action</th>
                             </tr>
                          </thead>
                       
                           @forelse ($landing_pages as $key => $landing_page)
                              <tbody>
                                 <td> {{ $key + 1 }} </td>
                                 <td> {{ $landing_page->title ? $landing_page->title  :  ucwords("no title") }} </td>
                                 <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="status" class="status" id="{{ 'landing_id'.$landing_page->landing_page_id }}" type="radio" @if( $landing_page->status == "1") checked  @endif  data-landing-page-id={{ $landing_page->landing_page_id }} onchange="update_status(this)"  >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                                 <td>

                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" data-original-title="Edit Video" 
                                       href="{{ route( 'landing_page_edit', $landing_page->landing_page_id ) }}">
                                       <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>">
                                    </a>

                                    <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" 
                                       onclick="return confirm('Are you sure?')" href="{{ route( 'landing_page_delete', $landing_page->landing_page_id ) }}">
                                       <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>">
                                    </a>
                                 </td>
                              </tbody>
                                 
                           @empty
                               
                           @endforelse
                               
                       </table>
                     </div>
                  </div>
               </div>
           </div>
       </div>
   </div>
</div>

@include('admin.Landing_page.landing_page_Script')


