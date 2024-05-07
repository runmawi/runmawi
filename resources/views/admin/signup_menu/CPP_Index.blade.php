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
                      <h4 class="card-title">CPP Signup Menu </h4>
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
                        <form method="POST" action="{{url('admin/CPP_Signupmenu_Store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf 
                        <input type="hidden" id="id" vaule="{{ @$CPPSignupMenu->id }}">
                           <tbody>
                                <td> {{ '1'}} </td>
                                <td> {{ 'Profile Name'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="username" class="username" id="username" type="checkbox" @if( @$CPPSignupMenu->username == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                           </tbody>

                           <tbody>
                                <td> {{ '2'}} </td>
                                <td> {{ 'Profile Email'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="email" id="email" class="email" type="checkbox" @if( @$CPPSignupMenu->email == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>


                            <tbody>
                                <td> {{ '3'}} </td>
                                <td> {{ 'Profile Mobile Number'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="mobile" class="mobile" id="mobile" type="checkbox" @if( @$CPPSignupMenu->mobile == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>

                            <tbody>
                                <td> {{ '4'}} </td>
                                <td> {{ 'Profile Image'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="image" class="image" id="image" type="checkbox" @if( @$CPPSignupMenu->image == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>

                            <tbody>
                                <td> {{ '5'}} </td>
                                <td> {{ 'Profile Best Work'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="upload_video" class="upload_video" id="upload_video" type="checkbox" @if( @$CPPSignupMenu->upload_video == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>      

                            <tbody>
                                <td> {{ '6'}} </td>
                                <td> {{ 'Profile Password'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="password" class="password" id="password" type="checkbox" @if( @$CPPSignupMenu->password == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>


                            <tbody>
                                <td> {{ '7'}} </td>
                                <td> {{ 'Profile Password Confirm'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="password_confirm" class="password_confirm" id="password_confirm" type="checkbox" @if( @$CPPSignupMenu->password_confirm == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>      

                        </table>

                        <div class="col-md-12 form-group" align="right">
                            <input type="submit" value="Update Settings" class="btn btn-primary " />
                        </div>
                    </form>
                     </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.thumbnail.Thumbnail_Script')

<style>
    .swal2-popup.swal2-modal.swal2-show {
        width: 24% !important;
    }
</style>

  