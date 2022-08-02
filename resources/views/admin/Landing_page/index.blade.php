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

                  <div class="iq-card-body table-responsive p-0">
                     <div class="table-view">
                       <table class="table table-striped table-bordered table movie_table iq-card" style="width:100%" id="Thumbnail">
                          <thead>
                             <tr class="r1">
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Status</th>
                             </tr>
                          </thead>
                       
                          <tbody>
                               <td> {{ '1'}} </td>
                               <td> {{ 'Title'}} </td>
                               <td> 
                                   {{ 'ss ' }}
                               </td>
                          </tbody>
                       </table>
                     </div>
                  </div>
               </div>
           </div>
       </div>
   </div>
</div>
