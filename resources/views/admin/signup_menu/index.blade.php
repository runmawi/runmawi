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
                      <h4 class="card-title">Signup Menu </h4>
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
                        <form method="POST" action="{{url('admin/Signupmenu_Store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf 
                        <input type="hidden" id="id" vaule="{{ @$SignupMenu->id }}">
                           <tbody>
                                <td> {{ '1'}} </td>
                                <td> {{ 'Profile Name'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="username" class="username" id="username" type="checkbox" @if( @$SignupMenu->username == "1") checked  @endif >
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
                                            <input name="email" id="email" class="email" type="checkbox" @if( @$SignupMenu->email == "1") checked  @endif >
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
                                            <input name="mobile" class="mobile" id="mobile" type="checkbox" @if( @$SignupMenu->mobile == "1") checked  @endif >
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
                                            <input name="avatar" class="avatar" id="avatar" type="checkbox" @if( @$SignupMenu->avatar == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>

                            <tbody>
                                <td> {{ '5'}} </td>
                                <td> {{ 'Profile DOB'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="dob" class="dob" id="dob" type="checkbox" @if( @$SignupMenu->dob == "1") checked  @endif >
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
                                            <input name="password" class="password" id="password" type="checkbox" @if( @$SignupMenu->password == "1") checked  @endif >
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
                                            <input name="password_confirm" class="password_confirm" id="password_confirm" type="checkbox" @if( @$SignupMenu->password_confirm == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>      

                            <tbody>
                                <td> {{ '8'}} </td>
                                <td> {{ 'Profile Country'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="country" class="country" id="country" type="checkbox" @if( @$SignupMenu->country == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>    


                            <tbody>
                                <td> {{ '9'}} </td>
                                <td> {{ 'Profile State'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="state" class="state" id="state" type="checkbox" @if( @$SignupMenu->state == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>    


                            <tbody>
                                <td> {{ '10'}} </td>
                                <td> {{ 'Profile City'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="city" class="city" id="city" type="checkbox" @if( @$SignupMenu->city == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>    


                            <tbody>
                                <td> {{ '11'}} </td>
                                <td> {{ 'Profile Support UserName'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="support_username" class="support_username" id="support_username" type="checkbox" @if( @$SignupMenu->support_username == "1") checked  @endif >
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

  