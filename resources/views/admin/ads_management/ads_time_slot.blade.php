@extends('admin.master')

    @section('css')
        <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <style>
        .form-control{
            height: 45px;
        }
    </style>

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
                        <fieldset>
                            <div class="form-card">

                                <td>
                                    <div class="row">
                                        <div class="col-md-2 p-0 d-flex align-items-center">
                                            <input type="time" class="form-control" />-</div>
                                
                                        <div class="col-md-2 p-0">
                                            <input type="time" class="form-control" id=""  />
                                        </div>
                                    </div>
                                <td>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Set your weekly hours</label>
                        
                                        <div class="row">
                                            <div class="col-sm-4"><label for=""> Monday </label></div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" id="" class="date" name="date[]" value="Monday" />
                                                <span id="" class="Monday_add ">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            <table class="table col-md-12" id="Monday_add"> </table>
                                        </div>
                        
                                        <div class="row dates">
                                            <div class="col-sm-4"><label for=""> Tuesday </label></div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="" name="date[]" value="Tuesday" />

                                                <span id="" class="Tuesday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>

                                                <table class="table" id="Tuesday_add"> </table>


                                            </div>
                                        </div>
                        
                                        <div class="row dates">
                                            <div class="col-sm-4"><label for=""> Wednesday </label></div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="" name="date[]" value="Wednesday" />

                                                <span  class="wednesday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>

                                                <table class="table" id="wednesday_add"> </table>


                                            </div>
                                        </div>
                        
                                        <div class="row dates">
                                            <div class="col-sm-4"><label for=""> Thrusday </label></div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="" name="date[]" value="Thrusday" />

                                                <span id="add" class="thrusday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>

                                                <table class="table" id="thrusday_add"> </table>

                                                
                                            </div>
                                        </div>
                        
                                        <div class="row dates">
                                            <div class="col-sm-4"><label for="">Friday </label></div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="" name="date[]" value="Friday" />

                                                <span id="add" class="friday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>

                                                <table class="table" id="friday_add"> </table>

                                            </div>
                                        </div>
                        
                                        <div class="row dates">
                                            <div class="col-sm-4"><label for="">Saturday </label></div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="" name="date[]" value="Saturday" />

                                                <span id="add" class="saturday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>

                                                <table class="table" id="saturday_add"> </table>


                                            </div>
                                        </div>
                        
                                        <div class="row dates">
                                            <div class="col-sm-4"><label for="">Sunday </label></div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="date" id="" name="date[]" value="unknown" />

                                                <span id="add" class="sunday_add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>

                                                <table class="table" id="sunday_add"> </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <input type="submit" class="btn btn-primary action-button" id="submit-update-cat" value="Save" /> --}}
                         </fieldset>
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
           $("#Monday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-2 p-0 d-flex align-items-center"> <input type="time" class="form-control" />-</div> <div class="col-md-2 p-0"> <input type="time" class="form-control" id=""/> </div> </div> </div> <td>      <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
       });
      
       $(document).on('click', '.remove-tr', function(){  
            $(this).parents('tr').remove();
       }); 
</script>





