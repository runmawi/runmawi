@extends('admin.master')

    @section('css')
        <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

{{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Ads Time Slot</h4>
                        </div>
                    </div>
                    <div class="iq-card-body table-responsive">
                        <form  accept-charset="UTF-8" action="{{ URL::to('admin/AdsTimeSlot_Save') }}" method="post" >
                        @csrf
                        <fieldset>
                            <div class="form-card">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Set your weekly hours</label>
                    
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" id="Monday" class="date" name="date[]" value="Monday" @if(!empty($Monday_time['0'])) checked @endif/>
                                                <label for="">Monday</label>
                                                <span id="" class="Monday_add ">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($Monday_time as $Monday_times)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-4 p-0 d-flex align-items-center">
                                                                        <input type="time" name="Monday_Start_time[]" class="form-control" value={{  $Monday_times->start_time }} />
                                                                        -</div>
                                                                    <div class="col-md-4 p-0">
                                                                        <input type="time" name="Monday_end_time[]" class="form-control" id="" value={{  $Monday_times->end_time }} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty

                                            @endforelse

                                            <table class="table col-md-12" id="Monday_add"> </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" id="Tuesday" class="date" name="date[]" value="Tuesday" @if(!empty($Tuesday_time['0'])) checked @endif />
                                                <label for=""> Tuesday </label>
                                                <span id="" class="Tuesday_add ">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($Tuesday_time as $tuesday_tym)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="tuesday_start_time[]" class="form-control" value="{{ $tuesday_tym->start_time }}" />-</div>
                                                                    <div class="col-md-4 p-0"><input type="time" name="Tuesday_end_time[]" class="form-control" id="" value="{{ $tuesday_tym->end_time }}" /></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                                
                                            @endforelse

                                            <table class="table col-md-12" id="Tuesday_add"> </table>
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="checkbox" class="date" id="Wednesday" name="date[]" value="Wednesday" @if(!empty($Wednesday_time['0'])) checked @endif />
                                                <label for=""> Wednesday </label>
                                                <span  class="wednesday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($Wednesday_time as $tym)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="wednesday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-</div>
                                                                    <div class="col-md-4 p-0"><input type="time" name="wednesday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" /></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                            @endforelse

                                            <table class="table col-md-12" id="wednesday_add"> </table>
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="thrusday" name="date[]" value="Thrusday"  @if(!empty($Thursday_time['0'])) checked @endif />
                                                <label for=""> Thrusday </label>
                                                <span id="add" class="thrusday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($Thursday_time as $tym)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="thursday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-</div>
                                                                    <div class="col-md-4 p-0"><input type="time" name="thursday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" /></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                            @endforelse

                                            <table class="table col-md-12" id="thrusday_add"> </table>
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="friday" name="date[]" value="Friday"  @if(!empty($Friday_time['0'])) checked @endif />
                                                <label for="">Friday </label>
                                                <span id="add" class="friday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($Friday_time as $tym)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-4 p-0 d-flex align-items-center">
                                                                        <input type="time" name="friday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-
                                                                    </div>
                                                                    <div class="col-md-4 p-0">
                                                                        <input type="time" name="friday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                            @endforelse

                                            <table class="table" id="friday_add"> </table>
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="saturday" name="date[]" value="Saturday" @if(!empty($Saturday_time['0'])) checked @endif />
                                                <label for="">Saturday </label>
                                                <span id="add" class="saturday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($Saturday_time as $tym)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="saturday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-</div>
                                                                    <div class="col-md-4 p-0"><input type="time" name="saturday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" /></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                            @endforelse

                                            <table class="table" id="saturday_add"> </table>
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="sunday" name="date[]" value="Sunday"  @if(!empty($Sunday_time['0'])) checked @endif/>
                                                <label for="">Sunday </label>
                                                <span id="add" class="sunday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            @forelse ($Sunday_time as $tym)
                                                <table class="table col-md-12" id=""> 
                                                    <tr>
                                                        <td>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="sunday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-</div>
                                                                    <div class="col-md-4 p-0"><input type="time" name="sunday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" /></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                                    </tr>
                                                </table>
                                            @empty
                                            @endforelse

                                            <table class="table" id="sunday_add"> </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary action-button" id="" value="Save" />
                         </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        var i = 0;

        $(".Monday_add").click(function(){
                ++i;
                $('#Monday').prop('checked', true);
                $("#Monday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="Monday_Start_time[]"   class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="Monday_end_time[]" class="form-control" id=""/> </div> </div> </div> </td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
            });

        $(".Tuesday_add").click(function(){
                ++i;
                $('#Tuesday').prop('checked', true);
                $("#Tuesday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="tuesday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="Tuesday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
            });

       $(".wednesday_add").click(function(){
           ++i;
           $('#Wednesday').prop('checked', true);
           $("#wednesday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="wednesday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="wednesday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
       });

       $(".thrusday_add").click(function(){
           ++i;
           $('#thrusday').prop('checked', true);
           $("#thrusday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="thursday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="thursday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
       });

       $(".friday_add").click(function(){
           ++i;
           $('#friday').prop('checked', true);
           $("#friday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="friday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="friday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
       });

       $(".saturday_add").click(function(){
           ++i;
           $('#saturday').prop('checked', true);
           $("#saturday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="saturday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="saturday_end_time[]"  class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
       });

       $(".sunday_add").click(function(){
           ++i;
           $('#sunday').prop('checked', true);
           $("#sunday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="sunday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="sunday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
       });

       $(document).on('click', '.remove-tr', function(){

            if( $(this).closest('tr').is('tr:only-child') ) {

                // $('#sunday').prop('checked', false);

                $(this).closest('tr').remove();
            }
            else {
                $(this).closest('tr').remove();
            }

       }); 
     
</script>







