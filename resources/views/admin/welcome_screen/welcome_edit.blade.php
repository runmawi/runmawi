@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="admin-section-title">
            <div class="iq-card">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="entypo-list"></i> Welcome Screen Edit </h4>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('welcomescreen_update', ['id' => $welcome_screen->id]) }}" accept-charset="UTF-8" enctype="multipart/form-data" id="" class="mob_screens">
            @csrf     
            <div class="col-md-12">
                <div class="panel panel-primary col-md-6" data-collapsed="0"> <div class="panel-heading"> 
                    <div class="panel-title"></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                    <div class="panel-body " style="display: block;" > 
                        <p>Upload Welcome Screen</p> 
                        <img src="{{ URL::to('/') . '/public/uploads/settings/' . $welcome_screen->welcome_images }}" style="max-height:100px" />
                           <div class="col-md-9">
                                 <input type="file" multiple="true" class="form-control" name="welcome_image" id="welcome_image" accept="image/*" />
                           </div>
                    </div> 
                </div>
    
                <div class="col-md-12 form-group" align="right">
                    <input type="submit" value="Update Settings" class="btn btn-primary " />
                    <a href="{{ URL::to('admin/mobileapp') }}" class="btn btn-danger" > Cancel </a>
                </div>
            </div>
        </form>

    </div>
</div>
