@include('avod::ads_header')

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<style>
    .table td,
    .table th {
        padding: 0;
        vertical-align: baseline !important;
    }
    #progressbar li img{
        width: 50px !important;
        cursor: not-allowed;
    }
    #progressbar li {
        cursor: text;
    }
</style>

<div id="main-admin-content">
    <div id="content-page" class="content-page">
        <div class="iq-card">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="iq-card-body">
                            <div class="container">
                                <h4 class="mb-4 pl-3">Upload Advertisement</h4>
                            </div>
                            <div id="nestable" class="nested-list dd with-margins">

                                <!-- MultiStep Form -->

                                <div class="row">
                                    <div class="col-md-12 p-0">
                                        <form id="msform" accept-charset="UTF-8"
                                            action="{{ URL::to('advertiser/store_ads') }}" method="post"
                                            enctype="multipart/form-data">

                                            <ul id="progressbar">
                                                <li class="active" id="account">
                                                    <img src="{{ URL::to('/assets/img/icon/ads1.svg') }}">Ads Info
                                                </li>

                                                <li id="personal">
                                                    <img src="{{ URL::to('/assets/img/icon/ads2.svg') }}">Upload Ads
                                                </li>

                                                <li id="payment">
                                                    <img src="{{ URL::to('/assets/img/icon/ads3.svg') }}">Choose Region
                                                </li>

                                                <li id="payment">
                                                    <img src="{{ URL::to('/assets/img/icon/ads4.svg') }}">Ads Schedule
                                                </li>
                                            </ul>

                                            <!--General Information  fieldsets -->
                                            <fieldset>
                                                <div class="form-card p-0">
                                                    {{-- <h4 class="fs-title ">General Information</h4> --}}
                                                    <div class="row col-md-12">
                                                        <div
                                                            class="form-group mb-0 col-md-3 p-0 d-flex align-items-baseline ">
                                                            <label class="mb-0">Age: </label>
                                                        </div>

                                                        <div class="col-md-11 "></div>

                                                        <div class="row p-1">

                                                            <div class="row  ages ">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age"  name="age[]" value="0-17" /> 0-17
                                                                </label>
                                                            </div>

                                                            <div class="row  ages ">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age"  name="age[]" value="18-24" /> 18-24
                                                                </label>
                                                            </div>

                                                            <div class="row  ages ">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age" name="age[]" value="25-34" /> 25-34
                                                                </label>
                                                            </div>

                                                            <div class="row ages">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age"  name="age[]" value="35-44" /> 35-44
                                                                </label>
                                                            </div>

                                                            <div class="row  ages">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age"  name="age[]" value="45-54" /> 45-54
                                                                </label>
                                                            </div>

                                                            <div class="row  ages ">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age"  name="age[]" value="55-64" /> 55-64
                                                                </label>
                                                            </div>

                                                            <div class="row  ages">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age" name="age[]" value="65+" /> 65+
                                                                </label>
                                                            </div>

                                                            <div class="row  ages ">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" class="age"  name="age[]" value="all" /> All 
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group mb-0 col-md-8 d-flex align-items-baseline">
                                                            <label>Gender:</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="js-example-basic-multiple form-control"
                                                                name="gender[]" multiple="multiple" id="gender">
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div> <br>

                                                    <div class="row">                            
                                                        <div class="col-sm-6">
                                                            <label class="m-0">Advertisement Devices</label>
                                                            <div class="panel-body">
                                                                <select  name="ads_devices[]" class="js-example-basic-multiple" style="width:100%" multiple="multiple">
                                                                    <option value="website"> {{ ucwords('website') }} </option>
                                                                    <option value="android"> {{ ucwords('android') }} </option>
                                                                    <option value="IOS"> {{ ucwords('IOS') }} </option>
                                                                    <option value="TV"> {{ ucwords('TV') }} </option>
                                                                    <option value="roku"> {{ ucwords('roku') }} </option>
                                                                    <option value="lg"> {{ ucwords('lg') }} </option>
                                                                    <option value="samsung"> {{ ucwords('samsung') }} </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="button" name="next" class="next action-button"
                                                    value="Next Step" id="Next1" />
                                            </fieldset>

                                            <!--Ads Details  fieldsets -->

                                            <fieldset>
                                                <div class="form-card">
                                                    {{-- <h2 class="fs-title">Ads Details</h2> --}}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <div class="d-flex align-items-baseline">
                                                                    <label>Ads Name:</label>
                                                                    <p class="error-message ml-1"   style="color: red;font-size:10px;">(This Field    is required)</p>
                                                                </div>
                                                                <input type="text" id="ads_name" name="ads_name" required class="from-control" placeholder="Enter the Ads Name" />
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Ads Category:</label>
                                                                <select class="form-control" name="ads_category">
                                                                    @foreach ($ads_category as $key => $category)
                                                                        <option value="{{ $category->id }}">
                                                                            {{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label> Ads Position Play:</label>
                                                                <select class="form-control" name="ads_position">
                                                                    <option value="pre">Pre</option>
                                                                    <option value="mid">Mid</option>
                                                                    <option value="post">Post</option>
                                                                    <option value="all">All Position</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-baseline">
                                                                    <label> Ads upload Type:</label>
                                                                    <p class="error-message ml-1"
                                                                        style="color: red;font-size:10px;">(This Field is required)</p>
                                                                </div>
                                                                <select class="form-control ads_type" name="ads_upload_type" >
                                                                    <option selected="selected" value="null">Select Ads Type </option>
                                                                    <option value="tag_url">Ad Tag Url </option>
                                                                    <option value="ads_video_upload">Ads Video Upload
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group tag_url">
                                                                <label> Ad Tag Url:</label>
                                                                <input type="text" id="ads_path" name="ads_path" 
                                                                    class="form-control" placeholder="Enter the Ads Tag URL" />
                                                            </div>

                                                            <div class="form-group ads_video_upload">
                                                                <label> Ads Video Upload:</label>
                                                                <input type="file" id="ads_video" name="ads_video" accept="video/mp4" class="form-control" />
                                                            </div>

                                                            <div class="form-group ads_video_upload">
                                                                <label> Ads Redirection URL:</label>
                                                                <input type="url" id="ads_redirection_url" name="ads_redirection_url"  
                                                                    placeholder="https://example.com" pattern="https://.*" class="form-control" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <input type="button" name="previous"
                                                    class="previous action-button-previous" value="Previous" />
                                                <input type="button" name="next" class="next action-button"
                                                    value="Next Step" id="Next2" />

                                            </fieldset>

                                            <!--Location fieldsets -->

                                            <fieldset>
                                                <div class="form-card">
                                                    {{-- <h2 class="fs-title">Location Details</h2> --}}

                                                    <div class="row">
                                                        <div class="col-sm-1">
                                                            <input type="radio" class="location-hide" id="" name="location" value=" " />
                                                        </div>

                                                        <div class="col-sm-4" style="margin-left:-30px;">
                                                             <label class="">{{ ucwords('all countries & territories') }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-1"> 
                                                            <input type="radio"  class="location-hide" id="" name="location" value="India" />
                                                        </div>

                                                        <div class="col-sm-1" style="margin-left:-30px;"> 
                                                            <label>India</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-1"> 
                                                            <input type="radio" class="location-show"  name="location"  value="enter_location" />
                                                        </div>

                                                        <div class="col-sm-4" style="margin-left:-30px;"> 
                                                            <label>{{ ucwords('enter the location') }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 location_input">
                                                        <div class="form-group">
                                                            <input type="text" id="locations" name="locations" class="form-control"  placeholder="Enter the Location" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                <input type="button" name="next" class="next action-button"  value="Next Step" id="Next2" />
                                            </fieldset>


                                            <!--Schedule Ads Details fieldsets -->
                                            <fieldset>
                                                <div class="form-card p-0">
                                                    {{-- <h2 class="fs-title">Set your weekly hours</h2> --}}
                                                    <div class="col-md-6"> </div>

                                                    <div class="row ">
                                                        <div class="col-sm-2">
                                                            <div class="">
                                                                <div> 
                                                                    <label class="checkbox-inline 10"    for="household_income_label">
                                                                        <input type="checkbox" id="Monday" class="date" name="date[Monday]"  value="{{ $Monday }}"
                                                                            @if (!empty($Monday_time['0'])) checked @endif />
                                                                            Monday
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-4">
                                                            @forelse ($Monday_time as $Monday_times)
                                                                <table class="table col-md-12 mb-2" id="">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="container mb-2">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class=" p-0 d-flex align-items-center">
                                                                                        <input type="time" name="Monday_Start_time[]"  class="form-control"
                                                                                            value={{ $Monday_times->start_time }} />
                                                                                        -
                                                                                    </div>
                                                                                    <div class="col-md-4 p-0">
                                                                                        <input type="time"  name="Monday_end_time[]" class="form-control"
                                                                                            value={{ $Monday_times->end_time }} />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                                    </tr>
                                                                </table>
                                                            @empty
                                                            @endforelse

                                                            <table class="table " id="Monday_add"> </table>
                                                        </div>

                                                        <div class="col-sm-1">
                                                            <span  class="Monday_add ">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-sm-2 ">
                                                            <div class="">
                                                                <div><label class="checkbox-inline 10"
                                                                        for="household_income_label">
                                                                        <input type="checkbox" id="Tuesday"
                                                                            class="date" name="date[Tuesday]"
                                                                            value="{{ $Tuesday }}"
                                                                            @if (!empty($Tuesday_time['0'])) checked @endif />
                                                                        Tuesday
                                                                    </label></div>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-4">
                                                            @forelse ($Tuesday_time as $tuesday_tym)
                                                                <table class="table " id="">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class=" p-0 d-flex align-items-center">
                                                                                        <input type="time"
                                                                                            name="tuesday_start_time[]"
                                                                                            class="form-control"
                                                                                            value="{{ $tuesday_tym->start_time }}" />-
                                                                                    </div>
                                                                                    <div class="p-0"><input
                                                                                            type="time"
                                                                                            name="Tuesday_end_time[]"
                                                                                            class="form-control"
                                                                                            id=""
                                                                                            value="{{ $tuesday_tym->end_time }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td><i class="fa-solid fa-trash-can remove-tr">
                                                                            </i></td>
                                                                    </tr>
                                                                </table>
                                                            @empty
                                                            @endforelse

                                                            <table class="table" id="Tuesday_add"> </table>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <span id="" class="Tuesday_add ">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-sm-2 ">
                                                            <div class="d-flex justify-content-between">
                                                                <div> <label class="checkbox-inline 10"
                                                                        for="household_income_label">
                                                                        <input type="checkbox" class="date"
                                                                            id="Wednesday" name="date[Wednesday]"
                                                                            value="{{ $Wednesday }}"
                                                                            @if (!empty($Wednesday_time['0'])) checked @endif />
                                                                        Wednesday
                                                                    </label></div>
                                                                <div> </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            @forelse ($Wednesday_time as $tym)
                                                                <table class="table " id="">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div  class="col-md-4 p-0 d-flex align-items-center">
                                                                                        <input type="time"
                                                                                            name="wednesday_start_time[]"
                                                                                            class="form-control"
                                                                                            value="{{ $tym->start_time }}" />-
                                                                                    </div>

                                                                                    <div class="col-md-4 p-0"><input
                                                                                            type="time"
                                                                                            name="wednesday_end_time[]"
                                                                                            class="form-control"
                                                                                            id=""
                                                                                            value="{{ $tym->end_time }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                        <td>  <i class="fa-solid fa-trash-can remove-tr"></i></td>
                                                                    </tr>
                                                                </table>
                                                            @empty
                                                            @endforelse

                                                            <table class="table " id="wednesday_add"> </table>
                                                        </div>
                                                        <div class="col-sm-1"><span class="wednesday_add">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span></div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-sm-2">
                                                            <div class="d-flex justify-content-between">
                                                                <div><label class="checkbox-inline 10"
                                                                        for="household_income_label">
                                                                        <input type="checkbox" class="date"
                                                                            id="thrusday" name="date[thrusday]"
                                                                            value="{{ $Thrusday }}"
                                                                            @if (!empty($Thursday_time['0'])) checked @endif />
                                                                        Thrusday
                                                                    </label></div>
                                                                <div> </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-4">
                                                            @forelse ($Thursday_time as $tym)
                                                                <table class="table col-md-12" id="">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-md-4 p-0 d-flex align-items-center">
                                                                                        <input type="time"
                                                                                            name="thursday_start_time[]"
                                                                                            class="form-control"
                                                                                            value="{{ $tym->start_time }}" />-
                                                                                    </div>
                                                                                    <div class="col-md-4 p-0"><input
                                                                                            type="time"
                                                                                            name="thursday_end_time[]"
                                                                                            class="form-control"
                                                                                            id=""
                                                                                            value="{{ $tym->end_time }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                        <td><i class="fa-solid fa-trash-can remove-tr">
                                                                            </i></td>
                                                                    </tr>
                                                                </table>
                                                            @empty
                                                            @endforelse

                                                            <table class="table col-md-12" id="thrusday_add"> </table>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <span id="add" class="thrusday_add">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-sm-2 ">
                                                            <div class="d-flex justify-content-between">
                                                                <div> <label class="checkbox-inline 10"
                                                                        for="household_income_label">
                                                                        <input type="checkbox" class="date"
                                                                            id="friday" name="date[friday]"
                                                                            value="{{ $Friday }}"
                                                                            @if (!empty($Friday_time['0'])) checked @endif />
                                                                        Friday
                                                                    </label></div>
                                                                <div> </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-4">
                                                            @forelse ($Friday_time as $tym)
                                                                <table class="table " id="">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-md-4 p-0 d-flex align-items-center">
                                                                                        <input type="time"
                                                                                            name="friday_start_time[]"
                                                                                            class="form-control"
                                                                                            value="{{ $tym->start_time }}" />-
                                                                                    </div>
                                                                                    <div class="col-md-4 p-0">
                                                                                        <input type="time"
                                                                                            name="friday_end_time[]"
                                                                                            class="form-control"
                                                                                            id=""
                                                                                            value="{{ $tym->end_time }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                        <td><i class="fa-solid fa-trash-can remove-tr">
                                                                            </i></td>
                                                                    </tr>
                                                                </table>
                                                            @empty
                                                            @endforelse

                                                            <table class="table" id="friday_add"> </table>
                                                        </div>
                                                        <div class="col-sm-1"><span id="add"
                                                                class="friday_add ">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span></div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-sm-2">
                                                            <div class="d-flex justify-content-between">
                                                                <div><label class="checkbox-inline 10"
                                                                        for="household_income_label">
                                                                        <input type="checkbox" class="date"
                                                                            id="saturday" name="date[saturday]"
                                                                            value="{{ $Saturday }}"
                                                                            @if (!empty($Saturday_time['0'])) checked @endif />
                                                                        Saturday
                                                                    </label></div>
                                                                <div> </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">

                                                            @forelse ($Saturday_time as $tym)
                                                                <table class="table " id="">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-md-4 p-0 d-flex align-items-center">
                                                                                        <input type="time"
                                                                                            name="saturday_start_time[]"
                                                                                            class="form-control"
                                                                                            value="{{ $tym->start_time }}" />-
                                                                                    </div>
                                                                                    <div class="col-md-4 p-0"><input
                                                                                            type="time"
                                                                                            name="saturday_end_time[]"
                                                                                            class="form-control"
                                                                                            id=""
                                                                                            value="{{ $tym->end_time }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                        <td><i class="fa-solid fa-trash-can remove-tr">
                                                                            </i></td>
                                                                    </tr>
                                                                </table>
                                                            @empty
                                                            @endforelse

                                                            <table class="table" id="saturday_add"> </table>
                                                        </div>
                                                        <div class="col-sm-1"><span id="add"
                                                                class="saturday_add">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span></div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-sm-2">
                                                            <div class="d-flex justify-content-between">
                                                                <div><label class="checkbox-inline 10"
                                                                        for="household_income_label">
                                                                        <input type="checkbox" class="date"
                                                                            id="sunday" name="date[sunday]"
                                                                            value="{{ $Sunday }}"
                                                                            @if (!empty($Sunday_time['0'])) checked @endif />
                                                                        Sunday
                                                                    </label></div>
                                                                <div> </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">

                                                            @forelse ($Sunday_time as $tym)
                                                                <table class="table " id="">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-md-4 p-0 d-flex align-items-center">
                                                                                        <input type="time"
                                                                                            name="saturday_start_time[]"
                                                                                            class="form-control"
                                                                                            value="{{ $tym->start_time }}" />-
                                                                                    </div>
                                                                                    <div class="col-md-4 p-0"><input
                                                                                            type="time"
                                                                                            name="saturday_end_time[]"
                                                                                            class="form-control"
                                                                                            id=""
                                                                                            value="{{ $tym->end_time }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                        <td><i class="fa-solid fa-trash-can remove-tr">
                                                                            </i></td>
                                                                    </tr>
                                                                </table>
                                                            @empty
                                                            @endforelse

                                                            <table class="table" id="sunday_add"> </table>
                                                        </div>
                                                        <div class="col-sm-1"><span id="add"
                                                                class="sunday_add">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span></div>
                                                    </div>

                                                    <input type="button" name="previous"
                                                        class="previous action-button-previous" value="Previous" />
                                                    <input type="submit" class="btn btn-primary action-button"
                                                        id="submit-update-cat" value="Save" style="padding: 10px 5px !important;" />

                                                </div>
                                            </fieldset>
                                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    Copyright 2023 <a href="<?php echo URL::to('home'); ?>"><?php $settings = App\Setting::first();
                    echo $settings->website_name; ?></a> All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
</div>


</div>

<!-- Imported styles on this page -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/popper.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/dataTables.bootstrap4.min.js' ?>"></script>
<!-- Appear JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.appear.js' ?>"></script>
<!-- Countdown JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/countdown.min.js' ?>"></script>
<!-- Select2 JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/select2.min.js' ?>"></script>
<!-- Counterup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/waypoints.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.counterup.min.js' ?>"></script>
<!-- Wow JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/wow.min.js' ?>"></script>
<!-- Slick JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/slick.min.js' ?>"></script>
<!-- Owl Carousel JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/owl.carousel.min.js' ?>"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.magnific-popup.min.js' ?>"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/smooth-scrollbar.js' ?>"></script>
<!-- apex Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/apexcharts.js' ?>"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/chart-custom.js' ?>"></script>
<!-- Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/custom.js' ?>"></script>
<!-- End Notifications -->

@yield('javascript')
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBROO3Md6_fZD5_fd1u8VTlRxd4VdJnAWU&libraries=places&sensor=false">
</script>

<script>
    var i = 0;

    $(".Monday_add").click(function() {
        ++i;
        $('#Monday').prop('checked', true);
        $("#Monday_add").append(
            '<tr> <td> <div class="container"> <div class="row mb-2"> <div class=" p-0 d-flex align-items-center"> <input type="time" name="Monday_Start_time[]"   class="form-control" />-</div> <div class=" p-0"> <input type="time" name="Monday_end_time[]" class="form-control" id=""/> </div> </div> </div> </td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>'
        );
    });

    $(".Tuesday_add").click(function() {
        ++i;
        $('#Tuesday').prop('checked', true);
        $("#Tuesday_add").append(
            '<tr> <td> <div class="container"> <div class="row mb-2"> <div class=" p-0 d-flex align-items-center"> <input type="time" name="tuesday_start_time[]" class="form-control" />-</div> <div class="p-0"> <input type="time" name="Tuesday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>'
        );
    });

    $(".wednesday_add").click(function() {
        ++i;
        $('#Wednesday').prop('checked', true);
        $("#wednesday_add").append(
            '<tr> <td> <div class="container"> <div class="row mb-2"> <div class=" p-0 d-flex align-items-center"> <input type="time" name="wednesday_start_time[]" class="form-control" />-</div> <div class=" p-0"> <input type="time" name="wednesday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>'
        );
    });

    $(".thrusday_add").click(function() {
        ++i;
        $('#thrusday').prop('checked', true);
        $("#thrusday_add").append(
            '<tr> <td> <div class="container"> <div class="row mb-2"> <div class=" p-0 d-flex align-items-center"> <input type="time" name="thursday_start_time[]" class="form-control" />-</div> <div class=" p-0"> <input type="time" name="thursday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>'
        );
    });

    $(".friday_add").click(function() {
        ++i;
        $('#friday').prop('checked', true);
        $("#friday_add").append(
            '<tr> <td> <div class="container"> <div class="row mb-2"> <div class=" p-0 d-flex align-items-center"> <input type="time" name="friday_start_time[]" class="form-control" />-</div> <div class=" p-0"> <input type="time" name="friday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>'
        );
    });

    $(".saturday_add").click(function() {
        ++i;
        $('#saturday').prop('checked', true);
        $("#saturday_add").append(
            '<tr> <td> <div class="container"> <div class="row mb-2"> <div class=" p-0 d-flex align-items-center"> <input type="time" name="saturday_start_time[]" class="form-control" />-</div> <div class=" p-0"> <input type="time" name="saturday_end_time[]"  class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>'
        );
    });

    $(".sunday_add").click(function() {
        ++i;
        $('#sunday').prop('checked', true);
        $("#sunday_add").append(
            '<tr> <td> <div class="container"> <div class="row mb-2"> <div class=" p-0 d-flex align-items-center"> <input type="time" name="sunday_start_time[]" class="form-control" />-</div> <div class=" p-0"> <input type="time" name="sunday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>'
        );
    });

    $(document).on('click', '.remove-tr', function() {

        if ($(this).closest('tr').is('tr:only-child')) {

            // $('#sunday').prop('checked', false);

            $(this).closest('tr').remove();
        } else {
            $(this).closest('tr').remove();
        }

    });
</script>

<script>
    $(document).ready(function() {
        $(".location-show").click(function() {
            $('.location_input').show();
        });

        $(".location-hide").click(function() {
            $('.location_input').hide();
        });

    });

    var input = document.getElementById('locations');
    var autocomplete = new google.maps.places.Autocomplete(input);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var place = autocomplete.getPlace();

        alert(lat + ", " + long);

    });

    $('.js-example-basic-multiple').select2();
</script>

<script type="text/javascript">
    <?php if(session('success')){ ?>
    toastr.success("<?php echo session('success'); ?>");
    <?php }else if(session('error')){  ?>
    toastr.error("<?php echo session('error'); ?>");
    <?php }else if(session('warning')){  ?>
    toastr.warning("<?php echo session('warning'); ?>");
    <?php }else if(session('info')){  ?>
    toastr.info("<?php echo session('info'); ?>");

    <?php } ?>
    $(document).ready(function() {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function() {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

        $(".submit").click(function() {
            return false;
        })

        // validation

        window.onload = function() {
            document.getElementById("Next1").disabled = false;
            document.getElementById("Next2").disabled = true;
            document.getElementsByClassName('error-message')[0].style.display = 'none';
            document.getElementsByClassName('error-message')[1].style.display = 'none';
            // document.getElementsByClassName('error-message')[2].style.display = 'none';
            // document.getElementsByClassName('error-message')[3].style.display = 'none';
            // document.getElementsByClassName('error-message')[4].style.display = 'none';
            $('.location_input').hide();
            $('.ads_video_upload').hide();
            $('.tag_url').hide();
        };

        $('.form-card').on('keyup keypress blur change click mouseover', function(event) {

            // var household_income_val = $("input[type='radio'][name='household_income']:checked").val();
            // var gender_val = $("#gender").val();

            // var age_validation = new Array();
            // $('.age:checked').each(function() {
            //     age_validation.push($(this).val());
            // });

            var ads_name_val = $("#ads_name").val();
            var ads_path_val = $("#ads_path").val();
            var ads_video_val = $("#ads_video").val();
            var Ads_type = $(".ads_type").val();

            // if (age_validation != "" && household_income_val != null && gender_val != null) {
            //     document.getElementsByClassName("error-message")[0].style.display = "none";
            //     document.getElementsByClassName('error-message')[1].style.display = 'none';
            //     document.getElementsByClassName('error-message')[2].style.display = 'none';

            //     document.getElementById("Next1").disabled = false;
            // } else {
            //     document.getElementsByClassName('error-message')[0].style.display = 'block';
            //     document.getElementsByClassName('error-message')[1].style.display = 'block';
            //     document.getElementsByClassName('error-message')[2].style.display = 'block';

            //     document.getElementById("Next1").disabled = true;
            // }

            if (ads_name_val != '' && Ads_type != 'null') {

                document.getElementsByClassName("error-message")[0].style.display = "none";
                document.getElementsByClassName('error-message')[1].style.display = 'none';

                document.getElementById("Next2").disabled = false;
            } else {

                document.getElementsByClassName("error-message")[0].style.display = "block";
                document.getElementsByClassName('error-message')[1].style.display = 'block';

                document.getElementById("Next2").disabled = true;
            }
        });
    });
    $(document).ready(function() {
        $('.tag_url, .ads_video_upload').hide();

        $(".ads_type").change(function() {
            $('.tag_url, .ads_video_upload').hide();
            var ads_type = $('.ads_type').val();

            if (ads_type === 'tag_url') {
                $('.tag_url').show();
            } else if (ads_type === 'ads_video_upload') {
                $('.ads_video_upload').show();
            }
        });
    });


</script>

</body>

</html>
