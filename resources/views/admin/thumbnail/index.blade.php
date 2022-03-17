@extends('admin.master')


@section('content')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />

<div id="content-page" class="content-page">
    <div class="container-fluid">
       <div class="row">
          <div class="col-sm-12">
             <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">Thumbnail Setting</h4>
                   </div>
                </div>

                  <div class="iq-card-body table-responsive">
                     <div class="table-view">
                        <table class="table table-striped table-bordered table movie_table " style="width:100%" id="Thumbnail">
                           <thead>
                              <tr>
                                 <th>S.No</th>
                                 <th>Name</th>
                                 <th>Status</th>
                              </tr>
                           </thead>
                        <form method="POST" action="{{url('admin/ThumbnailSetting_Store')}}" accept-charset="UTF-8">
                        @csrf 
                           <tbody>
                                <td> {{ '1'}} </td>
                                <td> {{ 'Title'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="title" type="checkbox" @if( $thumbnail_setting->title == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                           </tbody>

                           <tbody>
                                <td> {{ '2'}} </td>
                                <td> {{ 'Age'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="age" type="checkbox" @if( $thumbnail_setting->age == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>


                            <tbody>
                                <td> {{ '3'}} </td>
                                <td> {{ 'Rating'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="rating" type="checkbox" @if( $thumbnail_setting->rating == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>

                            <tbody>
                                <td> {{ '4'}} </td>
                                <td> {{ 'Published Year'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="published_year" type="checkbox" @if( $thumbnail_setting->published_year == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>


                            <tbody>
                                <td> {{ '5'}} </td>
                                <td> {{ 'Duration'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="duration" type="checkbox" @if( $thumbnail_setting->duration == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>


                            {{-- <tbody>
                                <td> {{ '6'}} </td>
                                <td> {{ 'Category'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="category" type="checkbox" @if( $thumbnail_setting->category == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody> --}}


                            <tbody>
                                <td> {{ '6'}} </td>
                                <td> {{ 'Featured'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="featured" type="checkbox" @if( $thumbnail_setting->featured == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>

                            {{-- <tbody>
                                <td> {{ '8'}} </td>
                                <td> {{ 'Play button'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="play_button" type="checkbox" @if( $thumbnail_setting->play_button == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody> --}}

                            <tbody>
                                <td> {{ '7'}} </td>
                                <td> {{ 'Free or Cost label'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="free_or_cost_label" type="checkbox" @if( $thumbnail_setting->free_or_cost_label == "1") checked  @endif >
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

<style>
    
</style>

{{-- Jquery Table --}}
@section('javascript')
   <script>
      $(document).ready( function () {
               $('#Thumbnails').DataTable();
      });
   </script>
@stop

