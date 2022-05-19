@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
    .p1{
        font-size: 12px;
    }
     .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>
@section('css')
    <style type="text/css">
    .code_editor{
        min-height:300px;
    }

	.has-switch .switch-on label {
			background-color: #FFF;
			color: #000;
			}
	.make-switch{
		z-index:2;
	}
    
	</style>
@stop
<meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@section('content')
<div id="content-page" class="content-page">
    <div class="d-flex">
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/home-settings') }}">HomePage</a>
        <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
        <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
        <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
        <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
        <a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
    </div>
   
    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
        <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
        <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
        <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
        <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>

            <div class="container-fluid p-0">
            <div class="tab">
  <button class="tablinks1" >Web Home Page</button>
  <button class="tablinks2" >Mobile Home Page</button>
</div>

                <div id="webhomesetting">
                <div class="iq-card">
<div class="admin-section-title">

    <h4><i class="entypo-monitor"></i> Home Page Settings</h4> 
</div>
<div class="clear"></div>


<form action="{{ URL::to('/admin/home-settings/save')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="panel panel-primary mt-3" data-collapsed="0">
            <div class="panel-heading"> <div class="panel-title"><label>Listing Home Page video</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                <div class="panel-body"> 
                        <div class="row align-items-center p-2">
                        <!-- <div class="row"> -->
                            
                           <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> @if ($order_settings_list[0]->header_name) {{ @$order_settings_list[0]->header_name }} @else {{ ""  }} @endif  </label></div>
                              
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                          <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input name="featured_videos" type="checkbox"  @if ($settings->featured_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                         <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[1]->header_name) {{ @$order_settings_list[1]->header_name }} @else {{ ""  }} @endif </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($settings->latest_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="latest_videos" id="latest_videos">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> @if ($order_settings_list[2]->header_name) {{ @$order_settings_list[2]->header_name }} @else {{ ""  }} @endif </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input  type="checkbox"  name="category_videos"   @if ($settings->category_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                           <div class="ml-2">ON</div>
                                    </div>
                                 
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[3]->header_name) {{ @$order_settings_list[3]->header_name }} @else {{ ""  }} @endif </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($settings->live_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="live_videos" id="live_videos">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[5]->header_name) {{ @$order_settings_list[5]->header_name }} @else {{ ""  }} @endif </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($settings->audios == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="audios" id="audios">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[6]->header_name) {{ @$order_settings_list[6]->header_name }} @else {{ ""  }} @endif </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($settings->albums == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="albums" id="albums">
                                        <span class="slider round"></span>
                                        </label>
                                         <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[4]->header_name) {{ @$order_settings_list[4]->header_name }} @else {{ ""  }} @endif </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($settings->series == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="series" id="series">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                        <!-- </div> -->
                        

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[7]->header_name) {{ @$order_settings_list[7]->header_name }} @else {{ ""  }} @endif  </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                           <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($settings->Recommendation  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="Recommendation" id="Recommendation">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Auto Intro Skip  </label></div>
                              
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($settings->AutoIntro_skip  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="AutoIntro_skip" id="AutoIntro_skip">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>


                        <!-- </div> -->
        </div>
                        
<div class="row ">
    <div class="col-md-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mt-3" name="submit"> Save Settings</button>
    </div>
</div>

                
</form>
    </div>
    </div>
    </div>

    </div>
    


    <!-- --------------------------------------------------mobile setting--------------------------------------------------- -->

    <div id = "Mobilehomesetting">
    <div class="iq-card">
<div class="admin-section-title">
    
    
    <h4><i class="entypo-monitor"></i> Mobile Home Page Settings</h4> 
</div>
<div class="clear"></div>


<form action="{{ URL::to('/admin/mobile-home-settings/save')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="panel panel-primary mt-3" data-collapsed="0">
            <div class="panel-heading"> <div class="panel-title"><label>Listing Home Page video</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                <div class="panel-body"> 
                        <div class="row align-items-center p-2">
                        <!-- <div class="row"> -->
                            
                           <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> @if ($order_settings_list[0]->header_name) {{ @$order_settings_list[0]->header_name }} @else {{ ""  }} @endif  </label></div>
                              
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                          <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input name="featured_videos" type="checkbox"  @if ($mobilesettings->featured_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                         <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[1]->header_name) {{ @$order_settings_list[1]->header_name }} @else {{ ""  }} @endif </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($mobilesettings->latest_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="latest_videos" id="latest_videos">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> @if ($order_settings_list[2]->header_name) {{ @$order_settings_list[2]->header_name }} @else {{ ""  }} @endif </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input  type="checkbox"  name="category_videos"   @if ($mobilesettings->category_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                           <div class="ml-2">ON</div>
                                    </div>
                                 
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[3]->header_name) {{ @$order_settings_list[3]->header_name }} @else {{ ""  }} @endif </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($mobilesettings->live_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="live_videos" id="live_videos">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[5]->header_name) {{ @$order_settings_list[5]->header_name }} @else {{ ""  }} @endif </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($mobilesettings->audios == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="audios" id="audios">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[6]->header_name) {{ @$order_settings_list[6]->header_name }} @else {{ ""  }} @endif </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($mobilesettings->albums == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="albums" id="albums">
                                        <span class="slider round"></span>
                                        </label>
                                         <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[4]->header_name) {{ @$order_settings_list[4]->header_name }} @else {{ ""  }} @endif </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($mobilesettings->series == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="series" id="series">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                    
                                </div>
                            </div>
                        <!-- </div> -->
                        

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1">  @if ($order_settings_list[7]->header_name) {{ @$order_settings_list[7]->header_name }} @else {{ ""  }} @endif  </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                           <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($mobilesettings->Recommendation  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="Recommendation" id="Recommendation">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Auto Intro Skip  </label></div>
                              
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch mt-2">
                                        <input type="checkbox"  @if ($mobilesettings->AutoIntro_skip  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="AutoIntro_skip" id="AutoIntro_skip">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>


                        <!-- </div> -->
        </div>
                        
<div class="row ">
    <div class="col-md-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mt-3" name="submit"> Save Settings</button>
    </div>
</div>

                
</form>
    </div>
    </div>
    </div>
    </div>


			<div class="col-md-8 d-flex justify-content-between">
				<h4><i class="entypo-list"></i> Order Home Page</h4>
                <!-- <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a> -->
			</div>

            
		
	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header d-flex ">
                    <h4 class="modal-title">New Menu Item</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/menu/store') }}" method="post">
				        <label for="name">Enter the new menu item name below</label>
				        <input name="name" id="name" placeholder="Menu Item Name" class="form-control" value="" /><br />
				        <label for="url">Menu Item URL (ex. /site/url)</label>
				        <input name="url" id="url" placeholder="URL" class="form-control" value="" /><br />
				        <label for="dropdown">or Dropdown for:</label>
				        <div class="clear"></div>
				        <input type="radio" class="menu-dropdown-radio" name="type" value="none" checked="checked" /> None
				        <input type="radio" class="menu-dropdown-radio" name="type" value="videos" /> Video Categories 
                        <input type="radio" class="menu-dropdown-radio" name="type" value="audios" /> Audio Categories
				        <input type="radio" class="menu-dropdown-radio" name="type" value="posts" /> Post Categories
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-menu">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-menu">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
		
		<div class="col-md-8 p-0">
		<div class="panel panel-primary menu-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<p class="p1">Organize the Menu Items below: (max of 3 levels)</p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="">
		
            <table id="table " class="table table-bordered iq-card text-center">
              <thead>
                <tr class="r1 ">
                  <th width="30px">#</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach($order_settings as $order_homepage)
    	            <tr class="row1" data-id="{{ $order_homepage->id }}">
    	              <td class="pl-3"><i class="fa fa-sort"></i>{{ $order_homepage->id }}</td>
    	              <td>{{ $order_homepage->header_name }}</td>
                      <td><a href="{{ URL::to('/admin/order_homepage/edit/') }}/{{ $order_homepage->id }}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
					 <!-- <a href="{{ URL::to('/admin/order_homepage/delete/') }}/{{ $order_homepage->id }}"  class="iq-bg-danger ml-2" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a></td> -->
<!-- </div> -->
    	            </tr>
                @endforeach
              </tbody>                  
            </table>
						
				</div>
		
			</div>
		
            </div></div></div></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	<?php if(isset($_GET['menu_first_level'])): ?>
		<input type="hidden" id="menu_first_level" value="1" />
	<?php endif; ?>
    @stop

	@section('javascript')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script type="text/javascript">
      $(function () {
        // $("#table").DataTable();

        $( "#tablecontents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });

          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ url('admin/order_homepage/update') }}",
                data: {
              order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });
    </script>
		<script src="{{ URL::to ('/assets/admin/js/jquery.nestable.js') }}"></script>
        <script>
        $('#webhomesetting').show();
        $('#Mobilehomesetting').hide();
        
    $('.tablinks1').click(function(){
        $('#webhomesetting').show();
        $('#Mobilehomesetting').hide();
    });
    $('.tablinks2').click(function(){
        $('#webhomesetting').hide();
        $('#Mobilehomesetting').show();
    });
</script>
		<script type="text/javascript">

		jQuery(document).ready(function($){


			if($('#menu_first_level').val() == 1){
				console.log('yup!');
				toastr.warning('Should only be added as a top level menu item!', "Video Or Post Category Menu Item", opts);
			}

			$('#nestable').nestable({ maxDepth: 3 });

			$('#add-new .menu-dropdown-radio').change(function(){
				changeNewMenuDropdownRadio($(this));
			});

			// Add New Menu
			$('#submit-new-menu').click(function(){
				$('#new-menu-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-menu').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-menu .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this menu item?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
				if($('.video_post').parents('.dd-list').length > 1){
					console.log('show error');
					window.location = '/admin/menu?menu_first_level=true';
				} else {
					alert('test');
	    			$('.menu-panel').addClass('reloading');
	    			$.post('/admin/menu/order', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val() }, function(data){
	    				console.log(data);
	    				$('.menu-panel').removeClass('reloading');
	    			});

	    		}

			});


		});

		function changeNewMenuDropdownRadio(object){
			if($(object).val() == 'none'){
				$('#new-menu-form #url').removeAttr('disabled');
			} else {
				$('#new-menu-form #url').attr('disabled', 'disabled');
			}
		}

		</script>


<script src="<?= THEME_URL ?>/assets/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?= THEME_URL ?>/assets/js/admin-homepage.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ URL::to('/assets/admin/js/bootstrap-switch.min.js') }}"></script>
	<script>
	    var editor = ace.edit("custom_css");
	    editor.setTheme("ace/theme/textmate");
		editor.getSession().setMode("ace/mode/css");

		var textarea = $('textarea[name="custom_css"]').hide();
		editor.getSession().setValue(textarea.val());
		editor.getSession().on('change', function(){
		  textarea.val(editor.getSession().getValue());
		});

		var editor2 = ace.edit("custom_js");
	    editor2.setTheme("ace/theme/textmate");
		editor2.getSession().setMode("ace/mode/javascript");

		var textarea2 = $('textarea[name="custom_js"]').hide();
		editor2.getSession().setValue(textarea2.val());
		editor2.getSession().on('change', function(){
		  textarea2.val(editor2.getSession().getValue());
		});

	</script>
<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				$(this).val(this.checked ? 1 : 0);
			});

		});

	</script>
<!--
        <script>
            $(document).ready(function() { 
            $( ".theme_color" ).on("click", function() { 
            if($(this).is(":checked")) {
            $(this).val(1); } else { $(this).val(0);
            }}); $( ".theme_color" ).on("click", function() { 
            if($(this).is(":checked")) {
            $(this).val(1); } else { $(this).val(0);
            }});});
        </script>
-->
@stop
