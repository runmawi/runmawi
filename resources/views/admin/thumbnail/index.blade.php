@include('admin.master')

@section('content')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />

<div id="content-page" class="content-page">
    <div class="container-fluid">
       <div class="row">
          <div class="col-sm-12">
             <div class="">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">Thumbnail Setting</h4>
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
                        <form method="POST" action="{{url('admin/ThumbnailSetting_Store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf 
                           <tbody>
                                <td> {{ '1'}} </td>
                                <td> {{ 'Title'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="title" class="title" id="title" type="checkbox" @if( $thumbnail_setting->title == "1") checked  @endif >
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
                                            <input name="age" id="age" class="age" type="checkbox" @if( $thumbnail_setting->age == "1") checked  @endif >
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
                                            <input name="rating" class="rating" id="rating" type="checkbox" @if( $thumbnail_setting->rating == "1") checked  @endif >
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
                                            <input name="published_year" class="published_year" id="published_year" type="checkbox" @if( $thumbnail_setting->published_year == "1") checked  @endif >
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
                                            <input name="duration" class="duration" id="duration" type="checkbox" @if( $thumbnail_setting->duration == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>


                            <tbody>
                                <td> {{ '6'}} </td>
                                <td> {{ 'Featured'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="featured" class="featured" id="featured" type="checkbox" @if( $thumbnail_setting->featured == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>

                            
                            <tbody>
                                <td> {{ '7'}} </td>
                                <td> {{ 'Free or Cost label'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="free_or_cost_label" class="free_or_cost_label" id="free_or_cost_label" type="checkbox" @if( $thumbnail_setting->free_or_cost_label == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                            </tbody>

                            <tbody>
                                <td> {{ '8'}} </td>
                                <td> {{ 'Play button'}} </td>
                                <td> 
                                    <div class="mt-1 text-center">
                                        <div>
                                        @if(!empty($thumbnail_setting->play_button))
                                            <img src="{{ URL::to('/') . '/assets/img/' . $thumbnail_setting->play_button }}" style="max-height: 10%; max-width: 10%" />
                                        @endif
                                            </div>
                                        <div class="col-md-12 mt-2 tex-center">
                                        <input name="play_button8 " type="file"  id="play_button" class="form-control"></div>
                                    </div>
                                </td>
                            </tbody>


                            <tbody>
                                <td> {{ '9' }} </td>
                                <td> {{ 'Category'}} </td>
                                <td> 
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="category" class="category" id="category" type="checkbox" @if( $thumbnail_setting->category == "1") checked  @endif >
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

