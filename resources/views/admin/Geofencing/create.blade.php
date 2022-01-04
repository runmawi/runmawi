@extends('admin.master')

@section('content')
<style type="text/css">
    table th, table td
    {
        width: 100px;
        padding: 5px;
        border: 1px solid #ccc;
    }
    .selected
    {
        background-color: #666;
        color: #fff;
    }
</style>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />
<div id="content-page" class="content-page">
         <div class="container-fluid">

        <div class="admin-section-title">
            <div class="iq-card">
            <div class="row">
                <div class="col-md-4">
                    <h4><i class="entypo-archive"></i>Geofencing Setting </h4>
                </div>
            </div>
            <form method="POST" action="{{url('admin/Geofencing/store')}}" accept-charset="UTF-8">
                @csrf 
            <input type="hidden" name="id" value="{{ ($Geofencing !='') ? $Geofencing->id  : '' }}">

            <div class="container">
                <div class="col-md-3" style="
                margin-left: 30%;">
              
                    <span style="float:left">Disable</span>
                    <span style="float:right">Enable</span>

                    <label class="toggle">
                        <div class="form-group">
                             <input type="checkbox" name="geofencing" @if($Geofencing !=null && $Geofencing->geofencing == "ON") checked  @endif >
                              <span class="slide round"></span>
                        </div>
                    </label>
                </div>

                <div class="button button1">
                    <button type="submit" class="btn btn-hover ab" >Save Changes</button>
                </div>
            </div>

        </form>

    </div>
  </div>
</div>
@endsection

<style>
    .container {
    /* box-sizing: content-box; */
    width: 70% !important;
    height: 30% !important;
    padding: 30px !important;
    border: 3px solid #f5f5f5;
    border-radius: 45px;
    margin-top: 36px;
}


.toggle {
  position: relative;
  display: inline-block;
  width: 78px;
  height: 40px;
  margin-left: 38px;
  margin-bottom: 31px !important;

}

.toggle input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slide {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slide:before {
  position: absolute;
  content: "";
  height: 30px;
  width: 30px;
  left: 10px;
  bottom: 5px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slide {
  background-color: #45bb44;
}

input:focus + .slide {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slide:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slide.round {
  border-radius: 36px;
}

.slide.round:before {
  border-radius: 52%;
}
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  margin-left: 36%;

}
.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #4CAF50;
}
    </style>